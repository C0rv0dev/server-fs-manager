<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    /** @use HasFactory<\Database\Factories\TagFactory> */
    use HasFactory;

    protected $fillable = ["name", "slug"];

    protected $guarded = ["id"];

    protected $casts = [];

    protected $hidden = ["created_at", "updated_at"];

    // ================================== RELATIONSHIPS ==================================

    /**
     * Get all files related to this tag.
     *
     * @return MorphToMany
     */
    public function files(): MorphToMany
    {
        return $this->morphToMany(File::class, "taggable");
    }

    /**
     * Get all folders related to this tag.
     *
     * @return MorphToMany
     */
    public function folders(): MorphToMany
    {
        return $this->morphToMany(Folder::class, "taggable");
    }
}
