<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Folder extends Model
{
    /** @use HasFactory<\Database\Factories\FolderFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ["name", "path", "hash", "parent_id", "user_id"];

    protected $guarded = ["id"];

    protected $casts = [
        "hash" => "string",
    ];

    protected $hidden = ["created_at", "updated_at"];

    // ====================================== BOOT ======================================
    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (empty($model->hash)) {
                $name = (string) ($model->name ?? "");
                $model->hash = hash("sha256", $name);
            }
        });
    }

    // ================================== RELATIONSHIPS ==================================

    /**
     * Get the parent folder of this folder.
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Folder::class, "parent_id");
    }

    /**
     * Get the children folders of this folder.
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Folder::class, "parent_id", "id");
    }

    /**
     * Get the files in this folder.
     *
     * @return HasMany
     */
    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

    /**
     * Return a list of favorite folders.
     *
     * @return MorphMany
     */
    public function favorites(): MorphMany
    {
        return $this->morphMany(Star::class, "starrable");
    }

    /**
     * Get the tags associated with this folder.
     *
     * @return MorphToMany
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, "taggable");
    }

    /**
     * Get the user who owns this folder.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
