<?php

use pavlinter\adm\Adm;

/**
 * @var yii\web\View $this
 */

$user = Adm::getInstance()->user;
?>


<div class="adm-default-index">
    <h1><?= Adm::getInstance()->id ?></h1>
</div>
