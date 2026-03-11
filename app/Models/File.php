<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class File extends Model
{
    /** @use HasFactory<\Database\Factories\FileFactory> */
    use HasFactory;

    protected $fillable = [
        "name",
        "path",
        "size",
        "mime",
        "extension",
        "folder_id",
        "user_id",
    ];

    protected $guarded = ["id"];

    protected $casts = [
        "size" => "integer",
        "hash" => "string",
    ];

    protected $hidden = ["created_at", "updated_at"];

    // ================================== RELATIONSHIPS ==================================

    /**
     * Get the folder the file is in.
     *
     * @return BelongsTo
     */
    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    /**
     * Get the user that owns this file.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Return a list of tags for this file.
     *
     * @return MorphToMany
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, "taggable");
    }

    // ==================================== ACCESSORS ====================================

    public function getNamedAttribute(): string
    {
        if (empty($this->name)) {
            return "Unnamed";
        }

        if (empty($this->extension)) {
            return $this->name;
        }

        return "{$this->name}.{$this->extension}";
    }

    public function getFormattedSizeAttribute(): string
    {
        $size = (int) ($this->size ?? 0);

        if ($size < 1024) {
            return $size === 1 ? "1 byte" : "{$size} bytes";
        }

        $units = ["KB", "MB", "GB"];
        $value = $size / 1024;
        $lastUnit = end($units);

        foreach ($units as $unit) {
            if ($value < 1024 || $unit === $lastUnit) {
                // Format with up to two decimal places and trim unnecessary zeros
                $formatted = number_format($value, 2, ".", "");
                $formatted = rtrim(rtrim($formatted, "0"), ".");
                return "{$formatted} {$unit}";
            }

            $value /= 1024;
        }

        // Fallback (shouldn't be reached)
        return "{$size} bytes";
    }
}
