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
 * Copyright (C) 2013 Mike Mackintosh <mike@bakeryphp.com> 
 *   (dtr/ip)[https://github.com/mikemackintosh/dTR-IP]
 * Copyright (C) Levya Team Members
 */

namespace common\helpers;

class IPHelper {

    /**
     * Convert an IP (string) to a binary format
     * @author Mike Mackintosh - mike@bakeryphp.com
     * @param type $ip
     * @return string
     * @throws \Exception
     */
    public static function IPtoBin($ip) {
        
        if (YII_ENV_DEV && ($ip == '::1' || $ip == '127.0.0.1')) {
            return current(unpack("A4", inet_pton('fe80:1:2:3:a:bad:1dea:dad')));
        }

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return current(unpack("A4", inet_pton($ip)));
        } elseif (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return current(unpack("A16", inet_pton($ip)));
        }

        throw new \Exception("Please supply a valid IPv4 or IPv6 address");

        return false;
    }

    /**
     * Converta binary IP to readable IP
     * @author Mike Mackintosh - mike@bakeryphp.com
     * @param type $str
     * @return string
     * @throws \Exception
     */
    public static function BinToStr($str) {
        
        if (YII_ENV_DEV) {
            return '127.0.0.1';
        }
        
        if (strlen($str) == 16 OR strlen($str) == 4) {
            return inet_ntop(pack("A" . strlen($str), $str));
        }

        throw new \Exception("Please provide a 4 or 16 byte string");

        return false;
    }

}
