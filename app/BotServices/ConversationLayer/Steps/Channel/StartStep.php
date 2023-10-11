<?php

namespace App\BotServices\ConversationLayer\Steps\Channel;

use App\BotServices\BotContext;
use App\BotServices\ConversationLayer\Steps\BaseStep;
use App\BotServices\ConversationLayer\Steps\StepContext;
use App\BotServices\ConversationLayer\Steps\StepInterface;
use App\BotServices\Enums\ChannelState;
use App\BotServices\UpdateHandlers\UpdateHandlerInterface;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Request;

class StartStep extends BaseStep implements StepInterface
{
    const StateName = ChannelState::Start->value;

    protected array $qualifications = [
        "state" => ChannelState::Start->value,
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
        Request::sendMessage([
            "chat_id" => $this->updateHandler->getChat()->id,
            "text" => __("bot/channel.start"),
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

}
