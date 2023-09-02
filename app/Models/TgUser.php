<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class TgUser extends Model
{
    use HasFactory;

    protected $fillable = [
        "chat_id",
        "first_name",
        "last_name",
        "username",
        "phone",
        "language_code"
    ];

    public function meta(): HasMany
    {
        return $this->hasMany(TgUserMeta::class);
    }

    public function conversation(): MorphOne
    {
        return $this->morphOne(Conversation::class, "chat");
    }

}
