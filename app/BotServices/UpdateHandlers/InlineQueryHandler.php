<?php

namespace App\BotServices\UpdateHandlers;

use App\BotServices\ConversationLayer\ConversationManager;
use Longman\TelegramBot\Entities\Update;

class InlineQueryHandler extends BaseHandler  implements UpdateHandlerInterface
{
    public function __construct(
        public Update              $update
    )
    {
    }

    public function chatType(): string
    {
        return $this->update->getInlineQuery()->getChatType();
    }

    public function doAction(): void
    {
        // TODO: Implement doAction() method.
    }
}
