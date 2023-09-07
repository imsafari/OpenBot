<?php

namespace App\BotServices\UpdateHandlers;

use App\BotServices\Chat;
use App\BotServices\ConversationLayer\ConversationHandlerInterface;
use App\BotServices\User;
use Illuminate\Support\Facades\App;
use Longman\TelegramBot\Entities\Update;

class PollHandler extends BaseHandler implements UpdateHandlerInterface
{
    public function __construct(
        public Update $update,
    )
    {
    }


    public function chatType(): string
    {
        //everywhere
        return "";
    }

    public function getChat(): ?Chat
    {
        return null;
    }

    public function getUser(): ?User
    {
        return null;
    }

    public function doAction(): void
    {
        //todo: run poll responder
    }
}
