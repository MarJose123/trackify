<?php

namespace App\Http\Resources;

use App\Models\Timer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Timer */
class TimerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'duration' => $this->duration,
            'status' => $this->status,
            'timer' => $this->timer,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'user_id' => $this->user_id,
            'clients_id' => $this->clients_id,
            'projects_id' => $this->projects_id,

            'user' => new UserResource($this->whenLoaded('user')),
            'clients' => new ClientsResource($this->whenLoaded('clients')),
            'projects' => new ProjectsResource($this->whenLoaded('projects')),
        ];
    }
}
