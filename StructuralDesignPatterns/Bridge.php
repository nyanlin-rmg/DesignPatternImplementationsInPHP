<?php

interface DrawingApi
{
    public function drawCircle();
    public function drawRectangle();
}

class SvgDrawingApi implements DrawingApi
{
    public function drawCircle()
    {
        return "Drawing Circle In SVG\n";
    }

    public function drawRectangle()
    {
        return "Drawing Rectangle In SVG\n";
    }
}

class CanvasDrawingApi implements DrawingApi
{
    public function drawCircle()
    {
        return "Drawing Circle In Canvas\n";
    }

    public function drawRectangle()
    {
        return "Drawing Rectangle In Canvas\n";
    }
}

abstract class Shape
{
    protected $drawingApi;

    public function __construct(DrawingApi $drawingApi)
    {
        $this->drawingApi = $drawingApi;
    }

    abstract public function draw();
}

class Circle extends Shape
{
    public function __construct(DrawingApi $drawingApi)
    {
        parent::__construct($drawingApi);
    }

    public function draw()
    {
        return $this->drawingApi->drawCircle();
    }
}

class Rectangle extends Shape
{
    public function __construct(DrawingApi $drawingApi)
    {
        parent::__construct($drawingApi);
    }

    public function draw()
    {
        return $this->drawingApi->drawRectangle();
    }
}

function client_code() {
    $drawCanvasCircle = new Circle(new CanvasDrawingApi());
    echo $drawCanvasCircle->draw();

    $drawSvgRectangle = new Rectangle(new SvgDrawingApi());
    echo $drawSvgRectangle->draw();
}

client_code();
