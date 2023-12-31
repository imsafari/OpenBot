<?php

namespace App\BotServices\UpdateHandlers;

use App\BotServices\Chat;
use App\BotServices\Interfaces\UpdateHandlerInterface;
use App\BotServices\User;
use Longman\TelegramBot\Entities\Update;

class MyChatMemberHandler extends BaseHandler implements UpdateHandlerInterface
{
    public function __construct(
        public Update $update
    )
    {
    }


    public function chatType(): string
    {
        //private or group or supergroup or channel
        return $this->update->getMyChatMember()->getChat()->getType();
    }

    public function getChat(): ?Chat
    {
        $chatMember = $this->update->getMyChatMember();

        return new Chat(...[
            "id" => (string)$chatMember->getChat()->getId(),
            "type" => $chatMember->getChat()->getType(),
            "title" => $chatMember->getChat()->getTitle(),
            "username" => $chatMember->getChat()->getUsername(),
            "first_name" => $chatMember->getChat()->getFirstName(),
            "last_name" => $chatMember->getChat()->getLastName(),
            "message_id" => null,
        ]);
    }

    public function getUser(): ?User
    {
        $from = $this->update->getChatMember()->getFrom();

        return new User(...[
            "id" => (string)$from->getId(),
            "is_bot" => $from->getIsBot(),
            "first_name" => $from->getFirstName(),
            "last_name" => $from->getLastName(),
            "username" => $from->getUsername(),
            "language_code" => $from->getLanguageCode(),
            "is_premium" => $from->getIsPremium(),
            "added_to_attachment_menu" => $from->getAddedToAttachmentMenu(),
        ]);
    }

    public function doAction(): void
    {
        //todo: run my chat member responder
    }
}
