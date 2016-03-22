<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.1.1
 */

namespace pavlinter\adm\rbac;

use yii\rbac\Rule;

/**
 * Checks own user
 */
class OwnUserRule extends Rule
{
    public $name = 'isOwnUser';

    /**
     * @param string|integer $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        if (is_integer($params)) {
            return $params == $user;
        } elseif ($params instanceof \yii\web\IdentityInterface){
            return $params->id == $user;
        }
        return false;
    }
}