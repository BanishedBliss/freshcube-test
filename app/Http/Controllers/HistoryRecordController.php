<?php

namespace App\Http\Controllers;

use App\Models\HistoryRecord;
use App\Http\Requests\StoreHistoryRecordRequest;
use App\Http\Requests\UpdateHistoryRecordRequest;

class HistoryRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('History/Index', []);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHistoryRecordRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(HistoryRecord $historyRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HistoryRecord $historyRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHistoryRecordRequest $request, HistoryRecord $historyRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HistoryRecord $historyRecord)
    {
        //
    }
}
