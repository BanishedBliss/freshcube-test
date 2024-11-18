<?php

namespace App\Http\Controllers;

use App\Services\LeadsProvider\LeadsProviderService;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leadsProvider = new LeadsProviderService();
        $leads = $leadsProvider->getLeads()->paginate();

        return inertia("Lead/Index", [$leads]);
    }
}
