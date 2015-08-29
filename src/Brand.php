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

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM brand WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM store_brand WHERE store_id = {$this->getId()};");
        }

        //Join table getters/setters
        function addStore($store)
        {
            $GLOBALS['DB']->exec("INSERT INTO store_brand (store_id, brand_id) VALUES ({$store->getId()}, {$this->getId()});");
        }

        function getStores()
        {
            $query = $GLOBALS['DB']->query("SELECT store_id FROM store_brand WHERE brand_id = {$this->getId()};");
            $store_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $stores = array();
            foreach($store_ids as $id) {
                $store_id = $id['store_id'];
                $result = $GLOBALS['DB']->query("SELECT * FROM stores WHERE id = {$store_id};");
                $returned_store = $result->fetchAll(PDO:: FETCH_ASSOC);

                $id = $returned_store[0]['id'];
                $brand = $returned_store[0]['store'];
                $new_store = new Store($id, $store);
                array_push($stores, $new_store);
            }
        return $stores;
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
