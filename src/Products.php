<?php
namespace Itb;

class Products
{
    private $id;
    private $image;
    private $description;
    private $price;

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function __toString()
    {
        $text = '';
        $text .= 'id = ' . $this->id;
        $text .= ', description = ' . $this->description;
        $text .= ', price = ' . $this->price;

        return $text;
    }
}