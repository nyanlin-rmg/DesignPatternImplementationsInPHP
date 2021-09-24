<?php

interface Transport
{
    public function deliver();
}

class Truck implements Transport
{
    public function deliver()
    {
        echo "Deliver With Truck\n";
    }
}

class Train implements Transport{
    public function deliver()
    {
        echo "Deliver With Train\n";
    }
}

class Ship implements Transport
{
    public function deliver()
    {
        echo "Deliver With Ship\n";
    }
}


abstract class Logistics
{
    abstract function createTransport();
}

class RoadLogistics extends Logistics
{
    public function createTransport()
    {
        return new Train();
    }
}

class SeaLogistics extends Logistics
{
    public function createTransport()
    {
        return new Ship();
    }
}

function client_code() {
    $roadLogistics = new RoadLogistics();
    $roadLogistics->createTransport()->deliver();

    $seaLogistics = new SeaLogistics();
    $seaLogistics->createTransport()->deliver();
}