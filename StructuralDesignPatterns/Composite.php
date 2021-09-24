<?php

interface Graphic
{
    public function move($x, $y);
    public function draw();
}

class Dot implements Graphic
{
    protected $x, $y;

    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function move($x, $y)
    {
        $this->x += $x;
        $this->y += $y;

        echo "Item move to x = $this->x, y = $this->y\n";
    }

    public function draw()
    {
        echo "Draw a dot at x = $this->x, y = $this->y\n";
    }
}

class Circle extends Dot
{
    private $radius;

    public function __construct($x, $y, $radius)
    {
        $this->x = $x;
        $this->y = $y;
        $this->radius = $radius;
    }

    public function draw()
    {
        echo "Draw a circle at x = $this->x, y = $this->y, radius = $this->radius\n";
    }
}

class CompoundGraphic implements Graphic
{
    protected $fields = [];

    public function add(Graphic $child)
    {
        array_push($this->fields, $child);
    }

    public function remove(Graphic $child)
    {
        $location = array_search($child, $this->fields);
        array_splice($this->fields, $location, 1);

        var_dump($this->fields);
    }

    public function move($x, $y)
    {
        foreach ($this->fields as $field) {
            $field->move($x, $y);
        }
    }

    public function draw()
    {
        foreach ($this->fields as $field) {
            $field->draw();
        }
    }
}

function client_code() {
    $dot1 = new Dot(10,20);
    $circle1 = new Circle(10,20,5);

    $dot2 = new Dot(30,40);
    $circle2 = new Circle(21,35,10);

    $compoundGraphic = new CompoundGraphic();
    $compoundGraphic->add($dot1);
    $compoundGraphic->add($dot2);
    $compoundGraphic->add($circle1);
    $compoundGraphic->add($circle2);

    $compoundGraphic->draw();

    $compoundGraphic->move(50, 100);

    $compoundGraphic->remove($circle1);
}

client_code();
