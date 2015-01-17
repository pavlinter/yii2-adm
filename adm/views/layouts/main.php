<?php

use pavlinter\adm\Adm;
use yii\widgets\Breadcrumbs;

/**
 * @var \yii\web\View $this
 * @var string $content
 * @var $adm pavlinter\adm\Adm
 */

$adm = Adm::getInstance();
if (empty($this->title)) {
    $this->title  = 'Adm';
}
?>

<?php $this->beginContent('@admRoot/views/layouts/base.php'); ?>

<section class="vbox">
    <?= $this->render('_header') ?>
    <section>
        <section class="hbox stretch">
            <?= $this->render('_left-col') ?>
            <section class="main-box">
                <?php if (isset($this->params['breadcrumbs'])) {?>

                    <div class="breadcrumbs-box clearfix">
                        <?php
                        echo Breadcrumbs::widget([
                            'homeLink' => [
                                'label' => Yii::t("adm", "Home", ['dot' => false]),  // required
                                'url' => ['/' . $adm->id],
                            ],
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        ]);
                       ?>
                    </div>
                <?php }?>
                <div class="wrapper">
                        <?php Adm::widget('Alert', [
                            'options' => [
                                'class' => 'main-alert',
                            ]
                        ]);?>
                    <?= $content; ?>
                </div>
            </section>
            <?php if ($adm->hasEventHandlers(Adm::EVENT_RIGHT_MENU)) {?>
                <aside class="bg-light lter b-l aside-sm">
                    <div class="wrapper"><?php $adm->trigger(Adm::EVENT_RIGHT_MENU); ?></div>
                </aside>
            <?php }?>
        </section>

    </section>
    <?= $this->render('_footer') ?>
</section>
<?php $this->endContent(); ?>
