<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        "id", "created_at", "updated_at"
    ];

    protected $casts = [
        "published_at" => "date"
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, "post_category", "post_id", "category_id");
    }

    public function getCoverFullUrlattribute(): string
    {
        return $this->cover
            ? url("/storage/" . $this->cover)
            : '';
    }

    public function getContentShortAttribute(): string
    {
        $cleanText = strip_tags($this->content);
        return Str::words($cleanText, 30);
    }
}
