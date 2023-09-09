<?php

namespace App\BotServices\ConversationLayer\ConversationSteps;

use App\BotServices\BotContext;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Longman\TelegramBot\Entities\Update;

//TODO: check for implementation as event or trait
class StepContext
{
    protected array $handledSteps = [];
    protected bool $stop = false;
    protected string $typeHandlerName;
    protected string $enterState = "";
    protected array $enterableSteps = [];

    public function __construct(
        public Update     $update,
        public BotContext $botContext
    )
    {
        $this->typeHandlerName = $this->getTypeHandlerName();
    }

    public function handleStep(StepInterface $step): void
    {
        $this->handledSteps[] = $step;

        //TODO: check if step has entrance method, add to list of steps has entrance
        if (method_exists($step, "onEnter")) {
            $this->enterableSteps[] = fn() => App::call(
                [$step, "onEnter"],
                ["enterState" => $this->enterState]
            );
        }

        if (!App::call([$step, "isQualified"])) {
            return;
        }

        if (method_exists($step, "handle")) {
            App::call([$step, "handle"]); //handle step as general
        }

        if ($this->shouldStop()) {
            return;
        }

        if (method_exists($step, $this->typeHandlerName)) {
            App::call([$step, $this->typeHandlerName]); //handle step by type
        }
    }

    public function shouldStop(): bool
    {
        return $this->stop;
    }

    public function stop(): void
    {
        $this->stop = true;
    }

    public function getHandledSteps(): array
    {
        return $this->handledSteps;
    }

    public function handleStateEnter(): void
    {
        foreach ($this->enterableSteps as $entrance) {
            $entrance();
        }
    }

    public function setEnterState(string $state): void
    {
        $this->enterState = $state;
    }

    public function shouldEnterState(): bool
    {
        return $this->enterState != "";
    }

    private function getTypeHandlerName(): string
    {
        return "on" . str_replace(
                "_",
                "",
                Str::convertCase($this->update->getUpdateType(), MB_CASE_TITLE)
            );
    }

    //todo: record time elapsed per step handle
}
