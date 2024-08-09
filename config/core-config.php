<?php

return [

    'roles' => [
        'super_admin' => 'super admin',
        'authors_admin' => 'Authors admin',
        'books_admin' => 'Books admin',
        'blogs_admin' => 'Blogs admin',
        'news_admin' => 'News admin',
        'users_admin' => 'Users admin',
        'represented_authors_admin' => 'Represented authors admin',
        'partners_admin' => 'Partners admin',
        'contacts_admin' => 'Contact us admin',
        'about_admin' => 'About us admin',
        'services_admin' => 'Services admin',

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
        [
            'en' => 'PAPERBACK',
            'ar' => 'كتاب ورقي'
        ],
        [
            'en' => 'Softcover',
            'ar' => 'غلاف لين'
        ],
        [
            'en' => 'Hardcover',
            'ar' => 'غلاف فني'
        ],
        [
            'en' => 'eBooks',
            'ar' => 'كتاب إلكتروني'
        ],
        [
            'en' => 'AuidoBook',
            'ar' => 'كتاب صوتي'
        ],
        [
            'en' => 'interactive book',
            'ar' => 'كتاب تفاعلي'
        ]
    ],
    'contacts' => [
        'ar_location' => '',
        'en_location' => '',
        'facebook' => '',
        'linkedIn' => '',
        'email' => '',
        'instagram' => '',
        'twitter' => '',
        'phone' => '',
        'shop_url' => ''
    ],
    'number_of_related_blogs' => 4
];

