<?php

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
