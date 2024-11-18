<?php

namespace App\Services\LeadsProvider;

use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use App\Services\LeadsProvider\Providers\AmoCRM;
use Illuminate\Support\Carbon;

/**
 * Сервис взаимодействия с источником лидов.
 * Получает и изменяет необходимую приложению информацию.
 */
class LeadsProviderService
{
    public const array PROVIDERS = [
        'amocrm' => AmoCRM::class,
    ];

    private LeadsProviderInterface $provider;

    /**
     * Create a new class instance.
     */
    public function __construct() {
        $className = self::PROVIDERS[config('leads.provider')];
        $this->provider = new $className();
    }

    /**
     * Получает список лидов - массив с информацией об ID лида в источнике,
     * названии сделки, наличии контакта, дате создания (UnixTimestamp)
     * и локализованной дате создания.
     * Массив отсортирован по дате создания (по убыванию).
     *
     * @return array
     */
    public function getLeads(): array
    {
        $leads = array_map(function ($lead) { return [
            'id' => $lead['id'],
            'name' => $lead['name'],
            'has_contact' => (bool) array_key_exists('contacts', $lead),
            'created_at' => Carbon::createFromTimestamp($lead['created_at']),
            'created_at_local' => Carbon::createFromTimestamp($lead['created_at'])->translatedFormat('j F Y в H:m:i'),
        ]; }, $this->provider->getLeads());

        array_multisort(
            array_column($leads, 'created_at'),
            SORT_DESC, $leads);

        return $leads;
    }

    /**
     * Привязывает контакт к сделке.
     *
     * @param int $leadID - ID сделки в источнике.
     * @param string $name - Имя контакта.
     * @param string $phone - Номер телефона контакта.
     * @param string $commonNote - Примечание о контакте.
     */
    public function addContact(
        int     $leadID,
        string  $name,
        string  $phone,
        string  $commonNote): void
    {
        $this->provider->addContact($leadID, $name, $phone, $commonNote);
    }
}
