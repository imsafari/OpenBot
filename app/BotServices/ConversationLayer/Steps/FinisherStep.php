<?php

namespace App\BotServices\ConversationLayer\Steps;

use App\BotServices\Contexts\BotContext;
use App\BotServices\Contexts\StepContext;
use App\BotServices\Enums\ConversationState;
use App\BotServices\Interfaces\StepInterface;
use App\BotServices\Interfaces\UpdateHandlerInterface;
use Longman\TelegramBot\Entities\Update;

class FinisherStep extends BaseStep implements StepInterface
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

    public function handle(): void
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
