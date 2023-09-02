<?php

namespace App\BotServices\ConversationLayer;


interface ConversationInterface
{

    public function initialState(): string;

    public function load();

    public function runQualifiedSteps(): void;

    public function getLocale(): string;

}
