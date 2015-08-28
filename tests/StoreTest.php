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


    class StoreTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Store::deleteAll();
            Brand::deleteAll();
        }

        function testGetStore()
        {
            //Arrange
            $id = 1;
            $store = "Payless Shoes";
            $test_store = new Store($id, $store);

            //Act
            $result = $test_store->getStore();

            //Assert
            $this->assertEquals($store, $result);
        }

        function testSetStore()
        {
            $id = 1;
            $store = "Payless Shoes";
            $test_store = new Store($id, $store);

            $test_store->setStore("JC Penny");
            $result = $test_store->getStore();

            $this->assertEquals("JC Penny", $result);
        }

        function testGetId()
        {
            $id = 1;
            $store = "Payless Shoes";
            $test_store = new Store($id, $store);

            $result = $test_store->getId();

            $this->assertEquals(1, $result);
        }

        function testSave()
        {
            //Arrange
            $id = 1;
            $store = "Payless Shoes";
            $test_store = new Store($id, $store);
            $test_store->save();

            //Act
            $result = Store::getAll();

            //Assert
            $this->assertEquals($test_store, $result[0]);
        }

        function testFind()
        {
            $id = 1;
            $store = "Payless Shoes";
            $test_store = new Store($id, $store);
            $test_store->save();

            $id2 = 2;
            $store2 = "Meyer & Frank";
            $test_store2 = new Store($id2, $store2);
            $test_store2->save();

            $result = Store::find($test_store->getId());

            $this->assertEquals($test_store, $result);
        }

        function testUpdate()
        {
            $id = 1;
            $store = "Payless Shoes";
            $test_store = new Store($id, $store);
            $test_store->save();

            $new_store = "Meyer & Franks";

            $test_store->update($new_store);

            $this->assertEquals("Meyer & Franks", $test_store->getStore());
        }

        function testDelete()
        {
            $id = 1;
            $store = "Payless Shoes";
            $test_store = new Store($id, $store);
            $test_store->save();

            $id2 = 2;
            $store2 = "Meyer & Frank";
            $test_store2 = new Store($id2, $store2);
            $test_store2->save();

            $test_store->delete();

            $this->assertEquals([$test_store2], Store::getAll());
        }

        function testGetAll()
        {
            //Arrange
            $id = 1;
            $store = "Payless Shoes";
            $test_store = new Store($id, $store);
            $test_store->save();

            $id2 = 2;
            $store2 = "Meyer & Frank";
            $test_store2 = new Store($id2, $store2);
            $test_store2->save();

            //Act
            $result = Store::getAll();

            //Assert
            $this->assertEquals([$test_store, $test_store2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $id = 1;
            $store = "Payless Shoes";
            $test_store = new Store($id, $store);
            $test_store->save();

            $id2 = 2;
            $store2 = "Meyer & Frank";
            $test_store2 = new Store($id, $store);
            $test_store2->save();

            Store::deleteAll();

            //Assert
            $result = Store::getAll();
            $this->assertEquals([], $result);
        }
    }
 ?>
