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

namespace app\rbac;

use yii\rbac\Rule;

/**
 * AhReadOwnRule
 *
 * @author Hervé
 */
class AhReadOwnRule extends Rule{
    
    public $name = 'read:own.actionhistory';
    
    public function execute($user, $item, $params) {
        return isset($params['actionhistory']) ? $params['actionhistory']->USER_USER_ID == $user : false;
    }

}
