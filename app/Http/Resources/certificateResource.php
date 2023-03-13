<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class certificateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
           
            'name'=>$this->name,
            'age'=>$this->age,
            'note'=>$this->note,
            'user_id'=>$this->user_id,
            
        ];
    }
}
