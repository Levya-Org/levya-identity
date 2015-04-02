<?php

return [
    'adminEmail' => 'hostmaster@example.org',
    'token:confirmWithin' => '86400',
    'token:recoverWithin' => '21600',
    'registration:enableConfirmation' => true,
    'registration:enableRegistration' => true,
    'ldap:host' => 'example.org',
    'ldap:username' => 'cn=admin,dc=example,dc=org',
    'ldap:password' => 'PASSWORD',
    'ldap:bindRequiresDn' => true,
    'ldap:baseDn' => 'dc=example,dc=org',
];
