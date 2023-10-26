<?php

namespace App\BotServices;

class Chat
{
    public function __construct(
        public int|string $id,
        public string     $type,
        public ?string    $title,
        public ?string    $username,
        public ?string    $first_name,
        public ?string    $last_name,
        public ?int       $message_id
    )
    {
    }

    public function parseTitle(): string
    {
        return match ($this->type) {
            "private" => implode(" ", [$this->first_name, $this->last_name]),
            default => $this->title
        };
    }
}
