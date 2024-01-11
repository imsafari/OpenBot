<?php

namespace App\BotServices\ConversationLayer\Steps;

use App\BotServices\Contexts\BotContext;
use App\BotServices\Contexts\StepContext;

abstract class BaseStep
{
    protected array $qualifications = [
        "chat_type" => null, // null|true|empty mean for every chat type
        "state" => null, // null|true|empty mean for every step
        //"auth" => ["user"], // allowed tg user types or null|true|empty for everyone+
        //one of user meta
        //one of conversation meta
        //user age
        //user connection speed
        //user location
        //user language
        //user group role or title
        //user group permissions
        //message content
        //account age
        //subscription
        //time range 9 to 11
    ];

    public function isQualified(): bool
    {
        return false;
    }

    public function handle(): void
    {
    }

    public function onMessage(): void
    {
    }

    public function onCallbackQuery(): void
    {
    }

    public function onEditedMessage(): void
    {
    }

    public function onChannelPost(): void
    {
    }

    public function onEditedChannelPost(): void
    {
    }

    public function onEnter(string $enterState): void
    {
    }

    public function nextStep(string $step): void
    {
        $botContext = app(BotContext::class);
        $stepContext = app(StepContext::class);

        $botContext->conversation->state = $step;
        $stepContext->setEnterState($step);
    }

    public function removeLastMessageKeyboard(): void
    {
        $botContext = app(BotContext::class);
        $conversation = $botContext->conversation->getOriginal();
        if (isset($conversation["last_message_id"])) {
            Request::editMessageReplyMarkup([
                "chat_id" => $botContext->conversation->chat_id,
                "message_id" => $conversation["last_message_id"],
                "reply_markup" => "",
            ]);
        }

    }
}
