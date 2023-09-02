<?php

namespace App\BotServices\UpdateHandlers;

use App\BotServices\ConversationLayer\ConversationManager;
use Longman\TelegramBot\Entities\Update;

class CallbackQueryHandler extends BaseHandler implements UpdateHandlerInterface
{
    public function __construct(
        public Update              $update
    )
    {
    }

    public function doAction(): void
    {
        // TODO: Implement doAction() method.
    }

    public function chatType(): string
    {
        return $this->update->getCallbackQuery()->getMessage()->getChat()->getType();
    }


}
