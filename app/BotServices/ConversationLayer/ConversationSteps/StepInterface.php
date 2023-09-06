<?php

namespace App\BotServices\ConversationLayer\ConversationSteps;

use App\BotServices\ConversationLayer\ConversationHandlerInterface;

interface StepInterface
{
    public function isQualified(): bool;

    public function handle(): void;
}
