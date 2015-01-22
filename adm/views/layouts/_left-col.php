<?php

use pavlinter\adm\Adm;
use pavlinter\adm\widgets\Menu;

$items = [];

/* @var $adm pavlinter\adm\Adm */
$adm = Adm::getInstance();

if (isset($adm->params['left-menu']['settings']['items'])) {
    if (empty($adm->params['left-menu']['settings']['items'])) {
        unset($adm->params['left-menu']['settings']);
    }
}

foreach ($adm->params['left-menu'] as $name => $item) {
    $items[] = $item;
}
?>

<aside class="aside dk" id="nav">
    <section class="vbox">
        <section class="pleft-col">
            <div class="">
                <?php $adm->trigger(Adm::EVENT_BEFORE_LEFT_MENU); ?>
                <nav class="nav-primary hidden-xs adm-nav" data-ride="collapse">
                    <?php
                    echo Menu::widget([
                        'submenuTemplate' => "\n<ul class=\"nav none dker\">\n{items}\n</ul>\n",
                        'linkTemplate' => '<a href="{url}">{label}</a>',
                        'options' => [
                            'class' => 'nav',
                        ],
                        'itemOptions' => [

                        ],
                        'items' => $items,
                    ]);
                    ?>
                </nav>
                <?php $adm->trigger(Adm::EVENT_AFTER_LEFT_MENU); ?>
            </div>
        </section>
    </section>
</aside>