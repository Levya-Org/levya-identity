<?php

/*
 * Copyright (C) 2015 Hervé
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace app\models;

/**
 * Description of TokenExt
 *
 * @author Hervé
 */
class TokenExt extends Token{
    const TYPE_CONFIRMATION      = 0;
    const TYPE_CONNECTION        = 1;
    const TYPE_RECOVERY          = 2;
    const TYPE_CONFIRM_NEW_EMAIL = 3;
    const TYPE_CNIL_ACCESS       = 4;
}
