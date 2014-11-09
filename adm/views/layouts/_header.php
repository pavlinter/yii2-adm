<?php

use pavlinter\adm\Adm;
use yii\helpers\Html;
use yii\helpers\Url;

$adm = Adm::getInstance();
$admAssetUrl = Adm::getAsset();
?>

<header class="header bg-black navbar navbar-inverse pull-in">
    <div class="navbar-header nav-bar aside dk">
        <a class="btn btn-link visible-xs" data-toggle="class:show" data-target=".nav-primary">
            <i class="fa fa-bars"></i>
        </a>
        <a href="#" class="nav-brand" data-toggle="fullscreen">ADM</a>
        <a class="btn btn-link visible-xs" data-toggle="collapse" data-target=".navbar-collapse">
            <i class="fa fa-comment-o"></i>
        </a>
    </div>
    <div class="collapse navbar-collapse">


        <?php $adm->trigger(Adm::EVENT_TOP_MENU); ?>

        <?php if (!Adm::getInstance()->user->isGuest) {?>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle dker" data-toggle="dropdown">
                        <?= Adm::getInstance()->user->identity->username ?> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu animated fadeInLeft">
                    <li>
                        <a href="<?= Url::to(['/' . Adm::getInstance()->id . '/user/update']) ?>"><?= Adm::t("header", "Profile", ['dot' => false]) ?></a>
                    </li>
                    <?php $adm->trigger(Adm::EVENT_INNER_PROFILE_MENU); ?>
                    <li>
                        <?= Html::a(Adm::t("header", "Logout", ['dot' => false]),['/' . Adm::getInstance()->id . '/default/logout'],['data-method' => 'post']); ?>
                    </li>
                </ul>
            </li>

        </ul>
        <?php }?>
    </div>
</header>