<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChurchGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        "id", "updated_at", "created_at"
    ];

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'member_church_group', 'church_group_id', 'member_id');
    }
}
