<?php

class Car
{
    private $engine;
    private $wheels;
    private $seats;
    private $gps;
    private $computerSystem;

    public function __construct(CarBuilder $builder)
    {
        $this->engine = $builder->getEngine();
        $this->wheels = $builder->getWheels();
        $this->seats = $builder->getSeats();
        $this->gps = $builder->getGPS();
        $this->computerSystem = $builder->getComputerSystem();
    }

    public function getCar()
    {
        echo
            "Engine: $this->engine\n" .
            "Wheels: $this->wheels\n" .
            "Seats: $this->seats\n"  .
            "GPS: $this->gps\n" .
            "Computer System: $this->computerSystem\n";
    }
}

interface CarBuilder
{
    public function installEngine($engine);
    public function installSeats($seats);
    public function installWheels($wheels);
    public function installGPS($gps);
    public function installComputerSystem($computerSystem);
    public function build();
}

class KiaCarBuilder implements CarBuilder
{
    private $engine;
    private $wheels;
    private $seats;
    private $gps;
    private $computerSystem;

    public function installEngine($engine): CarBuilder
    {
        $this->engine = $engine;
        return $this;
    }

    public function getEngine()
    {
        return $this->engine ?? 'Diesel Engine';
    }

    public function installWheels($wheels): CarBuilder
    {
        $this->wheels = $wheels;
        return $this;
    }

    public function getWheels()
    {
        return $this->wheels ?? 4;
    }

    public function installSeats($seats): CarBuilder
    {
        $this->seats = $seats;
        return $this;
    }

    public function getSeats()
    {
        return $this->seats ?? 4;
    }

    public function installGps($gps): CarBuilder
    {
        $this->gps = $gps;
        return $this;
    }

    public function getGPS()
    {
        return $this->gps ?? 'Not Installed';
    }

    public function installComputerSystem($computerSystem): CarBuilder
    {
        $this->engine = $computerSystem;
        return $this;
    }

    public function getComputerSystem()
    {
        return $this->computerSystem ?? 'Not Installed';
    }

    public function build(): Car
    {
        return new Car($this);
    }
}

function client_code(CarBuilder $carBuilder)
{
    return $carBuilder->installEngine("Diesel Engine")
        ->installWheels(4)
        ->installSeats(6)
        ->build()
        ->getCar();
}

client_code(new KiaCarBuilder());
