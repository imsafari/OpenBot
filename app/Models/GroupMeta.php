<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupMeta extends Model
{
    use HasFactory;

    protected $fillable = [
        "property",
        "content",
        "description",
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
