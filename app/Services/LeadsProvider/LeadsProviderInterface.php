<?php

namespace App\Services\LeadsProvider;

interface LeadsProviderInterface
{
    public function getLeads() : array;
    public function addContact(
        int     $leadID,
        string  $name,
        string  $phone,
        string  $commonNote);
}
