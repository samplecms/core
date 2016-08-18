<?php
 

return [
    '__pattern__' => [
        'name' => '\w+',
    ],

    
    'pages/:type'     => 'index/index/page',

    'view/:id'     => 'index/index/view',
    
    'login'     => 'admin/index/login',
    'adminField/:eqtype'     => 'admin/field/index',
    'adminFile'     => 'admin/file/index',
];
