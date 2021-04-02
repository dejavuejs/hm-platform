<?php

return [
    [
        'key' => 'dashboard',
        'name' => 'admin::app.layouts.dashboard',
        'route' => 'admin.dashboard.index',
        'sort' => 1,
        'icon-class' => 'dashboard-icon',
    ], [
        'key' => 'catalog',
        'name' => 'admin::app.layouts.catalog',
        'route' => 'admin.catalog.categories.index',
        'sort' => 3,
        'icon-class' => 'catalog-icon',
    ]
    // , [
    //     'key' => 'catalog.categories',
    //     'name' => 'admin::app.layouts.categories',
    //     'route' => 'admin.catalog.categories.index',
    //     'sort' => 3,
    //     'icon-class' => '',
    // ]
    , [
        'key' => 'audiences',
        'name' => 'admin::app.layouts.audiences',
        'route' => 'admin.audience.index',
        'sort' => 4,
        'icon-class' => 'audience-icon',
    ], [
        'key' => 'audiences.audiences',
        'name' => 'admin::app.layouts.audiences',
        'route' => 'admin.audience.index',
        'sort' => 1,
        'icon-class' => '',
    ], [
        'key' => 'audiences.groups',
        'name' => 'admin::app.layouts.groups',
        'route' => 'admin.groups.index',
        'sort' => 2,
        'icon-class' => '',
    ], [
        'key' => 'audiences.reviews',
        'name' => 'admin::app.layouts.reviews',
        'route' => 'admin.audience.review.index',
        'sort' => 3,
        'icon-class' => '',
    ], [
        'key' => 'audiences.subscribers',
        'name' => 'admin::app.layouts.newsletter-subscriptions',
        'route' => 'admin.audiences.subscribers.index',
        'sort' => 4,
        'icon-class' => '',
    ], [
        'key' => 'configuration',
        'name' => 'admin::app.layouts.configure',
        'route' => 'admin.configuration.index',
        'sort' => 7,
        'icon-class' => 'configuration-icon',
    ], [
        'key' => 'settings',
        'name' => 'admin::app.layouts.settings',
        'route' => 'admin.locales.index',
        'sort' => 6,
        'icon-class' => 'settings-icon',
    ], [
        'key' => 'settings.locales',
        'name' => 'admin::app.layouts.locales',
        'route' => 'admin.locales.index',
        'sort' => 1,
        'icon-class' => '',
    ], [
        'key' => 'settings.currencies',
        'name' => 'admin::app.layouts.currencies',
        'route' => 'admin.currencies.index',
        'sort' => 2,
        'icon-class' => '',
    ], [
        'key' => 'settings.exchange_rates',
        'name' => 'admin::app.layouts.exchange-rates',
        'route' => 'admin.exchange_rates.index',
        'sort' => 3,
        'icon-class' => '',
    ], [
        'key' => 'settings.channels',
        'name' => 'admin::app.layouts.channels',
        'route' => 'admin.channels.index',
        'sort' => 5,
        'icon-class' => '',
    ], [
        'key' => 'settings.users',
        'name' => 'admin::app.layouts.users',
        'route' => 'admin.users.index',
        'sort' => 6,
        'icon-class' => '',
    ], [
        'key' => 'settings.users.users',
        'name' => 'admin::app.layouts.users',
        'route' => 'admin.users.index',
        'sort' => 1,
        'icon-class' => '',
    ], [
        'key' => 'settings.users.roles',
        'name' => 'admin::app.layouts.roles',
        'route' => 'admin.roles.index',
        'sort' => 2,
        'icon-class' => '',
    ], [
        'key' => 'settings.sliders',
        'name' => 'admin::app.layouts.sliders',
        'route' => 'admin.sliders.index',
        'sort' => 7,
        'icon-class' => '',
    ], [
        'key' => 'cms',
        'name' => 'admin::app.layouts.cms',
        'route' => 'admin.cms.index',
        'sort' => 6,
        'icon-class' => 'cms-icon',
    ], [
        'key' => 'cms.pages',
        'name' => 'admin::app.cms.pages.pages',
        'route' => 'admin.cms.index',
        'sort' => 1,
        'icon-class' => '',
    ]
];