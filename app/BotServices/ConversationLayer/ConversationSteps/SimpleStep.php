<?php

namespace App\BotServices\ConversationLayer\ConversationSteps;

use App\BotServices\ConversationLayer\ConversationHandlerInterface;
use App\BotServices\Enums\ChatType;
use App\BotServices\Enums\PrivateState;

class SimpleStep extends BaseStep implements StepInterface
{
    protected array $qualifications = [
        "chat_type" => ChatType::Private,
        "step" => PrivateState::Start,
        "auth" => ["user"],
    ];

    public function isQualified(ConversationHandlerInterface $conversation): bool
    {
        return true;
    }
}
