<?php

namespace App\Http\Resources;

use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Projects */
class ProjectsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'client' => new ClientsResource($this->whenLoaded('clients')),
        ];
    }
}
