<?php

use yii\helpers\Html;
use yii\helpers\BaseUrl;
use yii\helpers\Url;
use app\helpers\Utils;
use app\widgets\Menu;
use app\widgets\LangPicker;

$this->beginPage();

?><!DOCTYPE html>
<html lang="<?= Yii::$app->language; ?>" data-bs-theme="dark">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<?php $this->registerCsrfMetaTags(); ?>

        <meta name="description" content="PC gaming blog with story-driven playthroughs, sharp commentary, honest reviews, and practical guides." />
        <meta name="author" content="Valentin Belousov" />

        <title><?= Html::encode($this->title); ?></title>

		<link rel="icon" href="favicon.ico" />
		<!-- <link rel="apple-touch-icon" href="apple-touch-icon.png" />
		<link rel="manifest" href="site.webmanifest" /> -->

        <link rel="stylesheet" href="<?= \yii\helpers\Url::to('@web/css/bootstrap-5.3.3/css/bootstrap.css') ?>">
		<link rel="stylesheet" href="<?= \yii\helpers\Url::to('@web/css/sb-admin-7.0.7.css') ?>">
        <link rel="stylesheet" href="<?= \yii\helpers\Url::to('@web/css/skin-irry.css') ?>">
        <link rel="stylesheet" href="<?= \yii\helpers\Url::to('@web/css/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css') ?>">

		<script src="<?= \yii\helpers\Url::to('@web/js/fa6.js') ?>"></script>
		<script src="<?= \yii\helpers\Url::to('@web/js/color-theme-toggler.js') ?>"></script>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-YW6LFL6DG8"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-YW6LFL6DG8');
</script>

		<?php $this->head(); ?>
    </head>
    <body class="sb-nav-fixed skin-irry"><?php $this->beginBody(); ?>
        <nav class="sb-topnav navbar navbar-expand navbar-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand" href="https://games.irrevion.dp.ua"><img src="<?= Url::to('@web/images/logo.jpg'); ?>" alt="Irry" class="logo logo-light" /><img src="<?= Url::to('@web/images/logo.jpg'); ?>" alt="Irry" class="logo logo-dark" /><span id="brand-text"> Games</span></a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

            <ul class="navbar-nav ms-auto me-1 me-lg-4">
                <?= LangPicker::widget(); ?>

				<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMode" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Toggle theme"><i class="bi bi-sun-fill"></i></a>
					<ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdownMode">
                        <li><a href="#" class="dropdown-item" data-bs-theme-value="light" aria-pressed="false"><i class="bi bi-sun-fill"></i> <?= Yii::t('app', 'theme_light'); ?></a></li>
                        <li><a href="#" class="dropdown-item" data-bs-theme-value="dark" aria-pressed="false"><i class="bi bi-moon-stars-fill"></i> <?= Yii::t('app', 'theme_dark'); ?></a></li>
                        <li><a href="#" class="dropdown-item active" data-bs-theme-value="auto" aria-pressed="true"><i class="bi bi-circle-half"></i> <?= Yii::t('app', 'theme_auto'); ?></a></li>
					</ul>
				</li>
			</ul>
        </nav>

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
							<div class="sb-sidenav-menu-heading"><?= Yii::t('app', 'menu_title'); ?></div>

                            <?= Menu::widget(); ?>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main class="mb-4">
					<?= $content; ?>
                </main>

                <footer class="py-4 mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div>&copy;Irrevion 2025 &ndash; <?= date('Y'); ?></div>

                            <div>
                                <a href="https://youtube.com/@irrevion" title="YouTube" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                                &middot;
                                <a href="https://www.tiktok.com/@irrevion" title="TikTok" target="_blank"><i class="fa-brands fa-tiktok"></i></a>
                                &middot;
                                <a href="https://t.me/irrevion_games" title="Telegram" target="_blank"><i class="fa-brands fa-telegram"></i></a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="<?= Url::to('@web/css/bootstrap-5.3.3/js/bootstrap.bundle.min.js'); ?>"></script>
        <script src="<?= Url::to('@web/js/sb-admin-7.0.7.js'); ?>"></script>
    <?php $this->endBody(); ?></body>
</html><?php $this->endPage(); ?>
