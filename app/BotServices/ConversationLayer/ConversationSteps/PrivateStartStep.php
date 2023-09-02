<?php

namespace App\BotServices\ConversationLayer\ConversationSteps;

use App\BotServices\Chat;
use App\BotServices\ConversationLayer\ConversationInterface;
use App\BotServices\Enums\ChatType;
use App\BotServices\Enums\PrivateState;
use App\BotServices\UpdateHandlers\UpdateHandlerInterface;
use App\Models\Conversation;

class PrivateStartStep extends BaseStep implements StepInterface
{
    protected array $qualifications = [
        "chat_type" => ChatType::Private->value,
        "step" => PrivateState::Start->value,
    ];

    public function __construct(
        private StepContext            $context,
        private UpdateHandlerInterface $updateHandler)
    {
    }


    public function handle(): void
    {
//        $this->context->stop();
        echo "\n\nso handled well";
    }

    public function isQualified(): bool
    {
        $chat = $this->updateHandler->getChat();
        if ($chat->type != $this->qualifications["chat_type"])
            return false;

        if ($this->conversation->state != $this->qualifications["step"])
            return false;

        echo "i'm qualified";
        return true;
    }

}
