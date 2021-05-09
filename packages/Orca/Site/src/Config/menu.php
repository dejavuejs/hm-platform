<?php

return [
    [
        'key' => 'account',
        'name' => 'site::app.layouts.my-account',
        'route' =>'customer.profile.index',
        'sort' => 1
    ], [
        'key' => 'account.profile',
        'name' => 'site::app.layouts.profile',
        'route' =>'customer.profile.index',
        'sort' => 1
    ], [
        'key' => 'account.address',
        'name' => 'site::app.layouts.address',
        'route' =>'customer.address.index',
        'sort' => 2
    ], [
        'key' => 'account.reviews',
        'name' => 'site::app.layouts.reviews',
        'route' =>'customer.reviews.index',
        'sort' => 3
    ], [
        'key' => 'account.wishlist',
        'name' => 'site::app.layouts.wishlist',
        'route' =>'customer.wishlist.index',
        'sort' => 4
    ], [
        'key' => 'account.orders',
        'name' => 'site::app.layouts.orders',
        'route' =>'customer.orders.index',
        'sort' => 5
    ]

];

?>