<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mortality extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        "id", "created_at", "updated_at"
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, "member_id");
    }
}
