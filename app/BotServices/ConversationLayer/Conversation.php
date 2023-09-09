<?php

namespace App\BotServices\ConversationLayer;

use App\BotServices\Chat;
use App\BotServices\ConversationLayer\ConversationSteps\StepContext;
use App\BotServices\Enums\ChannelState;
use App\BotServices\Enums\ChatType;
use App\BotServices\Enums\GroupState;
use App\BotServices\Enums\PrivateState;
use App\BotServices\User;
use Longman\TelegramBot\Entities\Update;

abstract class Conversation
{

    public Update $update;
    public ?Chat $chat;
    public ?User $user;

    abstract public function stepQueue(): array;

    public function initialState(): string
    {
        return match ($this->chat->type) {
            ChatType::Private->value => PrivateState::Start->value,
            ChatType::Group->value, ChatType::Supergroup->value => GroupState::Start->value,
            ChatType::Channel->value => ChannelState::Start->value,
        };
    }

    private function stepGenerator(): \Generator
    {
        foreach ($this->stepQueue() as $step) {
            yield app($step);
        }
    }

    public function runQualifiedSteps(): void
    {
        $stepContext = app(StepContext::class);
        $steps = $this->stepGenerator();

        foreach ($steps as $step) {

            $stepContext->handleStep($step);

            if ($stepContext->shouldStop()) {
                break;
            }
        }

        if ($stepContext->shouldEnterState())
            $stepContext->handleStateEnter();

    }

    public function getLocale(): string
    {
        return "en";
    }
}
