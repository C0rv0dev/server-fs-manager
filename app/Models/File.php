<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class File extends Model
{
    /** @use HasFactory<\Database\Factories\FileFactory> */
    use HasFactory;

    protected $fillable = ["name", "path", "size", "mime", "extension", "hash"];

    protected $guarded = ["id"];

    protected $casts = [
        "size" => "integer",
        "hash" => "string",
    ];

    protected $hidden = ["created_at", "updated_at"];

    // ================================== RELATIONSHIPS ==================================

    /**
     * Return a list of tags for this file.
     *
     * @return MorphToMany
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, "taggable");
    }
}
