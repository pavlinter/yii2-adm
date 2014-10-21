<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var string $name
 * @var string $message
 * @var Exception $exception
 */

$this->title = $name;
$this->layout = 'base';
?>
<section id="content">
    <div class="row m-n">
        <div class="col-sm-4 col-sm-offset-4">
            <div class="text-center m-b-lg">
                <h1 class="h text-white animated bounceInDown"><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="list-group m-b-sm bg-white m-b-lg">
                <a href="<?= Url::to(['']) ?>" class="list-group-item">
                    <i class="fa fa-chevron-right text-muted"></i>
                    <i class="fa fa-fw fa-home text-muted"></i> Goto homepage
                </a>
                <a href="form.html" class="list-group-item">
                    <i class="fa fa-chevron-right text-muted"></i>
                    <i class="fa fa-fw fa-question text-muted"></i> Send us a tip
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-chevron-right text-muted"></i>
                    <span class="badge">021-215-584</span>
                    <i class="fa fa-fw fa-phone text-muted"></i> Call us
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