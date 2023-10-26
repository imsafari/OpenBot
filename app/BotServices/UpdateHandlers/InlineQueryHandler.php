<?php

namespace App\BotServices\UpdateHandlers;

use App\BotServices\Chat;
use App\BotServices\ConversationLayer\ConversationHandlerInterface;
use App\BotServices\User;
use Longman\TelegramBot\Entities\Update;

class InlineQueryHandler extends BaseHandler implements UpdateHandlerInterface
{
    public function __construct(
        public Update $update
    )
    {
    }


    public function chatType(): string
    {
        //sender or private or group or supergroup or channel
        return $this->update->getInlineQuery()->getChatType();
    }

    public function getChat(): ?Chat
    {
        return null;
    }

    public function getUser(): ?User
    {
        $from = $this->update->getInlineQuery()->getFrom();

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
        //todo: run inline query responder
    }
}
