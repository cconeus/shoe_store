<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Brand.php";
    require_once __DIR__.'/../src/Store.php';

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=shoes';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__."/../views"
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    $app->get("/stores", function() use ($app) {
        $all_stores = Store::getAll();
        return $app['twig']->render('stores.html.twig', array('stores' => $all_stores));
    });

    $app->post("/add_store", function() use ($app) {
        $store = new Store($_POST['name']);
        $store->save();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->post("/delete_all_stores", function() use ($app) {
        Store::deleteAll();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->get("/stores/{id}/edit", function($id) use ($app) {
        $store = Store::find($id);
        $brands = $store->getBrands();
        return $app['twig']->render('store_edit.html.twig', array('store' => $store,'brands' => $brands, 'all_brands' => Brand::getAll()));
    });

    $app->patch("/stores/{id}/edit", function($id) use ($app) {
        $store = Store::find($id);
        foreach ($_POST as $key => $value) {
            if (!empty($value)) {
                $store->update($key, $value);
            }
        }
        $brand = $store->getBrands();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'brands' => $store->getBrands(), 'all_brands' => Brand::getAll()));
    });

    $app->post("/stores/{id}/add_brand", function($id) use ($app) {
        $store = Store::find($_POST['store_id']);
        $brand = Brand::find($_POST['brand_id']);
        $store->addBrand($brand);
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'brands' => $store->getBrands(), 'all_brands' => Brand::getAll()));
    });

    $app->delete("/stores/{id}/delete", function($id) use ($app) {
        $store = Store::find($id);
        $store->delete();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    $app->get("/brands", function() use ($app) {
        $all_brands = Brand::getAll();
        return $app['twig']->render('brands.html.twig', array('brands' => $all_brands));
    });

    $app->post("/add_brand", function() use ($app) {
        $brand = new Brand($_POST['name']);
        $brand->save();
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    $app->post("/delete_all_brands", function() use ($app) {
        Brand::deleteAll();
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });


    $app->get("/brands/{id}/view", function($id) use ($app) {
        $brand = Brand::find($id);
        $stores->getStores();
        return $app['twig']->render('brands_in_store.html.twig', array('brand' => $brand, 'stores' => $stores));
    });

    $app->get("/brands/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        $store_selling_brands = $brand->getStores();
        return $app['twig']->render('brands_in_store.html.twig', array('brand' => $brand, 'store' => $store_selling_brands, 'all_stores' => Store::getAll()));
    });

    $app->post("/brands/{id}", function($id) use ($app) {
        $brand = Brand::find($_POST['brand_id']);
        $store = Store::find($_POST['store_id']);
        $brand->addStore($store);
        return $app['twig']->render('brands_in_store.html.twig', array('brand' => $brand, 'stores' => $brand->getStores(), 'all_stores' => Store::getAll()));
    });
    return $app;

 ?>
