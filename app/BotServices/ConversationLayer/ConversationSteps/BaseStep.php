<?php

namespace App\BotServices\ConversationLayer\ConversationSteps;

use App\BotServices\ConversationLayer\ConversationHandlerInterface;

abstract class BaseStep
{
    protected array $qualifications = [
        "chat_type" => null, // null|true|empty mean for every chat type
        "step" => null, // null|true|empty mean for every step
        //"auth" => ["user"], // allowed tg user types or null|true|empty for everyone+
        //one of user meta
        //one of conversation meta
        //user age
        //user connection speed
        //user location
        //user language
        //user group role or title
        //user group permissions
        //message content
        //account age
        //subscription
        //time range 9 to 11
    ];

    public function isQualified(): bool
    {
        return false;
    }
}
