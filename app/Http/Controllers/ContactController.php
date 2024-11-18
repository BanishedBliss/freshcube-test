<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Services\LeadsProvider\LeadsProviderService;

class ContactController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Contact/CreateForm', []);
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
            $request->comment,
        );

        return redirect()->to(route('leads'));
    }
}
