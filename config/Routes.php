<?php
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$collection = new RouteCollection();

$collection->add(
    'PageController_home',
    new Route(
        '/',
        array(
            '_controller' => 'Invreon\SafeSpace\Controllers\PageController::home'
        ),
        array(
            '_method' => 'GET'
        )
    )
);

$collection->add(
    'PageController_about',
    new Route(
        '/about',
        array(
            '_controller' => 'Invreon\SafeSpace\Controllers\PageController::about'
        ),
        array(
            '_method' => 'GET'
        )
    )
);

$collection->add(
    'PageController_login',
    new Route(
        '/login',
        array(
            '_controller' => 'Invreon\SafeSpace\Controllers\PageController::login'
        ),
        array(
            '_method' => 'GET'
        )
    )
);

$collection->add(
    'PageController_twitter',
    new Route(
        '/twitter',
        array(
            '_controller' => 'Invreon\SafeSpace\Controllers\PageController::twitter'
        ),
        array(
            '_method' => 'GET'
        )
    )
);

return $collection;
