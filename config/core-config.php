<?php

return [

    'roles' => [
        'super_admin' => 'super admin',
        'services_admin' => 'services admin',
        'contacts_admin' => 'contacts admin',
        'authors_admin' => 'authors admin',
        'blogs_admin' => 'blogs admin',
    ],
    'users' => [
        'super_admin' => [
            'first_name' => 'super admin',
            'last_name' => 'super admin',
            'username' => 'super admin',
            'password' => 'password',
            'is_deletable' => false
        ],
        'services_admin' => [
            'first_name' => 'services admin',
            'last_name' => 'services admin',
            'username' => 'services admin',
            'password' => 'password',
            'is_deletable' => true
        ],
        'contacts_admin' => [
            'first_name' => 'contacts admin',
            'last_name' => 'contacts admin',
            'username' => 'contacts admin',
            'password' => 'password',
            'is_deletable' => true
        ],
        'authors_admin' => [
            'first_name' => 'authors admin',
            'last_name' => 'authors admin',
            'username' => 'authors admin',
            'password' => 'password',
            'is_deletable' => true
        ],
        'blogs_admin' => [
            'first_name' => 'blogs admin',
            'last_name' => 'blogs admin',
            'username' => 'blogs admin',
            'password' => 'password',
            'is_deletable' => true
        ],
    ]
];

