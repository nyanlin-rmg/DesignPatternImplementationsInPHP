<?php

class UserRepository implements \SplSubject
{
    private $users = [];
    private $observers = [];

    public function __construct()
    {
        $this->observers["*"] = [];
    }

    private function initEventGroup($event = "*")
    {
        if (!(isset($this->observers[$event]))) {
            $this->observers[$event] = [];
        }
    }

    private function getEventObserver($event = "*")
    {
        $this->initEventGroup($event);
        $group = $this->observers[$event];
        var_dump("Group: ", $group);
        $all = $this->observers["*"];
        var_dump("All: ", $all);
        return array_merge($group, $all);
    }

    public function attach(SplObserver $observer, $event = "*")
    {
        $this->initEventGroup($event);
        $this->observers[$event][] = $observer;
    }

    public function detach(SplObserver $observer, $event = "*")
    {
        foreach ($this->getEventObserver($event) as $key => $value) {
            if ($value === $observer) {
                unset($this->observers[$event][$key]);
            }
        }
    }

    public function notify($event="*", $data=null)
    {
        echo "User Repository Class: Broadcasting the $event event\n";
        foreach ($this->getEventObserver($event) as $observer) {
            $observer->update($this, $event, $data);
        }
    }

    public function initialize($fileName)
    {
        echo "User Repository Class: Initialize user record from $fileName\n";
        $this->notify("UserInitialize", $fileName);
    }

    public function createUser($data)
    {
        echo "User Repository Class: Creating user record\n";
        $this->notify("UserCreated", $data);
        return "User Created";
    }
}


class Logger implements SplObserver
{
    private $fileName;

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    public function update(\SplSubject $repository, string $event = null, $data = null)
    {
        echo "Logger: I've written '$event' entry to the log.\n";
    }
}

class OnboardingNotification implements \SplObserver
{
    private $adminEmail;

    public function __construct($adminEmail)
    {
        $this->adminEmail = $adminEmail;
    }

    public function update(\SplSubject $repository, string $event = null, $data = null): void
    {
        echo "OnboardingNotification: The notification has been emailed!\n";
    }
}

function client_code() {
    $repository = new UserRepository();
    $repository->attach(new Logger("test_file_name.txt"));
    $repository->attach(new OnboardingNotification('admin@example.com'));

    $repository->createUser(['name' => 'john', 'email' => 'john@gmail.com']);
}

client_code();
