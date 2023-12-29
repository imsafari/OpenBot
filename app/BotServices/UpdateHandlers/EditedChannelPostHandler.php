<?php

namespace App\BotServices\UpdateHandlers;

use App\BotServices\Chat;
use App\BotServices\Interfaces\UpdateHandlerInterface;
use App\BotServices\User;
use Longman\TelegramBot\Entities\Update;

class EditedChannelPostHandler extends BaseHandler  implements UpdateHandlerInterface
{
    public function __construct(
        public Update $update
    )
    {
    }


    public function chatType(): string
    {
        //channel
        return $this->update->getEditedChannelPost()->getChat()->getType();
    }

    public function getChat(): ?Chat
    {
        $message = $this->update->getEditedChannelPost();

        return new Chat(...[
            "id" => (string)$message->getChat()->getId(),
            "type" => $message->getChat()->getType(),
            "title" => $message->getChat()->getTitle(),
            "username" => $message->getChat()->getUsername(),
            "first_name" => $message->getChat()->getFirstName(),
            "last_name" => $message->getChat()->getLastName(),
            "message_id" => $message->getMessageId(),
        ]);
    }

    public function getUser(): ?User
    {
        return null;
    }

    public function doAction(): void
    {
        //todo: run edit channel post responder
    }
}
