<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 2.0.1
 */

namespace pavlinter\adm;

/**
 * Interface BootstrapInterface
 */
interface AdmBootstrapInterface
{
    /**
     * Loading method to be called during adm bootstrap stage.
     * @param Adm $adm the module currently running
     */
    public function loading($adm);
}