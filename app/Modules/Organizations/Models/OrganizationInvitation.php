<?php

namespace App\Modules\Organizations\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class OrganizationInvitation extends Model
{
    use HasUuids;

    protected $fillable = [
        'organization_id',
        'email',
        'role_name',
        'invited_by_member_id',
        'token',
        'expires_at',
        'accepted_at',
    ];
}
