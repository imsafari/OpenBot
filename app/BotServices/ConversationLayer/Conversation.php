<?php

namespace App\BotServices\ConversationLayer;

use App\BotServices\Chat;
use App\BotServices\ConversationLayer\ConversationSteps\StepContext;
use App\BotServices\ConversationLayer\ConversationSteps\StepInterface;
use App\BotServices\Enums\ChannelState;
use App\BotServices\Enums\ChatType;
use App\BotServices\Enums\GroupState;
use App\BotServices\Enums\PrivateState;
use App\BotServices\UpdateHandlers\UpdateHandlerInterface;
use App\BotServices\User;
use Illuminate\Support\Facades\App;

abstract class Conversation
{
    public UpdateHandlerInterface $updateHandler;

    public ?Chat $chat;
    public ?User $user;

    public function initialState(): string
    {
        return match ($this->chat->type) {
            ChatType::Private->value => PrivateState::Start->value,
            ChatType::Group->value, ChatType::Supergroup->value => GroupState::Start->value,
            ChatType::Channel->value => ChannelState::Start->value,
        };
    }

    public function load()
    {
        echo "\n(unhandled load method) handled by parent conversation for " . static::class;
    }

    public function runQualifiedSteps(): void
    {
        $stepContext = app(StepContext::class);
        $steps = $this->stepGenerator();

        foreach ($steps as $step) {
            if ($step->isQualified($this)) {

                $step->handle();
                $stepContext->newHandledStep($step);

                if (!$stepContext->shouldContinue()) {
                    break;
                }
            }
        }
    }

    private function stepGenerator(): \Generator
    {
        foreach ($this->stepQueue() as $step) {
            yield app($step);
        }
    }

    abstract public function stepQueue(): array;

    public function getLocale(): string
    {
        return "en";
    }
}
