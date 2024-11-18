<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Services\LeadsProvider\LeadsProviderService;

class ContactController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create($leadID)
    {
        $leadID = (int) $leadID;
        if ($leadID < 1)
            return redirect()->to(route('leads'));

        return inertia('Contact/Create', [
            'lead_id' => $leadID,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request)
    {
        $leadsProvider = new LeadsProviderService();
        $leadsProvider->addContact(
            $request->lead_id,
            $request->name,
            $request->phone,
            $request->common_note,
        );

        return redirect()->to(route('leads'));
    }
}
