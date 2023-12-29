<?php

namespace App\BotServices\ConversationLayer;


use App\BotServices\Chat;
use App\BotServices\Contexts\BotContext;
use App\BotServices\Enums\MetaKeys;
use App\BotServices\Interfaces\ConversationHandlerInterface;
use App\BotServices\User;
use App\Models\Conversation as ConversationModel;
use Illuminate\Support\Facades\DB;
use Longman\TelegramBot\Entities\Update;

class GroupHandler extends Conversation implements ConversationHandlerInterface
{

    private array $stepQueue = [
    ];

    public ?ConversationModel $conversation = null;

    public function __construct(
        public ?Chat      $chat,
        public ?User      $user,
        public Update     $update,
        public BotContext $botContext
    )
    {
    }

    public function load(): ConversationModel
    {
        return $this->conversation ??
            $this->conversation = $this->botContext->conversation = ConversationModel::with([
                "group",
                "meta"
            ])->where([
                'chat_id' => $this->chat->id,
                "chat_type" => $this->chat->type
            ])->firstOr(fn() => $this->createNewGroupConversation());
    }

    private function createNewGroupConversation(): ConversationModel
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

            $this->conversation->group()->create([
                "chat_id" => $this->chat->id,
                "title" => $this->chat->parseTitle(),
                "username" => $this->chat->username,
                "is_supergroup" => $this->chat->type == "supergroup",
            ]);

            $this->conversation->meta()->createMany([
                ["property" => MetaKeys::LanguageCode, "content" => $this->user->language_code ?? "fa"]
            ]);
        });

        return $this->conversation;
    }

    public function stepQueue(): array
    {
        return $this->stepQueue;
    }

}
