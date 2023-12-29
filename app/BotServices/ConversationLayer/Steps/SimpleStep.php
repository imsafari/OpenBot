<?php

namespace App\BotServices\ConversationLayer\Steps;

use App\BotServices\Enums\ChatType;
use App\BotServices\Enums\PrivateState;
use App\BotServices\Interfaces\StepInterface;

class SimpleStep extends BaseStep implements StepInterface
{
    const StateName = "simple_state";

    protected array $qualifications = [
        "chat_type" => ChatType::Private->value,
        "state" => PrivateState::Start->value,
        "auth" => ["user"],
    ];

    public function isQualified(): bool
    {
        return true;
    }
}
