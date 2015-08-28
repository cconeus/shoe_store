<?php

    class Brand
    {
        private $id;
        private $brand;

        function __construct($id = null, $brand)
        {
            $this->id = $id;
            $this->brand = $brand;
        }

        function getId()
        {
            return $this->id;
        }

        function getBrand()
        {
            return $this->brand;
        }

        function setBrand($new_brand)
        {
            $this->brand = $new_brand;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO brand (brand) VALUES ('{$this->getBrand()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_brands = $GLOBALS['DB']->query("SELECT * FROM brand;");
            $brands = array();
            foreach($returned_brands as $brand) {
                $id = $brand['id'];
                $name = $brand['brand'];
                $new_brand = new Brand($id, $name);
                array_push($brands, $new_brand);
            }
        return $brands;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM brand;");
        }
    }
 ?>
