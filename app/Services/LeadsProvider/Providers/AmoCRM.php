<?php

namespace App\Services\LeadsProvider\Providers;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Collections\Leads\LeadsCollection;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Models\ContactModel;
use AmoCRM\Models\CustomFieldsValues\MultitextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\MultitextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\MultitextCustomFieldValueModel;
use AmoCRM\Models\LeadModel;
use AmoCRM\Models\NoteType\CommonNote;
use App\Http\Resources\LeadCollection;
use App\Services\LeadsProvider\LeadsProviderInterface;
use App\Services\LeadsProvider\Traits\AmoCRM\ApiClientAuthTrait;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Events\Contact\CreatedEvent     as ContactCreatedEvent;
use App\Events\Contact\CreateErrorEvent as ContactCreateErrorEvent;

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
     * @throws AmoCRMoAuthApiException
     * @throws AmoCRMApiException
     * @throws AmoCRMMissedTokenException
     */
    public function getLeads(): AnonymousResourceCollection
    {
        $leads = $this->apiClient
            ->leads()->get(null, ['contacts']);

        return LeadCollection::collection($leads->all());
    }

    public function addContact(
        int     $leadID,
        string  $name,
        string  $phone,
        string  $comment): void
    {
        // Создание модели существующей сделки для связи с новым контактом.
        $leads = new LeadsCollection();
        $lead = new LeadModel();
        $lead->setId($leadID);
        $leads->add($lead);

        // Создание нового контакта.
        $contact = new ContactModel();
        $contact->setName($name);
        $contact->setLeads($leads);
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

        // Передача данных API AmoCRM
        $contactFields->add($phoneField);
        $contact->setCustomFieldsValues($contactFields);
        try {
            $contact = $this->apiClient->contacts()->addOne($contact);
            if ($contact)
            {
                ContactCreatedEvent::dispatch($name, $phone, $comment);
            }
        } catch (AmoCRMApiException $e) {
            ContactCreateErrorEvent::dispatch($e->getMessage());
        }

        // Добавление примечания.
        $newContactID = $contact->getId();
        $note = new CommonNote();
        $note->setText($comment);
        $note->setEntityId($newContactID);
        try {
            $this->apiClient->notes($newContactID)->addOne($note);
        } catch (AmoCRMApiException $e) {
            ContactCreateErrorEvent::dispatch('Примечание - '. $e->getMessage());
        }
    }
}
