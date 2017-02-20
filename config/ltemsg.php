<?php

return [
    'dashboard' => [
        'header' => [
            'usermanage' => [
                'menu' => '用户管理',
                'action' => 'usermanage',
                'img' => 'fa fa-user',
                'desp' => '',
                'link' => '/dashboard/usermanage',
                'crumb' => ['dashboard', 'usermanage'],
            ],
           'devmanage' => [
               'menu' => '设备管理',
                'action' => 'devmanage',
                'img' => 'fa fa-plug',
                'desp' => '',
                'link' => '/dashboard/devmanage',
                'crumb' => ['dashboard', 'devmanage'],
            ],
            'feedback' => [
                'menu' => '留言反馈',
                'action' => 'feedback',
                'img' => 'fa fa-envelope-o',
                'desp' => '',
                'link' => '/dashboard/feedback',
                'crumb' => ['dashboard', 'feedback'],
            ],
            'optrecord' => [
                'menu' => '操作记录',
                'action' => 'optrecord',
                'img' => 'fa fa-flag-o',
                'desp' => '',
                'link' => '/dashboard/optrecord',
                'crumb' => ['dashboard', 'optrecord'],
            ],
            'alarminfo' => [
                'menu' => '报警提示',
                'action' => 'alarminfo',
                'img' => 'fa fa-bell-o',
                'desp' => '',
                'link' => '/dashboard/alarminfo',
                'crumb' => ['dashboard', 'alarminfo'],
            ],
            'funcmod' => [
                'menu' => '功能模块',
                'action' => 'funcmod',
                'img' => 'fa fa-cube',
                'desp' => '',
                'link' => '/dashboard/funcmod',
                'crumb' => ['dashboard', 'funcmod'],
            ],
            'userset' => [
                'menu' => '个人设置',
                'action' => 'userset',
                'img' => 'fa fa-cog',
                'desp' => '',
                'link' => '/dashboard/userset',
                'crumb' => ['dashboard', 'userset'],
            ],
        ],
    ],
];
