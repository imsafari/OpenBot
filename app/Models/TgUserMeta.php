<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TgUserMeta extends Model
{
    use HasFactory;

    protected $fillable = [
        "property",
        "content",
        "description",
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(TgUser::class);
    }
}
