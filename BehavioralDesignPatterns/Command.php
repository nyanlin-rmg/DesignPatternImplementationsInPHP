<?php

interface Command
{
    public function execute();
}

class CopyCommand implements Command
{
    private $text;

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function execute()
    {
        echo "Copy Command Execute\nText: $this->text\n\n";
    }
}

class DeleteCommand implements Command
{
    private $text;

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function execute()
    {
        echo "Delete Command Execute\nText: $this->text\n\n";
    }
}

class SaveCommand implements Command
{
    public function execute()
    {
        echo "Save Command Execute\n";
    }
}

class Invoker
{
    private $history = [];

    public function invoke(Command $command)
    {
        $this->history[] = $command;
        $command->execute();
    }

    public function undo()
    {
        $index = sizeof($this->history) - 1;
        $command = $this->history[$index];
        array_splice($this->history, $index, 1);
        echo "Undo " . get_class($command) . "\n";
    }
}

function client_code() {
    $invoker = new Invoker();
    $invoker->invoke(new CopyCommand("Hello World"));
    $invoker->invoke(new DeleteCommand("Nice To Meet You"));

    $invoker->undo();
    $invoker->undo();
}

client_code();
