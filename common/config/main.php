<?php
/**
 * This file is part of Levya Identity.
 * 
 * Levya Identity is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Foobar. See file LICENSE(.md) in this source tree, 
 * if not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (C) Levya Team Members
 */

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => '[TOCHANGE]',
            'username' => '[TOCHANGE]',
            'password' => '[TOCHANGE]',
            'charset' => 'utf8',
        ],
        'ldap' => [
            'class' => 'nonzod\Ldap',
            'config' => [
                'host' => '127.0.0.1',
                'port' => 389,
                'username' => 'cn=identity,dc=levya,dc=org',
                'password' => '[TOCHANGE]',
                'bindRequiresDn' => true,
                'baseDn' => 'dc=levya,dc=org',
                'accountDomainName' => 'example.com'
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => 'AUTH_ITEM',
            'itemChildTable' => 'AUTH_ITEM_CHILD',
            'assignmentTable' => 'AUTH_ASSIGNMENT',
            'ruleTable' => 'AUTH_RULE'
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                ]
            ]
        ],
    ],
];
