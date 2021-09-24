<?php

class ComputationalCostlyObject
{
    private $computationalCostlyProp;

    public function __construct()
    {
        $this->computationalCostlyProp = $this->computationalCostlyMethod();
    }


    private function computationalCostlyMethod()
    {
        echo "start computing\n";
        sleep(3);
        echo "end computing\n";
        return "computation process done!\n";
    }

    public function __clone()
    {
        $this->computationalCostlyProp = $this->computationalCostlyProp . " copy";
    }
}

function client_code()
{
    $obj1 = new ComputationalCostlyObject();
    $obj2 = clone $obj1;
    var_dump($obj1);
    var_dump($obj2);
}

client_code();