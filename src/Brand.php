<?php
    class Brand
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
        $this->name = $name;
        $this->id = $id;
        }


        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getId()
        {
            return $this->id;
        }


        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO brands (name) VALUES ('{$this->getName()}');");
                $this->id = $GLOBALS['DB']->lastInsertId();
        }


        function addStore($store)
        {
            $GLOBALS['DB']->exec("INSERT INTO stores_brands (store_id, brand_id) VALUES (
                {$store->getId()}, {$this->getId()}
            );");
        }

        function getStores()
        {
            $stores_query = $GLOBALS['DB']->query(
                "SELECT stores.* FROM
                    brands JOIN stores_brands ON (brands.id = stores_brands.brand_id)
                           JOIN stores        ON (stores_brands.store_id = stores.id)
                WHERE brands.id = {$this->getId()};"
            );

            $matching_stores = array();
            foreach ($stores_query as $store) {
                $name = $store['name'];
                $id = $store['id'];
                $new_store = New Store($name, $id);
                array_push($matching_stores, $new_store);
            }
            return $matching_stores;
        }


        static function getAll()
        {
            $brands_query = $GLOBALS['DB']->query("SELECT * FROM brands;");
            $all_brands = array();
            foreach ($brands_query as $brand) {
                $name = $brand['name'];
                $id = $brand['id'];
                $new_brand = new Brand($name, $id);
                array_push($all_brands, $new_brand);
            }
            return $all_brands;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands;");
        }

        static function find($search_id)
        {
            $found_brand = null;
            $brands = Brand::getAll();
            foreach ($brands as $brand) {
                if($brand->getId() == $search_id) {
                    $found_brand = $brand;
                }
            }
            return $found_brand;
        }
    }

 ?>
