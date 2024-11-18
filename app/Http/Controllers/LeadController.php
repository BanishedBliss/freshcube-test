<?php

namespace App\Http\Controllers;

use App\Services\LeadsProvider\LeadsProviderService;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $leadsProvider = new LeadsProviderService();
        $leads = $leadsProvider->getLeads();

        return inertia("Lead/Index", [
            'leads' => JsonResource::collection(
                $this->paginate($leads, ['path' => ''])
            )
        ]);
    }

    private function paginate($items, $options = [], $perPage = 10, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
