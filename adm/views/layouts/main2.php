<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/**
 * @var \yii\web\View $this
 * @var string $content
 */

$this->title = 'Title';
?>

<?php $this->beginContent('@admRoot/views/layouts/base.php'); ?>
    <section class="hbox stretch">
        <?= $this->render('_left-col2') ?>
        <?= $this->render('_header2') ?>
        <section id="content">
            <section class="vbox">
                <header class="header bg-white b-b header-breadcrumbs">
                        <?php if ($this->title) {?>
                            <div class="ptitle"><?= Html::encode($this->title) ?></div>
                        <?php }?>

                        <?= Breadcrumbs::widget([
                            'homeLink' => [
                                'label' => Yii::t("adm", "Home", ['dot' => false]),  // required
                                'url' => ['/adm'],
                            ],
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        ]) ?>

                </header>



                <section class="scrollable wrapper">
                    <?= $content ?>
                </section>
            </section>
            <?= $this->render('_footer2') ?>
        </section>
    </section>
<?php $this->endContent(); ?>
