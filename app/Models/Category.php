<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "title", "slug"
    ];

    public function post(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, "post_category", "category_id", "post_id");
    }
}
