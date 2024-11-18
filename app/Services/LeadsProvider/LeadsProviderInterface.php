<?php

namespace App\Services\LeadsProvider;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface LeadsProviderInterface
{
    public function getLeads() : AnonymousResourceCollection;
    public function addContact(
        int $leadID,
        string $name,
        string $phone,
        string $comment);
}
