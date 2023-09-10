<?php

namespace App\BotServices\UpdateHandlers;

use App\BotServices\Chat;
use App\BotServices\ConversationLayer\ConversationHandlerInterface;
use App\BotServices\User;
use Illuminate\Support\Facades\App;
use Longman\TelegramBot\Entities\Update;

class EditedMessageHandler extends BaseHandler  implements UpdateHandlerInterface
{
    public function __construct(
        public Update $update
    )
    {
    }


    public function chatType(): string
    {
        //private or group or supergroup
        return $this->update->getEditedMessage()->getChat()->getType();
    }

    public function getChat(): ?Chat
    {
        $message = $this->update->getEditedMessage();

        return new Chat(...[
            "id" => $message->getChat()->getId(),
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
        $message = $this->update->getEditedMessage();

        return new User(...[
            "id" => $message->getFrom()->getId(),
            "is_bot" => $message->getFrom()->getIsBot(),
            "first_name" => $message->getFrom()->getFirstName(),
            "last_name" => $message->getFrom()->getLastName(),
            "username" => $message->getFrom()->getUsername(),
            "language_code" => $message->getFrom()->getLanguageCode(),
            "is_premium" => $message->getFrom()->getIsPremium(),
            "added_to_attachment_menu" => $message->getFrom()->getAddedToAttachmentMenu(),
        ]);
    }

    public function doAction(): void
    {
        //todo: run edit message responder
    }
}
