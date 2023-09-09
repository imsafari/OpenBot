<?php

namespace App\BotServices\ConversationLayer\ConversationSteps;

use App\BotServices\BotContext;
use App\BotServices\Enums\ConversationState;
use App\BotServices\UpdateHandlers\UpdateHandlerInterface;
use Longman\TelegramBot\Entities\Update;

class ConversationFinisherStep extends BaseStep implements StepInterface
{
    protected array $qualifications = [
        "step" => ConversationState::Finisher->value,
    ];


    public function __construct(
        public BotContext             $botContext,
        public StepContext            $context,
        public UpdateHandlerInterface $updateHandler,
        public Update                 $update
    )
    {
    }

    public function onMessage(): void
    {
        if ($this->botContext->conversation->isDirty()) {
            $this->botContext->conversation->save();
        }
    }

    public function isQualified(): bool
    {
        //step is qualified
        return true;
    }

}
