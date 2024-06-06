<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $web_site = new WebSiteResource($this->web_site);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'body' => $this->body,
            'web_site' => $web_site['name'],
        ];
    }
}
