<?php

class CPU
{
    public function freeze()
    {
        echo "cpu freeze...\n";
    }

    public function jump()
    {
        echo "jump to the instruction...\n";
    }

    public function execute()
    {
        echo "execute the instructions...\n";
    }
}

class Memory
{
    public function load()
    {
        echo "loading instructions...\n";
    }
}

class HardDisk
{
    public function readBootSector()
    {
        echo "reading boot sector...\n";
    }
}

class OSFacade
{
    private $cpu, $memory, $hardDisk;

    public function __construct(CPU $cpu, Memory $memory, HardDisk $hardDisk)
    {
        $this->cpu = $cpu;
        $this->memory = $memory;
        $this->hardDisk = $hardDisk;
    }

    public function start()
    {
        $this->hardDisk->readBootSector();
        $this->memory->load();
        $this->cpu->jump();
        $this->cpu->execute();
    }
}

function client_code() {
    $facade = new OSFacade(new CPU(), new Memory(), new HardDisk());
    $facade->start();
}

client_code();
