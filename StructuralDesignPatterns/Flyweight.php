<?php

class CatVariation
{
    public $breed, $color, $size;

    public function __construct($breed, $color, $size)
    {
        $this->breed = $breed;
        $this->color = $color;
        $this->size = $size;
    }

    public function renderProfile($name, $age, $owner)
    {
        echo "Name: $name\nAge: $age\nOwner: $owner\nBreed: $this->breed\n"
            . "Color: $this->color\nSize: $this->size";
    }
}

class Cat
{
    public $name, $age, $owner;

    private $variation;

    public function __construct($name, $age, $owner, CatVariation $variation)
    {
        $this->name = $name;
        $this->age = $age;
        $this->owner = $owner;
        $this->variation = $variation;
    }

    public function matches($query)
    {
        foreach ($query as $key=>$value) {
            if (property_exists($this,$key)) {
                if($this->$key != $value) {
                    return false;
                }
            } elseif (property_exists($this->variation, $key)) {
                if($this->variation->$key != $value) {
                    return false;
                }
            } else {
                return false;
            }
        }

        return true;
    }

    public function render()
    {
        $this->variation->renderProfile($this->name, $this->age, $this->owner);
    }
}

class CatDatabase
{
    private $cats = [];
    private $variations = [];

    public function addCat($name, $age,$owner, $breed, $color, $size)
    {
        $variation = $this->getVariation($breed, $color, $size);
        $this->cats[] = new Cat($name, $age, $owner, $variation);

        echo "CatDatabase: Added a cat $name, $breed\n";
    }

    public function getVariation($breed, $color, $size)
    {
        $key = $this->getKey(get_defined_vars());

        if(!(isset($this->variations[$key]))) {
            echo "From New Object\n";
            $this->variations[$key] = new CatVariation($breed, $color, $size);
        }

        echo "From Shared Object\n";

        return $this->variations[$key];

    }

    private function getKey(array $data)
    {
        return md5(implode("_", $data));
    }

    public function findCat(array $query)
    {
        foreach ($this->cats as $cat) {
            if ($cat->matches($query)) {
                return $cat;
            }
        }
        echo "CatDataBase: Sorry, your query does not yield any results.\n";
    }
}


$db = new CatDatabase();

$db->addCat("tom", 10, "John", "burma", "golden yellow", "medium");
$db->addCat("jerry", 10, "John", "burma", "golden yellow", "medium");
$db->addCat("sam", 10, "John", "burma", "golden yellow", "medium");

$cat = $db->findCat(['name'=>'tom']);

if ($cat) {
    $cat->render();
}
