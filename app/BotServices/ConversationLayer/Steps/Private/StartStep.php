<?php

namespace App\BotServices\ConversationLayer\Steps\Private;

use App\BotServices\Contexts\BotContext;
use App\BotServices\Contexts\StepContext;
use App\BotServices\ConversationLayer\Steps\BaseStep;
use App\BotServices\Enums\PrivateState;
use App\BotServices\Interfaces\StepInterface;
use App\BotServices\Interfaces\UpdateHandlerInterface;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Request;

class StartStep extends BaseStep implements StepInterface
{
    const StateName = PrivateState::Start->value;

    protected array $qualifications = [
        "state" => PrivateState::Start->value,
    ];


    public function __construct(
        public BotContext             $botContext,
        public StepContext            $context,
        public UpdateHandlerInterface $updateHandler,
        public Update                 $update
    )
    {
    }

    public function onMessage(): void
    {
        $user = $this->updateHandler->getUser();
        $message = $this->update->getMessage();

        if ($message->getText() == "/start") {
            $result = Request::sendMessage([
                "chat_id" => $user->id,
                "text" => __("bot/private.start"),
            ]);

            if ($result->getOk()) {
                $this->botContext->conversation->last_message_id = $result->getResult()->message_id;

//                app(ConversationHandlerInterface::class)
//                    ->setMeta(MetaKeys::LastMessageID, $result->getResult()->message_id);
            }

            $this->nextStep(PrivateState::MainMenu->value);
        }
    }

    public function isQualified(): bool
    {
        $conversation = $this->botContext->conversation->getOriginal();
        if ($conversation["state"] != $this->qualifications["state"])
            return false;

        //step is qualified
        return true;
    }

}
