<?php

namespace App\BotServices\Interfaces;


interface StepInterface
{
    public function isQualified(): bool;

    public function handle(): void;

    public function onMessage(): void;

    public function onCallbackQuery(): void;

    public function onEditedMessage(): void;

    public function onChannelPost(): void;

    public function onEditedChannelPost(): void;

    public function onEnter(string $enterState): void;
}
