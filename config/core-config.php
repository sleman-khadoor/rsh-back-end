<?php

return [

    'roles' => [
        'super_admin' => 'super-admin-role',
        'book_admin' => 'book-admin-role',
        'blog_admin' => 'blog-admin-role',
        'news_admin' => 'news-admin-role',
        'user_management_admin' => 'usermanagement-admin-role',
        'contact_admin' => 'contact-admin-role',
        'service_admin' => 'service-admin-role',
    ],
    'users' => [
        'super_admin' => [
            'first_name' => 'super admin',
            'last_name' => 'super admin',
            'username' => 'super_admin',
            'password' => 'password',
            'is_deletable' => false,
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
        'linkedin' => '',
        'email' => '',
        'instagram' => '',
        'twitter' => '',
        'phone' => '',
        'shop_url' => ''
    ],
    'number_of_related_blogs' => 4
];

