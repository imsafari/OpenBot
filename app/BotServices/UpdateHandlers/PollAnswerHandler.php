<?php

namespace App\BotServices\UpdateHandlers;

use App\BotServices\Chat;
use App\BotServices\ConversationLayer\ConversationHandlerInterface;
use App\BotServices\User;
use Illuminate\Support\Facades\App;
use Longman\TelegramBot\Entities\Update;

class PollAnswerHandler extends BaseHandler implements UpdateHandlerInterface
{
    public function __construct(
        public Update $update
    )
    {
    }


    public function chatType(): string
    {
        //private or group or supergroup or channel
        //todo: return $this->update->getPollAnswer()->getVoterChat()->getType();
        //todo: standing to availability of getVoterChat();
        return "";
    }

    public function getChat(): ?Chat
    {
        //todo: standing to availability of getVoterChat();
        return null;
    }

    public function getUser(): ?User
    {
        $from = $this->update->getPollAnswer()->getUser();

        return $from ? new User(...[
            "id" => (string)$from->getId(),
            "is_bot" => $from->getIsBot(),
            "first_name" => $from->getFirstName(),
            "last_name" => $from->getLastName(),
            "username" => $from->getUsername(),
            "language_code" => $from->getLanguageCode(),
            "is_premium" => $from->getIsPremium(),
            "added_to_attachment_menu" => $from->getAddedToAttachmentMenu(),
        ]) : null;
    }

    public function doAction(): void
    {
        //todo: run poll answer responder
    }
}
