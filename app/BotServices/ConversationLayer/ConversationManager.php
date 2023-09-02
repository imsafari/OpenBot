<?php

namespace App\BotServices\ConversationLayer;

use App\BotServices\Enums\ChannelState;
use App\BotServices\Enums\ChatType;
use App\BotServices\Enums\GroupState;
use App\BotServices\Enums\PrivateState;
use App\BotServices\UpdateHandlers\UpdateHandlerInterface;
use App\Models\Conversation;
use Longman\TelegramBot\Entities\Update;

/**
 *
 * roles for ConversationManager
 *  -   store new conversation to db
 *  -   load old conversation from db
 *  -   load conversation class related to chat type
 *  -   set language
 */
class ConversationManager
{

    public ?Conversation $conversation;

    public function __construct(
        public Update $update,

    )
    {
    }



    //public function loadFromMessage
    //cares about conversation chat type
    public function loadFromMessageChatType(
        UpdateHandlerInterface $updateHandler
    ): void
    {
        $message = $this->update->getMessage();
    }

    public function loadFromMessage(): void
    {
        $message = $this->update->getMessage();
        $this->conversation = Conversation::where([
            'chat_id' => $message->getChat()->getId(),
            "chat_type" => $message->getChat()->getType(),
        ])->first();

        if (!$this->conversation) {
            $this->conversation = Conversation::create([
                "chat_id" =>
                    $message->getChat()->getId(),
                "chat_type" =>
                    $message->getChat()->getType(),
                "title" =>
                    $message->getChat()->getTitle() ?? $message->getChat()->getFirstName() . " " . $message->getChat()->getLastName(),
                "state" =>
                    $this->initialStat($message->getChat()->getType()),
                "first_message_id" =>
                    $message->getMessageId(),
                "last_message_id" =>
                    $message->getMessageId(),
            ]);
        }

        $this->conversation->last_message_id = $message->getMessageId();

        // load
    }

    //public function loadFromCallbackQuery
    //public function loadFromInlineQuery
    //public function loadFromChannelPost
    //public function loadFromEditedMessage
    //public function loadFromEditedChannelPost
    //public function loadFromShippingQuery
    //public function loadFromPreCheckoutQuery
    //public function loadFromPoll
    //public function loadFromPollAnswer
    //public function loadFromMyChatMember
    //public function loadFromChatMember
    //public function loadFromChosenInlineResult



    private function initialStat(string $chat_type): string
    {
        return match ($chat_type) {
            ChatType::Private->value => PrivateState::Start->value,
            ChatType::Group->value, ChatType::Supergroup->value => GroupState::Start->value,
            ChatType::Channel->value => ChannelState::Start->value,
        };
    }

}
