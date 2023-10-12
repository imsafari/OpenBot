<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversationMeta extends Model
{
    use HasFactory;

    protected $fillable = [
        "property",
        "content",
        "description",
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
