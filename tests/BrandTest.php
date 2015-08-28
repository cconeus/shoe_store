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
            $id = 1;
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
            $id = 1;
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
    }
 ?>
