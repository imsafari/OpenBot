<?php

namespace App\BotServices\ConversationLayer\Steps;

use App\BotServices\BotContext;
use App\BotServices\Enums\ConversationState;
use App\BotServices\UpdateHandlers\UpdateHandlerInterface;
use Longman\TelegramBot\Entities\Update;

class StarterStep extends BaseStep implements StepInterface
{
    protected array $qualifications = [
        "step" => ConversationState::Starter->value,
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
    }

    public function isQualified(): bool
    {
        //step is qualified
        return true;
    }

}
