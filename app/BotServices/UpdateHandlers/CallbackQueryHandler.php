<?php

namespace App\BotServices\UpdateHandlers;

use App\BotServices\Chat;
use App\BotServices\ConversationLayer\ConversationHandlerInterface;
use App\BotServices\Enums\MetaKeys;
use App\BotServices\User;
use Illuminate\Support\Facades\App;
use Longman\TelegramBot\Entities\Update;

class CallbackQueryHandler extends BaseHandler implements UpdateHandlerInterface
{

    public function __construct(
        public Update $update
    )
    {
    }


    public function chatType(): string
    {
        //private or group or supergroup or channel
        return $this->update->getCallbackQuery()->getMessage()->getChat()->getType();
    }

    public function getChat(): ?Chat
    {
        $message = $this->update->getCallbackQuery()->getMessage();

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
        $from = $this->update->getCallbackQuery()->getFrom();

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
        $conversationHandler = app(ConversationHandlerInterface::class);
        $conversationHandler->load();

        App::setLocale($conversationHandler->getMeta(MetaKeys::LanguageCode, "fa"));

        $conversationHandler->runQualifiedSteps();
    }


}
