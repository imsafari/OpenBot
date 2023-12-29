<?php

namespace App\BotServices\UpdateHandlers;

use App\BotServices\Chat;
use App\BotServices\Interfaces\UpdateHandlerInterface;
use App\BotServices\User;
use Longman\TelegramBot\Entities\Update;

class PreCheckoutQueryHandler extends BaseHandler  implements UpdateHandlerInterface
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
        $from = $this->update->getPreCheckoutQuery()->getFrom();

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
        //todo: run pre checkout query responder
    }
}
