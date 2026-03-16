<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Star extends Model
{
    /** @use HasFactory<\Database\Factories\StarFactory> */
    use HasFactory;

    protected $guarded = ["id", "created_at", "updated_at"];

    protected $fillable = ["user_id"];

    /**
     * Make this class a "pivot".
     *
     * @return MorphTo
     */
    public function starrable(): MorphTo
    {
        return $this->morphTo();
    }

    // ================================== RELATIONSHIPS ==================================

    /**
     * Get the user from the favorite item.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ===================================== METHODS =====================================

    public function isFile(): bool
    {
        return $this->starrable_type == File::class;
    }
}
