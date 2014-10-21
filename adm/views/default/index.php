<?php

use pavlinter\adm\Adm;

/**
 * @var yii\web\View $this
 */

$user = Adm::getInstance()->user;

$id = '1';
?>


<div class="adm-default-index">
    <h1><?= Adm::getInstance()->id ?></h1>
    <?php //if ($user->can('createPost',['post'=> $id])) {?>
        <div>createPost</div>
    <?php //}?>



    <?php //if ($user->can('updatePost',['post'=> $id])) {?>
        <div>updatePost</div>
    <?php //}?>


</div>
