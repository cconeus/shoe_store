<?php

    class Store
    {
        private $id;
        private $store;

        //construct, getters and setters
        function __construct($id = null, $store)
        {
            $this->id = $id;
            $this->store = $store;
        }

        function setStore($new_store)
        {
            $this->store = $new_store;
        }

        function getStore()
        {
            return $this->store;
        }

        function getId()
        {
            return $this->id;
        }
        //CRUD functions for save, delete, update
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO stores (store) VALUES ('{$this->getStore()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_store)
        {
            $GLOBALS['DB']->exec("UPDATE stores SET store = '{$new_store}' WHERE id = {$this->getId()};");
            $this->setStore($new_store);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
        }

        static function find($search_id)
        {
            $found_store = null;
            $stores = Store::getAll();
            foreach($stores as $store) {
                $store_id = $store->getId();

                if ($store_id == $search_id) {
                    $found_store = $store;
                }
            }
        return $found_store;
        }

        static function getAll()
        {
            $show_stores = $GLOBALS['DB']->query("SELECT * FROM stores;");
            $stores = array();
            foreach($show_stores as $store) {
                $id = $store['id'];
                $name = $store['store'];
                $new_store = new Store($id, $name);
                array_push($stores, $new_store);
            }
        return $stores;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores;");
        }
    }
 ?>
