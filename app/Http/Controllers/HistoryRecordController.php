<?php

namespace App\Http\Controllers;

use App\Http\Resources\HistoryRecordResource;
use App\Models\HistoryRecord;
use Illuminate\Support\Facades\Log;

class HistoryRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $historyRecords = HistoryRecord::query()->orderBy('created_at', 'desc')->paginate(10);

        return inertia('History/Index', [
            'historyRecords' => HistoryRecordResource::collection($historyRecords)
        ]);
    }
}
