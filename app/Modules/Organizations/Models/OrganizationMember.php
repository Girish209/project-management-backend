<?php

namespace App\Modules\Organizations\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationMember extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'user_id',
        'first_name',
        'last_name',
        'employee_code',
        'phone',
        'department',
        'designation',
        'status',
        'joined_at',
    ];

    public function organization(){
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
