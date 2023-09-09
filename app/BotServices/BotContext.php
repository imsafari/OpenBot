<?php

namespace App\BotServices;

use App\BotServices\ConversationLayer\ChannelConversationHandler;
use App\BotServices\ConversationLayer\ConversationHandlerInterface;
use App\BotServices\ConversationLayer\GroupConversationHandler;
use App\BotServices\ConversationLayer\PrivateConversationHandler;
use App\BotServices\Enums\ChatType;
use App\BotServices\Enums\UpdateType;
use App\BotServices\UpdateHandlers\CallbackQueryHandler;
use App\BotServices\UpdateHandlers\ChannelPostHandler;
use App\BotServices\UpdateHandlers\ChatJoinRequest;
use App\BotServices\UpdateHandlers\ChatMemberHandler;
use App\BotServices\UpdateHandlers\ChosenInlineResultHandler;
use App\BotServices\UpdateHandlers\EditedChannelPostHandler;
use App\BotServices\UpdateHandlers\EditedMessageHandler;
use App\BotServices\UpdateHandlers\InlineQueryHandler;
use App\BotServices\UpdateHandlers\MessageHandler;
use App\BotServices\UpdateHandlers\MyChatMemberHandler;
use App\BotServices\UpdateHandlers\PollAnswerHandler;
use App\BotServices\UpdateHandlers\PollHandler;
use App\BotServices\UpdateHandlers\PreCheckoutQueryHandler;
use App\BotServices\UpdateHandlers\ShippingQueryHandler;
use App\BotServices\UpdateHandlers\UpdateHandlerInterface;
use App\Models\Conversation;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Telegram;

class BotContext
{

    public ?UpdateHandlerInterface $updateHandler;
    public ?ConversationHandlerInterface $conversationHandler;
    public Conversation $conversation;

    public function __construct(
        public Telegram $telegram,
        public Update   $update
    )
    {
    }

    public function updateHandler(): UpdateHandlerInterface
    {
        return $this->updateHandler ?? $this->updateHandler = match ($this->update->getUpdateType()) {
            UpdateType::Message->value => app(MessageHandler::class),
            UpdateType::CallbackQuery->value => app(CallbackQueryHandler::class),
            UpdateType::EditedMessage->value => app(EditedMessageHandler::class),
            UpdateType::ChannelPost->value => app(ChannelPostHandler::class),
            UpdateType::EditedChannelPost->value => app(EditedChannelPostHandler::class),
            UpdateType::InlineQuery->value => app(InlineQueryHandler::class),
            UpdateType::ChosenInlineResult->value => app(ChosenInlineResultHandler::class),
            UpdateType::ShippingQuery->value => app(ShippingQueryHandler::class),
            UpdateType::PreCheckoutQuery->value => app(PreCheckoutQueryHandler::class),
            UpdateType::Poll->value => app(PollHandler::class),
            UpdateType::PollAnswer->value => app(PollAnswerHandler::class),
            UpdateType::MyChatMember->value => app(MyChatMemberHandler::class),
            UpdateType::ChatMember->value => app(ChatMemberHandler::class),
            UpdateType::ChatJoinRequest->value => app(ChatJoinRequest::class),
            default => throw new \Exception('Unexpected match value: ' . $this->update->getUpdateType()),
        };
    }

    public function conversationHandler(): ConversationHandlerInterface
    {
        $args = [
            "chat" => $this->updateHandler->getChat(),
            "user" => $this->updateHandler->getUser(),
        ];

        return $this->conversationHandler ?? $this->conversationHandler = match ($this->updateHandler->chatType()) {
            ChatType::Private->value, ChatType::Sender->value => app()->makeWith(PrivateConversationHandler::class, $args),
            ChatType::Group->value, ChatType::Supergroup->value => app()->makeWith(GroupConversationHandler::class, $args),
            ChatType::Channel->value => app()->makeWith(ChannelConversationHandler::class, $args),
        };
    }


    public function conversationModel(): Conversation
    {
        return $this->conversation ?? $this->conversation = $this->conversationHandler->load();
    }

}
