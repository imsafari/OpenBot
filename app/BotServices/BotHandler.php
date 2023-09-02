<?php

namespace App\BotServices;

use App\BotServices\ConversationLayer\ChannelConversation;
use App\BotServices\ConversationLayer\ConversationInterface;
use App\BotServices\ConversationLayer\GroupConversation;
use App\BotServices\ConversationLayer\PrivateConversation;
use App\BotServices\Enums\ChatType;
use App\BotServices\Enums\UpdateType;
use App\BotServices\UpdateHandlers\CallbackQueryHandler;
use App\BotServices\UpdateHandlers\ChannelPostHandler;
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
use Longman\TelegramBot\Entities\Update;


class BotHandler
{
    public function UpdateHandler(
        Update $update
    ): UpdateHandlerInterface
    {
        return match ($update->getUpdateType()) {
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
            default => throw new \Exception('Unexpected match value: ' . $update->getUpdateType()),
        };
    }

    public function ConversationHandler
    (
        UpdateHandlerInterface $updateHandler
    ): ConversationInterface
    {
//        app()->instance(Chat::class, $updateHandler->getChat());
//        app()->instance(User::class, $updateHandler->getUser());

        $args = [
            "user" => $updateHandler->getUser(),
            "chat" => $updateHandler->getChat()
        ];

        return match ($updateHandler->chatType()) {
            ChatType::Private->value => app()->makeWith(PrivateConversation::class, $args),
            ChatType::Group->value, ChatType::Supergroup->value => app()->makeWith(GroupConversation::class, $args),
            ChatType::Channel->value => app()->makeWith(ChannelConversation::class, $args),
        };
    }
}
