<?php

use pavlinter\adm\Adm;
use pavlinter\urlmanager\Url;
use yii\helpers\Html;


$adm = Adm::getInstance();
/* @var $i18n \pavlinter\translation\I18N */
$i18n = Yii::$app->getI18n();
$languages = $i18n->getLanguages(true);
$baseUrl = Url::getLangUrl();
?>
<header class="main-header header bg-black navbar navbar-inverse pull-in">
    <div class="navbar-header nav-bar aside dk">
        <a class="btn btn-link visible-xs" data-toggle="class:show" data-target=".nav-primary">
            <i class="fa fa-bars"></i>
        </a>
        <a href="<?= $baseUrl ?>" class="nav-brand" target="_blank">ADM<sup>cms</sup></a>
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
                        <?= $adm->user->identity->username ?> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="<?= Url::to(['/' . $adm->id . '/user/update']) ?>"><?= Adm::t("header", "Profile", ['dot' => false]) ?></a>
                    </li>
                    <?php $adm->trigger(Adm::EVENT_INNER_PROFILE_MENU); ?>
                    <li>
                        <?= Html::a(Adm::t("header", "Logout", ['dot' => false]),['/' . $adm->id . '/default/logout'],['data-method' => 'post']); ?>
                    </li>
                </ul>
            </li>
        </ul>
        <?php }?>

        <?php if ($languages) {?>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle dker" data-toggle="dropdown">
                        <?= Adm::t("header", "Languages", ['dot' => false]) ?> <b class="caret"></b>
                    </a>

                    <ul class="dropdown-menu">
                        <?php foreach ($languages as $language) {
                            $text = $language['name'];
                            if ($language['image']) {
                                $text = Html::img($language['image'], ['style' => 'height: 18px;']) . '&nbsp;' . $text;
                            }
                            ?>
                            <li><?= Html::a($text, $language['url']); ?></li>
                        <?php }?>
                    </ul>
                </li>
            </ul>
        <?php }?>
    </div>
</header>