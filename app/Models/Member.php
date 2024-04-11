<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_UNAPPROVED = 0;

    const STATUS_ACTIVE = 1;

    const STATUS_NONACTIVE = -1;

    const ARR_STATUS = [
        0 => 'Unapproved',
        1 => 'Active',
        -1 => 'Non Active',
    ];

    const ARR_MARITAL_STATUS = [
        'S' => 'Single',
        'M' => 'Married',
        'J' => 'Widdow',
        'D' => 'Widdower',
    ];

    protected $guarded = ["id", "created_at","updated_at"];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class, "family_id");
    }

    public function churchGroups(): BelongsToMany
    {
        return $this->belongsToMany(ChurchGroup::class, "member_church_group", "member_id", "church_group_id");
    }
}
