<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "username",
        "is_supergroup",
        "is_forum",
    ];

    public function meta(): HasMany
    {
        return $this->hasMany(GroupMeta::class);
    }


    public function conversation(): MorphOne
    {
        return $this->morphOne(Conversation::class, "chat");
    }
}
