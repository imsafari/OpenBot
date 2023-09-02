<?php

namespace App\BotServices\UpdateHandlers;

use App\BotServices\ConversationLayer\ConversationManager;
use Longman\TelegramBot\Entities\Update;

class ChatMemberHandler extends BaseHandler  implements UpdateHandlerInterface
{
    public function __construct(
        public Update              $update
    )
    {
    }

    public function chatType(): string
    {
        return $this->update->getChatMember()->getChat()->getType();
    }

    public function doAction(): void
    {
        // TODO: Implement doAction() method.
    }
}
