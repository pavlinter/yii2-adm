<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.0.1
 */

namespace pavlinter\adm;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Manager is used in order to create models.
 */
class Manager extends \yii\base\Component
{
    /**
     * @param string $name
     * @param array $params
     * @return mixed|object
     */
    public function __call($name, $params)
    {
        $query  = strpos($name, 'Query');
        $static = strpos($name, 'static');
        if ($static === 0) {
            $property = mb_substr($name, 6);
        }else if ($query !== false) {
            $property = mb_substr($name, 6, -5);
        } else {
            $property = mb_substr($name, 6);
        }

        $property = lcfirst($property) . 'Class';

        if ($static === 0) {
            $method = ArrayHelper::remove($params, '0', 'className');
            return forward_static_call_array([$this->$property, $method], $params);
        }
        if ($query) {
            $method = ArrayHelper::remove($params, '0', 'find');
            return forward_static_call_array([$this->$property, $method], $params);
        }
        if (isset($this->$property)) {
            $config = [];
            if (isset($params[0]) && is_array($params[0])) {
                $config = $params[0];
            }
            $config['class'] = $this->$property;
            return Yii::createObject($config);
        }
        return parent::__call($name, $params);
    }
}