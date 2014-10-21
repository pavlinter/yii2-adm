<?php

use pavlinter\adm\Adm;
use yii\helpers\Html;

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
        <ul class="nav navbar-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-flask  text-white"></i>
                    <span class="text-white">UI kit</span> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="grid.html">Grid</a>
                    </li>
                    <li>
                        <a href="widgets.html">
                            <b class="badge bg-primary pull-right">8</b>Widgets
                        </a>
                    </li>
                    <li>
                        <a href="components.html">
                            <b class="badge pull-right">18</b>Components
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-file-text text-white"></i>
                    <span class="text-white">Pages</span> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="dashboard.html">Dashboard</a>
                    </li>
                </ul>
            </li>
        </ul>
        <?php if (!Adm::getInstance()->user->isGuest) {?>
        <ul class="nav navbar-nav navbar-right">

            <li class="hidden-xs">
                <a href="#" class="dropdown-toggle dk" data-toggle="dropdown">
                    <i class="fa fa-bell-o text-white"></i>
                    <span class="badge up bg-danger m-l-n-sm">2</span>
                </a>
                <section class="dropdown-menu animated fadeInUp input-s-lg">
                    <section class="panel bg-white">
                        <header class="panel-heading">
                            <strong>You have <span class="count-n">2</span> notifications</strong>
                        </header>
                        <div class="list-group">
                            <a href="#" class="media list-group-item">
                    <span class="pull-left thumb-sm">
                      <img src="<?= $admAssetUrl ?>/images/avatar.jpg" alt="John said" class="img-circle">
                    </span>
                    <span class="media-body block m-b-none">
                      Use awesome animate.css<br>
                      <small class="text-muted">28 Aug 13</small>
                    </span>
                            </a>
                            <a href="#" class="media list-group-item">
                    <span class="media-body block m-b-none">
                      1.0 initial released<br>
                      <small class="text-muted">27 Aug 13</small>
                    </span>
                            </a>
                        </div>
                        <footer class="panel-footer text-sm">
                            <a href="#" class="pull-right"><i class="fa fa-cog"></i></a>
                            <a href="#">See all the notifications</a>
                        </footer>
                    </section>
                </section>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle aside-sm dker" data-toggle="dropdown">
                      <span class="thumb-sm avatar pull-left m-t-n-xs m-r-xs">
                        <img src="<?= $admAssetUrl ?>/images/avatar.jpg">
                      </span>
                        <?= Adm::getInstance()->user->identity->username ?> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu animated fadeInLeft">
                    <li>
                        <a href="#">Settings</a>
                    </li>
                    <li>
                        <a href="profile.html">Profile</a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="badge bg-danger pull-right">3</span>
                            Notifications
                        </a>
                    </li>
                    <li>
                        <a href="docs.html">Help</a>
                    </li>
                    <li>
                        <?= Html::a(Yii::t("adm", "Logout", ['dot' => false]),['/adm/default/logout'],['data-method' => 'post']); ?>
                    </li>
                </ul>
            </li>

        </ul>
        <?php }?>
    </div>
</header>