<?php

namespace App\BotServices\UpdateHandlers;

use App\BotServices\ConversationLayer\ConversationManager;
use App\BotServices\Enums\ChatType;
use Longman\TelegramBot\Entities\Update;

class PollAnswerHandler extends BaseHandler  implements UpdateHandlerInterface
{
    public function __construct(
        public Update              $update
    )
    {
    }

    public function chatType(): string
    {
        //todo: implement based on voter_chat
        return ChatType::Private->value;
    }

    public function doAction(): void
    {
        // TODO: Implement doAction() method.
    }
}
