<?php

use pavlinter\adm\Adm;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var string $name
 * @var string $message
 * @var Exception $exception
 */

$this->title = $name;

if (!Adm::getInstance()->user->getIsGuest()) {
    $this->context->module->layout = 'main';
} else {
    $this->context->module->layout = 'base';
}
?>
<section id="content">
    <div class="row m-n">
        <div class="col-sm-4 col-sm-offset-4">
            <div class="text-center m-b-lg">
                <h1 class="text-black animated bounceInDown"><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="list-group m-b-sm bg-white m-b-lg">
                <a href="<?= Url::to(['/']) ?>" class="list-group-item">
                    <i class="fa fa-chevron-right text-muted"></i>
                    <i class="fa fa-fw fa-home text-muted"></i> Homepage
                </a>
            </div>
        </div>
    </div>
</section>
<!-- footer -->
<footer id="footer">
    <div class="text-center padder clearfix">
        <p>
            <small><?= nl2br(Html::encode($message)) ?></small>
        </p>
    </div>
</footer>