<?php

namespace App\BotServices;

class User
{
    public function __construct(
        public int|string $id,
        public bool       $is_bot,
        public string     $first_name,
        public ?string    $last_name,
        public ?string    $username,
        public ?string    $language_code,
        public ?bool      $is_premium,
        public ?bool      $added_to_attachment_menu)
    {
    }
}
