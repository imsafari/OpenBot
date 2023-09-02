<?php

namespace App\BotServices\UpdateHandlers;

use App\BotServices\Chat;
use App\BotServices\User;

interface UpdateHandlerInterface
{
    public function doAction(): void;

    public function chatType(): string;

    public function getChat(): ?Chat;

    public function getUser(): ?User;
}
