<?php

namespace App\BotServices\ConversationLayer\ConversationSteps;

//TODO: check for implementation as event or trait
class StepContext
{
    protected array $handledSteps = [];

    protected bool $continue = true;

    public function shouldContinue(): bool
    {
        return $this->continue;
    }

    public function stop(): void
    {
        $this->continue = false;
    }

    public function newHandledStep(StepInterface $step): void
    {
        $this->handledSteps[] = $step;
    }

    public function getHandledSteps(): array
    {
        return $this->handledSteps;
    }

    //todo: record time elapsed per step handle
}
