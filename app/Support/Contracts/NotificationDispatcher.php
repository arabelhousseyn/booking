<?php

namespace App\Support\Contracts;

use App\Models\Seller;
use App\Models\User;

interface NotificationDispatcher
{
    public function __construct(string $title, string $body, string $to, mixed $data);

    public function configure(): array;

    public function send(): void;
}
