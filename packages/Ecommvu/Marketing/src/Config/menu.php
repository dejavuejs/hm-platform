<?php

return [
    [
        'key'        => 'marketing',
        'name'       => 'admin::app.layouts.marketing',
        'route'      => 'admin.email-templates.index',
        'sort'       => 5,
        'icon-class' => 'promotion-icon',
    ], [
        'key'        => 'marketing.promotions',
        'name'       => 'admin::app.layouts.promotions',
        'route'      => 'admin.email-templates.index',
        'sort'       => 1,
        'icon-class' => '',
    ], [
        'key'        => 'marketing.email-marketing',
        'name'       => 'admin::app.layouts.email-marketing',
        'route'      => 'admin.email-templates.index',
        'sort'       => 2,
        'icon-class' => '',
    ], [
        'key'        => 'marketing.email-marketing.email-templates',
        'name'       => 'admin::app.layouts.email-templates',
        'route'      => 'admin.email-templates.index',
        'sort'       => 1,
        'icon-class' => '',
    ], [
        'key'        => 'marketing.email-marketing.events',
        'name'       => 'admin::app.layouts.events',
        'route'      => 'admin.events.index',
        'sort'       => 2,
        'icon-class' => '',
    ], [
        'key'        => 'marketing.email-marketing.campaigns',
        'name'       => 'admin::app.layouts.campaigns',
        'route'      => 'admin.campaigns.index',
        'sort'       => 2,
        'icon-class' => '',
    ], [
        'key'        => 'marketing.email-marketing.subscribers',
        'name'       => 'admin::app.layouts.newsletter-subscriptions',
        'route'      => 'admin.customers.subscribers.index',
        'sort'       => 3,
        'icon-class' => '',
    ]
];
