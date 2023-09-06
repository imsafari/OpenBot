<?php

namespace App\BotServices\ConversationLayer\ConversationSteps;

use App\BotServices\BotContext;
use App\BotServices\Enums\ChatType;
use App\BotServices\Enums\PrivateState;
use App\BotServices\UpdateHandlers\UpdateHandlerInterface;

class PrivateStartStep extends BaseStep implements StepInterface
{
    protected array $qualifications = [
        "chat_type" => ChatType::Private->value,
        "step" => PrivateState::Start->value,
    ];

    public function __construct(
        public BotContext             $botContext,
        public StepContext            $context,
        public UpdateHandlerInterface $updateHandler,
    )
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

        if ($this->botContext->conversation->state != $this->qualifications["step"])
            return false;

        echo "i'm qualified";
        return true;
    }

}
