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

namespace common\models;

/**
 * Description of TokenExt
 *
 * @author Hervé
 */
class TokenExt extends Token{
    /*
     * Token used to confirm a User registration
     */
    const TYPE_USER_CONFIRMATION    = 0;
    /*
     * Token used to confirm a User to Member registration
     */
    const TYPE_MEMBER_CONFIRMATION  = 1;
    /*
     * Token used to confirm a User password change
     */
    const TYPE_RECOVERY             = 2;
    /*
     * Token used to confirm a User email change
     */
    const TYPE_CONFIRM_NEW_EMAIL    = 3;
    /*
     * Token used to configm a brute access of his data
     */
    const TYPE_CNIL_ACCESS          = 4;
    /*
     * Token used to confirm removal of User personnal data 
     */
    const TYPE_CNIL_PARTIAL_DELETE  = 5;
    /*
     * Token used to confirm removal of all related User data
     * This must erase all data about a given user. 
     */
    const TYPE_CNIL_FULL_DELETE     = 6;
}
