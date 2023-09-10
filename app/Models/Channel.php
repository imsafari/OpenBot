<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Channel extends Model
{
    use HasFactory;

    protected $fillable = [
        "chat_id",
        "title",
        "username",
    ];

    public function meta(): HasMany
    {
        return $this->hasMany(ChannelMeta::class);
    }

    public function conversation(): MorphOne
    {
        return $this->morphOne(Conversation::class, "chat");
    }
}
