<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Store.php";
    require_once "src/Brand.php";

    $server = 'mysql:host=localhost:8889;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Store::deleteAll();
            Brand::deleteAll();
        }

        function testGetBrand()
        {
            //Arrange
            $brand = "Sketchers";
            $test_brand = new Brand($id, $brand);

            //Act
            $result = $test_brand->getBrand();

            //Assert
            $this->assertEquals($brand, $result);
        }

        function testSetBrand()
        {
            //Arrange
            $brand = "Sketchers";
            $test_brand = new Brand($id, $brand);

            $test_brand->setBrand("Vans");
            $result = $test_brand->getBrand();

            $this->assertEquals("Vans", $result);
        }

        function testGetId()
        {
            $id = 1;
            $brand = "Sketchers";
            $test_brand = new Brand($id, $brand);

            $result = $test_brand->getId();

            $this->assertEquals(1, $result);
        }

        function testSave()
        {
            $id = 1;
            $brand = "Sketchers";
            $test_brand = new Brand($id, $brand);

            $test_brand->save();

            $result = Brand::getAll();
            $this->assertEquals($test_brand, $result[0]);
        }

        function testDelete()
        {
            $id = 1;
            $store = "Payless Shoes";
            $test_store = new Store($id, $store);
            $test_store->save();

            $id2 = 2;
            $brand = "Sketchers";
            $test_brand = new Brand($id2, $brand);
            $test_brand->save();

            $test_brand->addStore($test_store);
            $test_brand->delete();

            $this->assertEquals([], $test_store->getBrands());
        }

        function testGetAll()
        {
            $id = 1;
            $brand = "Sketchers";
            $test_brand = new Brand($id, $brand);
            $test_brand->save();

            $id2 = 2;
            $brand2 = "Nike";
            $test_brand2 = new Brand($id2, $brand2);
            $test_brand2->save();

            $result = Brand::getAll();

            $this->assertEquals([$test_brand, $test_brand2], $result);
        }

        function testDeleteAll()
        {
            $id = 1;
            $brand = "Sketchers";
            $test_brand = new Brand($id, $brand);
            $test_brand->save();

            $id2 = 2;
            $brand2 = "Nike";
            $test_brand2 = new Brand($id2, $brand2);
            $test_brand2->save();

            Brand::deleteAll();

            $result = Brand::getAll();
            $this->assertEquals([], $result);
        }

        function testAddStore()
        {
            //Arrange
            $id = null;
            $store = "Payless Shoes";
            $test_store = new Store($store, $id);
            $test_store->save();

            $brand = "Sketchers";
            $test_task = new Brand($brand, $id);
            $test_task->save();

            //Act
            $test_task->addStore($test_store);

            //Assert
            $this->assertEquals($test_task->getStores(), [$test_store]);
        }

        function testGetStores()
        {
            //Arrange
            $id = null;
            $store = "Payless Shoes";
            $test_store = new Store($store, $id);
            $test_store->save();

            $id2 = null;
            $store2 = "JC Penny";
            $test_store2 = new Store($store2, $id2);
            $test_store2->save();

            $brand = "Sketchers";
            $test_brand = new Brand($brand, $id3);
            $test_brand->save();

            //Act
            $test_brand->addStore($test_store);
            $test_brand->addStore($test_store2);

            //Assert
            $this->assertEquals($test_brand->getStores(), [$test_store, $test_store2]);
        }
    }
 ?>
