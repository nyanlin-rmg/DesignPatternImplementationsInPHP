<?php

class LegacyEmailNotificationSystem
{
    private $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function sendEmail($title, $body)
    {
        echo "To: $this->email\n";
        echo "Title: $title\n";
        echo "Body: $body\n";
    }
}

interface Notification
{
    public function send($title, $message);
}

class EmailNotification implements Notification
{
    private $legacySystem;

    public function __construct($email)
    {
        $this->legacySystem = new LegacyEmailNotificationSystem($email);
    }

    public function send($title, $message)
    {
        $this->legacySystem->sendEmail($title, $message);
    }
}


function client_code() {
    $notification = new EmailNotification("test@gmail.com");
    $notification->send("Notification 1", "This is test notification");
}

client_code();
