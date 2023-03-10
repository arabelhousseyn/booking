<?php

namespace App\Support;

use App\Support\Contracts\NotificationDispatcher;

class RecipientNotificationDispatcher implements NotificationDispatcher
{
    private string $title;
    private string $body;
    private string $to;
    private mixed $data;

    public function __construct(string $title, string $body, string $to, mixed $data)
    {
        $this->title = $title;
        $this->body = $body;
        $this->to = $to;
        $this->data = $data;
    }

    public function configure(): array
    {
        return [
            "notification" => [
                "body" => $this->body,
                "title" => $this->title,
                "image" => '',
            ],
            "priority" => "high",
            'sound' => 'default',
            'badge' => '1',
            "data" => [
                "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                "id" => uniqid(),
                "status" => "done",
                "info" => [
                    "body" => $this->body,
                    "title" => $this->title,
                    'data' => $this->data,
                    'image' => '',
                ],
            ],
            "to" => $this->to,
        ];
    }

    public function send(): void
    {
        $data = $this->configure();

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_POST, 1);

        $headers = [];
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key='.config('app.firebase_server_key');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);
    }
}
