<?php

namespace App\Modules\Organizations\Http\Resources;

use App\Modules\Identity\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Modules\Organizations\Models\OrganizationMember */
class OrganizationMemberResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'organization_id' => $this->organization_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'employee_code' => $this->employee_code,
            'phone' => $this->phone,
            'department' => $this->department,
            'designation' => $this->designation,
            'status' => $this->status,
            'joined_at' => $this->joined_at,
            'user' => UserResource::make($this->whenLoaded('user')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
