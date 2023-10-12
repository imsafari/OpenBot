<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        "chat_id",
        "chat_type",
        "title",
        "state",
        "first_message_id",
        "last_message_id",
        "banned_at"
    ];

    public function channel(): HasOne
    {
        return $this->hasOne(Channel::class);
    }

    public function private(): HasOne
    {
        return $this->hasOne(TgUser::class);
    }

    public function group(): HasOne
    {
        return $this->hasOne(Group::class);
    }

    public function chat(): MorphTo
    {
        return $this->morphTo();
    }

    public function meta(): HasMany
    {
        return $this->hasMany(ConversationMeta::class);
    }

}
