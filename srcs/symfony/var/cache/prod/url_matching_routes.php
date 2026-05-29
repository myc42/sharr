<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/api/test-ip' => [[['_route' => 'test_ip', '_controller' => 'App\\Controller\\HomeController::testIp'], null, null, null, false, false, null]],
        '/' => [[['_route' => 'app_home', '_controller' => 'App\\Controller\\HomeController::index'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/([^/]++)(*:16)'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        16 => [
            [['_route' => 'app_room', '_controller' => 'App\\Controller\\HomeController::room'], ['token'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
