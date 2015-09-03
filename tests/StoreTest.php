<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Store.php";
    require_once "src/Brand.php";

    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StoreTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Store::deleteAll();
            Brand::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Payless Shoes";
            $test_store = new Store($name);

            //Act
            $result = $test_store->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Payless Shoes";
            $id = 1;
            $test_store = new Store($name, $id);

            //Act
            $result = $test_store->getId();

            //Assert
            $this->assertEquals($id, $result);
        }

        function test_save()
        {
            //Arrange
            $name = "Payless Shoes";
            $test_store = new Store($name);

            //Act
            $test_store->save();

            //Assert
            $result = Store::getAll();
            $this->assertEquals($test_store, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Payless Shoes";
            $test_store = new Store($name);
            $test_store->save();

            $name2 = "Another store";
            $test_store2 = new Store($name);
            $test_store2->save();

            //Act
            $result = Store::getAll();

            //Assert
            $this->assertEquals([$test_store, $test_store2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Payless Shoes";
            $test_store = new Store($name);
            $test_store->save();

            $name2 = "Another Store";
            $test_store2 = new Store($name);
            $test_store2->save();

            //Act
            Store::deleteAll();

            //Assert
            $result = Store::getAll();
            $this->assertEquals([], $result);
        }

        function test_updateName()
        {
            //Arrange
            $name = "Payless Shoes";
            $test_store = new Store($name);
            $test_store->save();

            $column_to_update = "name";
            $new_info = "Shoes";

            //Act
            $test_store->update($column_to_update, $new_info);

            //Assert
            $result = Store::getAll();
            $this->assertEquals("Shoes", $result[0]->getName());
        }

        function test_find()
        {
            //Arrange
            $name = "Payless Shoes";
            $test_store = new Store($name);
            $test_store->save();

            //Act
            $result = Store::find($test_store->getId());

            //Assert
            $this->assertEquals($test_store, $result);
        }


        function test_delete()
        {
            //Arrange
            $name = "Payless Shoes";
            $test_store = new Store($name);
            $test_store->save();

            $name2 = "Another Store";
            $test_store2 = new Store($name);
            $test_store2->save();

            //Act
            $test_store->delete();

            //Assert
            $result = Store::getAll();
            $this->assertEquals($test_store2, $result[0]);
        }

        function test_addBrand()
        {
            //Arrange
            $name = "Payless Shoes";
            $test_store = new Store($name);
            $test_store->save();

            $name = "Sketchers";
            $test_brand = new Brand($name);
            $test_brand->save();

            //Act
            $test_store->addBrand($test_brand);

            //Assert
            $result = $test_store->getBrands();
            $this->assertEquals([$test_brand], $result);
        }

        function test_getBrands()
        {
            //Arrange
            $name = "Payless Shoes";
            $test_store = new Store($name);
            $test_store->save();

            $name = "Sketchers";
            $test_brand = new Brand($name);
            $test_brand->save();

            $name2 = "New Balance";
            $test_brand2 = new Brand($name);
            $test_brand2->save();

            //Act
            $test_store->addBrand($test_brand);
            $test_store->addBrand($test_brand2);

            //Assert
            $result = $test_store->getBrands();
            $this->assertEquals([$test_brand, $test_brand2], $result);
        }



    }

 ?>
