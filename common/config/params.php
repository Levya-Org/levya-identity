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
    'token:confirmUserWithin' => '86400',
    'token:confirmMemberWithin' => '86400',
    'token:confirmEmailWithin' => '86400',
    'token:recoverWithin' => '21600',
    'token:cnilWithIn' => '21600',
    'registration:enableConfirmation' => true,
    'registration:enableRegistration' => true,
    'ldap:host' => '127.0.0.1',
    'ldap:port' => '389',
    'ldap:username' => 'cn=identity,dc=levya,dc=org',
    'ldap:password' => '[TOCHANGE]',
    'ldap:bindRequiresDn' => true,
    'ldap:baseDn' => 'dc=levya,dc=org',
    'google:apiKey' => '[TOCHANGE]'
];
