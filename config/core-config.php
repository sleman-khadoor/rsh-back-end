<?php

return [

    'roles' => [
        'super_admin' => 'super admin',
        'services_admin' => 'services admin',
        'contacts_admin' => 'contacts admin',
        'authors_admin' => 'authors admin',
        'blogs_admin' => 'blogs admin',
        'books_admin' => 'books admin',
    ],
    'users' => [
        'super_admin' => [
            'first_name' => 'super admin',
            'last_name' => 'super admin',
            'username' => 'super_admin',
            'password' => 'password',
            'is_deletable' => false
        ],
        'services_admin' => [
            'first_name' => 'services admin',
            'last_name' => 'services admin',
            'username' => 'services_admin',
            'password' => 'password',
            'is_deletable' => true
        ],
        'contacts_admin' => [
            'first_name' => 'contacts admin',
            'last_name' => 'contacts admin',
            'username' => 'contacts_admin',
            'password' => 'password',
            'is_deletable' => true
        ],
        'authors_admin' => [
            'first_name' => 'authors admin',
            'last_name' => 'authors admin',
            'username' => 'authors_admin',
            'password' => 'password',
            'is_deletable' => true
        ],
        'blogs_admin' => [
            'first_name' => 'blogs admin',
            'last_name' => 'blogs admin',
            'username' => 'blogs_admin',
            'password' => 'password',
            'is_deletable' => true
        ],
        'books_admin' => [
            'first_name' => 'books admin',
            'last_name' => 'books admin',
            'username' => 'books admin',
            'password' => 'password',
            'is_deletable' => true
        ],
    ],
    'langs' => [
        'arabic' => 'ar',
        'english' => 'en'
    ],
    'book_formats' => [
        'E-Book',
        'PDF',
        'word'
    ],
    'contacts' => [
        'facebook' => 'rashm.facebook',
        'whatsapp' => '99201011',
        'email' => 'rashm@gmail.com'
    ],
    'notifications' => [
        'keys' => [
            'contact_form' => 'contact_requests'
        ]
    ]
];

