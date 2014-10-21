<?php

use pavlinter\adm\Adm;
use yii\widgets\Breadcrumbs;

/**
 * @var \yii\web\View $this
 * @var string $content
 * @var $adm pavlinter\adm\Adm
 */

$adm = Adm::getInstance();
$this->title = 'Title';
?>

<?php $this->beginContent('@admRoot/views/layouts/base.php'); ?>
<section class="vbox">
    <?= $this->render('_header') ?>
    <section>
        <section class="hbox stretch">
            <?= $this->render('_left-col') ?>
            <section>
                <div class="breadcrumbs-box clearfix">
                    <?= Breadcrumbs::widget([
                        'homeLink' => [
                            'label' => Yii::t("adm", "Home", ['dot' => false]),  // required
                            'url' => ['/' . $adm->id],
                        ],
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
                </div>
                <div class="wrapper">
                    <?= $content; ?>
                </div>
            </section>
            <?php if ($adm->hasEventHandlers($adm::EVENT_RIGHT_MENU)) {?>
                <aside class="bg-light lter b-l aside-sm">
                    <div class="wrapper"><?php $adm->trigger($adm::EVENT_RIGHT_MENU); ?></div>
                </aside>
            <?php }?>
        </section>
    </section>
    <?= $this->render('_footer') ?>
</section>
<?php $this->endContent(); ?>
