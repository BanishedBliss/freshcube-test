<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Carbon;

class LeadCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'has_contact' => (bool) $this->whenHas('contacts'),
            'created_at' => Carbon::createFromTimestamp($this->created_at)->toDateTimeLocalString(),
        ];
    }
}
