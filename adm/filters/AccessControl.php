<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 2.0.5
 */

namespace pavlinter\adm\filters;

use pavlinter\adm\Adm;
use Yii;
use yii\di\Instance;
use yii\web\User;


/**
 * Class AccessControl
 */
class AccessControl extends \yii\filters\AccessControl
{
    /**
     * Initializes the [[rules]] array by instantiating rule objects from configurations.
     */
    public function init()
    {
        if ($this->user === null) {
            $this->user = Adm::getInstance()->user;
        }
        $this->user = Instance::ensure($this->user, User::className());
        foreach ($this->rules as $i => $rule) {
            if (is_array($rule)) {
                $this->rules[$i] = Yii::createObject(array_merge($this->ruleConfig, $rule));
            }
        }
    }
}