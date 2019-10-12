<?php
/**
 * Copyright © Nguyen Huu The <thenguyen.dev@gmail.com>.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

/** @var \Similik\Services\Routing\Router $router */
$router->addAdminRoute('product.grid', 'GET', '/products', [
//    \Similik\Module\Catalog\Middleware\Product\Grid\ColumnMiddleware::class,
//    \Similik\Module\Catalog\Middleware\Product\Grid\BuildCollectionMiddleware::class,
    \Similik\Module\Catalog\Middleware\Product\Grid\GridMiddleware::class,
    \Similik\Module\Catalog\Middleware\Product\Grid\ActionColumn::class,
]);

$ProductEditMiddleware = [
    \Similik\Module\Catalog\Middleware\Product\Edit\InitMiddleware::class,
    \Similik\Module\Catalog\Middleware\Product\Edit\FormMiddleware::class,
    \Similik\Module\Catalog\Middleware\Product\Edit\GeneralInfoMiddleware::class,
    \Similik\Module\Catalog\Middleware\Product\Edit\ImagesMiddleware::class,
    \Similik\Module\Catalog\Middleware\Product\Edit\SeoMiddleware::class,
    \Similik\Module\Catalog\Middleware\Product\Edit\PriceMiddleware::class,
    \Similik\Module\Catalog\Middleware\Product\Edit\CategoryMiddleware::class,
    \Similik\Module\Catalog\Middleware\Product\Edit\AttributeMiddleware::class,
    \Similik\Module\Catalog\Middleware\Product\Edit\CustomOptionMiddleware::class,
];
$router->addAdminRoute('product.create', 'GET', '/product/create', $ProductEditMiddleware);

$router->addAdminRoute('product.edit', 'GET', '/product/edit/{id:\d+}', $ProductEditMiddleware);

$router->addAdminRoute('product.save', 'POST', '/product/save[/{id:\d+}]', [
    \Similik\Module\Catalog\Middleware\Product\Save\ValidateMiddleware::class,
    \Similik\Module\Catalog\Middleware\Product\Save\UpdateMiddleware::class,
    \Similik\Module\Catalog\Middleware\Product\Save\CreateMiddleware::class
]);

$router->addAdminRoute('product.delete', 'GET', '/product/delete/{id:\d+}', [
//    \Similik\Module\Catalog\Middleware\Product\Save\ValidateMiddleware::class,
//    \Similik\Module\Catalog\Middleware\Product\Save\UpdateMiddleware::class,
//    \Similik\Module\Catalog\Middleware\Product\Save\CreateMiddleware::class
]);

//////////////// CATEGORY ////////////////////

$router->addAdminRoute('category.grid', 'GET', '/categories', [
    \Similik\Module\Catalog\Middleware\Category\Grid\GridMiddleware::class,
]);

$categoryEditMiddleware = [
    \Similik\Module\Catalog\Middleware\Category\Edit\InitMiddleware::class,
    \Similik\Module\Catalog\Middleware\Category\Edit\FormMiddleware::class,
    \Similik\Module\Catalog\Middleware\Category\Edit\GeneralInfoMiddleware::class,
    \Similik\Module\Catalog\Middleware\Category\Edit\SeoMiddleware::class,
    \Similik\Module\Catalog\Middleware\Category\Edit\ProductsMiddleware::class
];
$router->addAdminRoute('category.create', 'GET', '/category/create', $categoryEditMiddleware);

$router->addAdminRoute('category.edit', 'GET', '/category/edit/{id:\d+}', $categoryEditMiddleware);

$router->addAdminRoute('category.save', 'POST', '/category/save[/{id:\d+}]', [
    \Similik\Module\Catalog\Middleware\Category\Save\ValidateMiddleware::class,
    \Similik\Module\Catalog\Middleware\Category\Save\UpdateMiddleware::class,
    \Similik\Module\Catalog\Middleware\Category\Save\CreateMiddleware::class
]);

$router->addAdminRoute('category.delete', 'GET', '/category/delete/{id:\d+}', [
//    \Similik\Module\Catalog\Middleware\Category\Save\ValidateMiddleware::class,
//    \Similik\Module\Catalog\Middleware\Category\Save\UpdateMiddleware::class,
//    \Similik\Module\Catalog\Middleware\Category\Save\CreateMiddleware::class
]);

////////////////////////////////////////////
///            SITE ROUTERS           //////
////////////////////////////////////////////
$categoryViewMiddleware = [
    \Similik\Module\Catalog\Middleware\Category\View\InitMiddleware::class,
    \Similik\Module\Catalog\Middleware\Category\View\GeneralInfoMiddleware::class,
    \Similik\Module\Catalog\Middleware\Category\View\ProductsMiddleware::class
];
$router->addSiteRoute('category.view', 'GET', '/catalog/id/{id:\d+}', $categoryViewMiddleware);

// Pretty url
$router->addSiteRoute('category.view.pretty', 'GET', '/catalog/{slug}', $categoryViewMiddleware);

$productViewMiddleware = [
    \Similik\Module\Catalog\Middleware\Product\View\InitMiddleware::class,
    \Similik\Module\Catalog\Middleware\Product\View\GeneralInfoMiddleware::class,
    \Similik\Module\Catalog\Middleware\Product\View\ImagesMiddleware::class,
    \Similik\Module\Catalog\Middleware\Product\View\AttributeMiddleware::class,
    \Similik\Module\Catalog\Middleware\Product\View\FormMiddleware::class,
];
$router->addSiteRoute('product.view', 'GET', '/products/id/{id:\d+}', $productViewMiddleware);

// Pretty url
$router->addSiteRoute('product.view.pretty', 'GET', '/products/{slug}', $productViewMiddleware);