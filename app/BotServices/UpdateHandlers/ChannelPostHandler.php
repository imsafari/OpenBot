<?php

namespace App\BotServices\UpdateHandlers;

use App\BotServices\Chat;
use App\BotServices\ConversationLayer\ConversationHandlerInterface;
use App\BotServices\User;
use Illuminate\Support\Facades\App;
use Longman\TelegramBot\Entities\Update;

class ChannelPostHandler extends BaseHandler implements UpdateHandlerInterface
{
    public function __construct(
        public Update $update
    )
    {
    }


    public function chatType(): string
    {
        //channel
        return $this->update->getChannelPost()->getChat()->getType();
    }

    public function getChat(): ?Chat
    {
        $message = $this->update->getChannelPost();

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
        return null;
    }

    public function doAction(): void
    {
        $conversationHandler = app(ConversationHandlerInterface::class);
        $conversationHandler->load();

        App::setLocale($conversationHandler->getLocale());

        $conversationHandler->runQualifiedSteps();
    }
}
