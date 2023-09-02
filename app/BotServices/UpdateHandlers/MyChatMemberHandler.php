<?php

namespace App\BotServices\UpdateHandlers;

use App\BotServices\ConversationLayer\ConversationManager;
use Longman\TelegramBot\Entities\Update;

class MyChatMemberHandler extends BaseHandler  implements UpdateHandlerInterface
{
    public function __construct(
        public Update              $update
    )
    {
    }

    public function chatType(): string
    {
        return $this->update->getMyChatMember()->getChat()->getType();
    }

    public function doAction(): void
    {
        // TODO: Implement doAction() method.
    }
}
