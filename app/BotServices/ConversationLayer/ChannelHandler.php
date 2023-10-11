<?php

namespace App\BotServices\ConversationLayer;


use App\BotServices\BotContext;
use App\BotServices\Chat;
use App\BotServices\ConversationLayer\Steps\Channel\StartStep;
use App\BotServices\ConversationLayer\Steps\FinisherStep;
use App\BotServices\ConversationLayer\Steps\StarterStep;
use App\BotServices\Enums\MetaKeys;
use App\Models\Conversation as ConversationModel;
use Illuminate\Support\Facades\DB;
use Longman\TelegramBot\Entities\Update;

class ChannelHandler extends Conversation implements ConversationHandlerInterface
{
    private array $stepQueue = [
        StarterStep::class,

        StartStep::class,

        FinisherStep::class,
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
                "channel" => ["meta"]
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

            $this->conversation->channel->meta()->createMany([
                ["property" => MetaKeys::LanguageCode, "content" => "en"]
            ]);
        });

        return $this->conversation;
    }

    public function stepQueue(): array
    {
        return $this->stepQueue;
    }


    public function getLocale(): string
    {
        return $this->conversation->channel->meta->where("property", MetaKeys::LanguageCode) ?? "en";
    }

    //todo:         $this->conversation->last_message_id = $this->chat->message_id;

}
