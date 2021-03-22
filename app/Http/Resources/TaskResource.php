<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'completed' => $this->completed(),
            'completed_at' => $this->completed_at() ? $this->completed_at()->diffForHumans() : 'Task not completed',
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
