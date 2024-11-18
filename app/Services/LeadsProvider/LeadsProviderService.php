<?php

namespace App\Services\LeadsProvider;

use App\Services\LeadsProvider\Providers\AmoCRM;
use Illuminate\Support\Carbon;

class LeadsProviderService
{
    public const array PROVIDERS = [
        'amocrm' => AmoCRM::class,
    ];

    private LeadsProviderInterface $source;

    /**
     * Create a new class instance.
     */
    public function __construct() {
        $className = self::PROVIDERS[config('leads.provider')];
        $this->source = new $className();
    }

    public function getLeads(): array
    {
        $leads = array_map(function ($lead) { return [
            'id' => $lead['id'],
            'name' => $lead['name'],
            'has_contact' => (bool) array_key_exists('contacts', $lead),
            'created_at' => Carbon::createFromTimestamp($lead['created_at']),
            'created_at_local' => Carbon::createFromTimestamp($lead['created_at'])->translatedFormat('j F Y в H:m:i'),
        ]; }, $this->source->getLeads());

        array_multisort(
            array_column($leads, 'created_at'),
            SORT_DESC, $leads);

        return $leads;
    }

    public function addContact(
        int     $leadID,
        string  $name,
        string  $phone,
        string  $commonNote)
    {
        return $this->source->addContact($leadID, $name, $phone, $commonNote);
    }
}
