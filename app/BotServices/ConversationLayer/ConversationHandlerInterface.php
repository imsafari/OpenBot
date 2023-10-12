<?php

namespace App\BotServices\ConversationLayer;


interface ConversationHandlerInterface
{

    public function initialState(): string;

    public function load(): \App\Models\Conversation;

    public function runQualifiedSteps(): void;

    public function getMeta(string $key, string $default): string;

    public function setMeta(string $key, string $value): bool;
}
