<?php

namespace App\BotServices\ConversationLayer\ConversationSteps;

use App\BotServices\ConversationLayer\ConversationInterface;
use App\BotServices\Enums\ChatType;
use App\BotServices\Enums\PrivateState;

class SimpleStep extends BaseStep implements StepInterface
{
    protected array $qualifications = [
        "chat_type" => ChatType::Private,
        "step" => PrivateState::Start,
        "auth" => ["user"],
    ];

    public function isQualified(ConversationInterface $conversation): bool
    {
        return true;
    }
}
