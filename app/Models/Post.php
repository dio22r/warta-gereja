<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        "id", "created_at", "updated_at"
    ];


    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, "post_category", "post_id", "category_id");
    }
}
