<?php

namespace App\Services\LeadsProvider;

use App\Services\LeadsProvider\Providers\AmoCRM;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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

    public function getLeads(): AnonymousResourceCollection
    {
        return $this->source->getLeads();
    }

    public function addContact(
        int     $leadID,
        string  $name,
        string  $phone,
        string  $comment)
    {
        return $this->source->addContact($leadID, $name, $phone, $comment);
    }
}
