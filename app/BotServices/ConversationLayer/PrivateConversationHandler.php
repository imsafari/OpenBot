<?php

namespace App\BotServices\ConversationLayer;

use App\BotServices\Chat;
use App\BotServices\ConversationLayer\ConversationSteps\PrivateStartStep;
use App\BotServices\Enums\MetaKeys;
use App\BotServices\User;
use App\Models\Conversation as ConversationModel;
use Illuminate\Support\Facades\DB;
use Longman\TelegramBot\Entities\Update;

class PrivateConversationHandler extends Conversation implements ConversationHandlerInterface
{
    private array $stepQueue = [
        PrivateStartStep::class

    ];

    public ?ConversationModel $conversation = null;

    public function __construct(
        public ?Chat  $chat,
        public ?User  $user,
        public Update $update
    )
    {
        echo "#1 i generated as private conversation handler\n";
    }

    public function load(): ConversationModel
    {

        return $this->conversation ?? $this->conversation = ConversationModel::with([
            "private" => ["meta"]
        ])->where([
            'chat_id' => $this->chat->id,
            "chat_type" => $this->chat->type
        ])->firstOr(fn() => $this->createNewPrivateConversation());
    }

    private function createNewPrivateConversation(): void
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

            $this->conversation->private()->create([
                "chat_id" => $this->user->id,
                "first_name" => $this->user->first_name,
                "last_name" => $this->user->last_name,
                "username" => $this->user->username,
                "language_code" => $this->user->language_code ?? "en",
            ]);

            $this->conversation->private->meta()->createMany([
                ["property" => MetaKeys::LanguageCode, "content" => $this->user->language_code ?? "en"]
            ]);
        });

    }

    public function stepQueue(): array
    {
        return $this->stepQueue;
    }


    public function getLocale(): string
    {
        return $this->conversation->private->meta->where("property", MetaKeys::LanguageCode) ?? "en";
    }

    //todo:         $this->conversation->last_message_id = $this->chat->message_id;
}

