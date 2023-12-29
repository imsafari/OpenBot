<?php

namespace App\BotServices\ConversationLayer\Steps\Private;

use App\BotServices\Contexts\BotContext;
use App\BotServices\Contexts\StepContext;
use App\BotServices\ConversationLayer\Steps\BaseStep;
use App\BotServices\Enums\PrivateState;
use App\BotServices\Interfaces\StepInterface;
use App\BotServices\Interfaces\UpdateHandlerInterface;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Request;

class MainMenuStep extends BaseStep implements StepInterface
{
    const StateName = PrivateState::MainMenu->value;
    protected array $qualifications = [
        "state" => PrivateState::MainMenu->value,
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
        $user = $this->updateHandler->getUser();
        Request::sendMessage([
            "chat_id" => $user->id,
            "text" => __("bot/private.main"),
        ]);
    }

    public function isQualified(): bool
    {
        $conversation = $this->botContext->conversation->getOriginal();
        if ($conversation["state"] != $this->qualifications["state"])
            return false;

        //step is qualified
        return true;
    }

    public function onEnter(string $enterState): void
    {
        if ($enterState != self::StateName)
            return;


        Request::sendMessage([
            "chat_id" => $this->updateHandler->getUser()->id,
            "text" => __("bot/private.main"),
        ]);

    }
}
