<?php

namespace App\BotServices\ConversationLayer;


use App\BotServices\Chat;
use App\BotServices\Contexts\BotContext;
use App\BotServices\Enums\MetaKeys;
use App\BotServices\Interfaces\ConversationHandlerInterface;
use App\Models\Conversation as ConversationModel;
use Illuminate\Support\Facades\DB;
use Longman\TelegramBot\Entities\Update;

class ChannelHandler extends Conversation implements ConversationHandlerInterface
{
    private array $stepQueue = [

    ];

    public ?ConversationModel $conversation = null;

    public function __construct(
        public ?Chat      $chat,
        public Update     $update,
        public BotContext $botContext
    )
    {
    }

    public function load(): ConversationModel
    {
        return $this->conversation ??
            $this->conversation = $this->botContext->conversation = ConversationModel::with([
                "channel",
                "meta"
            ])->where([
                'chat_id' => $this->chat->id,
                "chat_type" => $this->chat->type
            ])->firstOr(fn() => $this->createNewChannelConversation());
    }

    private function createNewChannelConversation(): ConversationModel
    {
        DB::transaction(function () {
            $this->conversation = ConversationModel::create([
                "chat_id" => $this->chat->id,
                "chat_type" => $this->chat->type,
                "title" => $this->chat->parseTitle(),
                "state" => $this->initialState(),
                "first_message_id" => $this->chat->message_id,
                "last_message_id" => $this->chat->message_id,
            ]);

            $this->conversation->channel()->create([
                "chat_id" => $this->chat->id,
                "title" => $this->chat->parseTitle(),
                "username" => $this->chat->username,
            ]);

            $this->conversation->meta()->createMany([
                ["property" => MetaKeys::LanguageCode, "content" => "fa"]
            ]);
        });

        return $this->conversation;
    }

    public function stepQueue(): array
    {
        return $this->stepQueue;
    }

}
