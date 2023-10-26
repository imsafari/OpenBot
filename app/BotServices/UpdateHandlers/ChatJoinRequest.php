<?php

namespace App\BotServices\UpdateHandlers;

use App\BotServices\Chat;
use App\BotServices\ConversationLayer\ConversationHandlerInterface;
use App\BotServices\User;
use Illuminate\Support\Facades\App;
use Longman\TelegramBot\Entities\Update;

class ChatJoinRequest extends BaseHandler implements UpdateHandlerInterface
{
    public function __construct(
        public Update $update
    )
    {
    }


    public function chatType(): string
    {
        //group or supergroup or channel
        return $this->update->getChatJoinRequest()->getChat()->getType();
    }

    public function getChat(): ?Chat
    {
        $chatJoinRequest = $this->update->getChatJoinRequest();

        return new Chat(...[
            "id" => (string)$chatJoinRequest->getChat()->getId(),
            "type" => $chatJoinRequest->getChat()->getType(),
            "title" => $chatJoinRequest->getChat()->getTitle(),
            "username" => $chatJoinRequest->getChat()->getUsername(),
            "first_name" => $chatJoinRequest->getChat()->getFirstName(),
            "last_name" => $chatJoinRequest->getChat()->getLastName(),
            "message_id" => null,
        ]);
    }

    public function getUser(): ?User
    {
        $from = $this->update->getChatJoinRequest()->getFrom();

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
        //todo: run chat join request responder
    }
}
