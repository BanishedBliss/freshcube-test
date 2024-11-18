<?php

namespace App\Services\LeadsProvider\Providers;

use AmoCRM\Models\LinkModel;
use App\Services\LeadsProvider\LeadsProviderInterface;
use App\Services\LeadsProvider\Traits\AmoCRM\ApiClientAuthTrait;
use AmoCRM\Client\AmoCRMApiClient;

use AmoCRM\Models\LeadModel;
use AmoCRM\Models\ContactModel;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Models\CustomFieldsValues\MultitextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\MultitextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\MultitextCustomFieldValueModel;
use AmoCRM\Models\NoteType\CommonNote;

use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;

use App\Events\Contact\CreatedEvent     as ContactCreatedEvent;
use App\Events\Contact\CreateErrorEvent as ContactCreateErrorEvent;

/**
 * Сервис для работы с API AmoCRM в целях работы с лидами и контактами.
 */
class AmoCRM implements LeadsProviderInterface
{
    private AmoCRMApiClient|null $apiClient;
    use ApiClientAuthTrait;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->apiClientAuth($this->apiClient);
    }

    /**
     * Получает весь список лидов из панели указанного в конфигурации приложения аккаунта.
     */
    public function getLeads(): array
    {
        try {
            $leads = $this->apiClient
                ->leads()->get(null, ['contacts']);
        } catch (AmoCRMApiException $e) {
            die ('Код ошибки: ' . $e->getCode() . '. Ошибка: ' . $e->getMessage());
        }

        return $leads->toArray();
    }

    /**
     * Добавляет контакт к лиду в AmoCRM.
     * Вызывает события добавления контакта
     * для ведения истории действий в веб приложении.
     *
     * @param int $leadID - ID сделки в источнике.
     * @param string $name - Имя контакта.
     * @param string $phone - Номер телефона контакта.
     * @param string $commonNote - Примечание о контакте.
     *
     * @return void
     */
    public function addContact(
        int     $leadID,
        string  $name,
        string  $phone,
        string  $commonNote): void
    {
        // Создание модели существующей сделки для связи с новым контактом.
        $lead = new LeadModel();
        $lead->setId($leadID);

        // Создание нового контакта.
        $contact = new ContactModel();
        $contact->setName($name);
        $contactFields = new CustomFieldsValuesCollection();

        // Добавление значения поля "Телефон".
        $phoneField = new MultitextCustomFieldValuesModel();
        $phoneField->setFieldId(648711);
        $phoneField->setFieldCode('PHONE');
        $phoneField->setFieldName('Телефон');
        $phoneField->setValues(
            (new MultitextCustomFieldValueCollection())
                ->add((new MultitextCustomFieldValueModel())
                            ->setValue($phone)
                            ->setEnumId(1060993)
                            ->setEnum('WORK')));

        // Добавление контакта в AmoCRM
        $contactFields->add($phoneField);
        $contact->setCustomFieldsValues($contactFields);
        try {
            $contact = $this->apiClient->contacts()->addOne($contact);
            if ($contact)
            {
                ContactCreatedEvent::dispatch($leadID, $name, $phone, $commonNote);
            }
        } catch (AmoCRMApiException $e) {
            ContactCreateErrorEvent::dispatch($e->getMessage());
        }

        // Привязка контакта к сделке
        $link = new LinkModel();
        $link->setEntityType('leads');
        $link->setEntityId($leadID);
        $link->setToEntityType('contacts');
        $link->setToEntityId($contact->getId());
        try {
            $this->apiClient->leads()->link($lead, $link);
        } catch (AmoCRMApiException $e) {
            ContactCreateErrorEvent::dispatch('Примечание - ', $e->getMessage());
        }

        // Добавление примечания.
        $newContactID = $contact->getId();
        $note = new CommonNote();
        $note->setText($commonNote);
        $note->setEntityId($newContactID);
        try {
            $this->apiClient->notes('contacts')->addOne($note);
        } catch (AmoCRMApiException $e) {
            ContactCreateErrorEvent::dispatch('Примечание - '. $e->getMessage());
        }
    }
}
