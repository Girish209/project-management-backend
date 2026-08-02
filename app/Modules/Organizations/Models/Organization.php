<?php

namespace App\Modules\Organizations\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = ['name', 'slug', 'logo_path', 'timezone', 'settings', 'owner_id'];

    public function members(){
        return $this->hasMany(OrganizationMember::class, 'organization_id');
    }

    public function owner(){
        return $this->belongsTo(User::class, 'owner_id');
    }
}
