<?php

namespace App\BotServices\ConversationLayer;

use App\BotServices\Chat;
use App\BotServices\Contexts\StepContext;
use App\BotServices\ConversationLayer\Steps\FinisherStep;
use App\BotServices\ConversationLayer\Steps\StarterStep;
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

        $stepContext->handleStep(app(StarterStep::class));

        $steps = $this->stepGenerator();
        foreach ($steps as $step) {

            $stepContext->handleStep($step);

            if ($stepContext->shouldStop()) {
                break;
            }
        }

        if ($stepContext->shouldEnterState())
            $stepContext->handleStateEnter();

        //run finisher step after all steps also entrances
        $stepContext->handleStep(app(FinisherStep::class));
    }

    public function getMeta(string $key, string $default = ""): string
    {
        return $this->conversation->meta->where("property", $key)->first()?->content ?? $default;
    }

    public function setMeta(string $key, string $value): bool
    {
        return (bool)$this->conversation->meta()->updateOrCreate(
            ["property" => $key],
            ["content" => $value]
        );
    }
}
