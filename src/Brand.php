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

        //Join table getters/setters
        function addStore($store)
        {
            $GLOBALS['DB']->exec("INSERT INTO store_brand (store_id, brand_id) VALUES ({$store->getId()}, {$this->getId()});");
        }

        function getStores()
        {
            $returned_stores = $GLOBALS['DB']->query("SELECT stores.* FROM
                brand JOIN store_brand ON (brand.id = store_brand.brand_id)
                       JOIN stores ON (store_brand.store_id = store.id)
                       WHERE brand.id = {$this->getId()};");
            $stores = array();
            foreach($returned_stores as $store) {
                $name = $store['store'];
                $id = $store['id'];
                $new_store = new Store($name, $id);
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
