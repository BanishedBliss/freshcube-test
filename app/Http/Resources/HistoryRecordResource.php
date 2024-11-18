<?php

namespace App\Http\Resources;

use App\Models\HistoryRecord;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class HistoryRecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'action' => HistoryRecord::RECORD_TYPES[$this->action],
            'success' => (bool) $this->success,
            'result' => $this->result,
            'created_at' => (new Carbon($this->created_at))->translatedFormat('j F Y в H:m:i'),
        ];
    }
}
