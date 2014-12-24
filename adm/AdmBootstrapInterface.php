<?php

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