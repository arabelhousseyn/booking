<?php

namespace App\Support\Contracts;

interface NotificationDispatcher
{
    public function __construct(string $title, string $body, string $to, mixed $data);

    public function configure(): array;

    public function send(): void;
}
