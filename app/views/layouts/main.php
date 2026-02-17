<?php

use yii\helpers\Html;
use yii\helpers\BaseUrl;
use yii\helpers\Url;
use app\helpers\Utils;

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

		<!-- <link rel="icon" href="favicon.ico" />
		<link rel="apple-touch-icon" href="apple-touch-icon.png" />
		<link rel="manifest" href="site.webmanifest" /> -->

        <link rel="stylesheet" href="css/bootstrap-5.3.3/css/bootstrap.css" />
		<link rel="stylesheet" href="css/sb-admin-7.0.7.css" />
        <link rel="stylesheet" href="css/skin-irry.css?v=2" />
        <link rel="stylesheet" href="css/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css" />

		<script src="js/fa6.js"></script>
		<script src="js/color-theme-toggler.js"></script>

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
            <a class="navbar-brand" href="https://games.irrevion.dp.ua"><img src="images/logo.jpg" alt="Irry" class="logo logo-light" /><img src="images/logo.jpg" alt="Irry" class="logo logo-dark" /> Games</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

            <ul class="navbar-nav ms-auto me-1 me-lg-4">
                <!-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownLang" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Translate"><i class="bi bi-translate"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdownLang">
                        <li><a class="dropdown-item active" href="index.html"><i class="bi bi-check"></i> English <img src="images/flag/en.png" class="flag" /></a></li>
                        <li><a class="dropdown-item" href="uk/index.html">Українська <img src="images/flag/ua.png" class="flag" /></a></li>
                        <li><a class="dropdown-item" href="az/index.html">Azərbaycan <img src="images/flag/az.png" class="flag" /></a></li>
					</ul>
                </li> -->

				<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMode" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Toggle theme"><i class="bi bi-sun-fill"></i></a>
					<ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdownMode">
                        <li><a href="#" class="dropdown-item" data-bs-theme-value="light" aria-pressed="false"><i class="bi bi-sun-fill"></i> Light</a></li>
                        <li><a href="#" class="dropdown-item" data-bs-theme-value="dark" aria-pressed="false"><i class="bi bi-moon-stars-fill"></i> Dark</a></li>
                        <li><a href="#" class="dropdown-item active" data-bs-theme-value="auto" aria-pressed="true"><i class="bi bi-circle-half"></i> Auto</a></li>
					</ul>
				</li>
			</ul>
        </nav>

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
							<div class="sb-sidenav-menu-heading">Menu</div>
							<a class="nav-link active" href="index.html">
								<div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
								Feed
							</a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main class="mb-4">
					<div class="container-fluid px-4">
                        <h1 class="mt-4">Feed</h1>

						<div class="card mb-4">
                            <div class="card-body">
								<?= $content; ?>
							</div>
						</div>
					</div>

                    <!-- <div class="container-fluid px-4">
                        <h1 class="mt-4">Home</h1>

                        <div class="card mb-4">
                            <div class="card-body">
<img src="images/telescope.jpg" alt="Telescope at night with moon and big city on background" class="float-end img-thumbnail mini" />
<p><strong>Intellectual heritage, accessible to everyone, free of charge, and everywhere, is a necessary condition and a guarantee for the survival, development, and expansion of humanity as a species.</strong></p>
<p><strong>Irrevion Science</strong> is a resource dedicated to developing applied tools for scientific calculations. The website is currently in its early development stage.</p>
<p>At the moment, the following projects are available or in development:<br />
<a href="https://github.com/irrevion/science" target="_blank">⚛️ irrevion/science</a> — a mathematical library in PHP;<br />
<a href="https://github.com/irrevion/irry_cms" target="_blank">🛠 IrryCMS</a> — a lightweight admin panel for website content management (PHP);<br />
<a href="https://github.com/irrevion/science-ui" target="_blank">🧮 Science UI</a> — a front-end interface demonstrating API capabilities, such as a <a href="https://science.irrevion.dp.ua/Converter" target="_blank">⏲ Unit Converter</a> (React);<br />
<a href="https://github.com/irrevion/science-api" target="_blank">📡 Science API</a> — an API for performing physical and mathematical calculations (PHP, Yii2);<br />
<a href="https://github.com/irrevion/game-penguin-on-iceberg" target="_blank">🐧 Penguin@Iceberg</a> — a <a href="https://games.irrevion.dp.ua/penguin-on-iceberg/" target="_blank">mini-game</a> built in pure JavaScript where you must prevent a penguin from falling off the ice floe.<br />
</p>
<hr />
<p>🖼 Image is generated by <a href="https://freepik.com/" target="_blank">🌍 Freepik</a></p>
<p>📄 Text is edited by <a href="https://chatgpt.com/" target="_blank">🌍 ChatGPT</a></p>
                            </div>
                        </div>
                    </div> -->
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
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script> -->
        <script src="css/bootstrap-5.3.3/js/bootstrap.bundle.min.js"></script>
        <script src="js/sb-admin-7.0.7.js"></script>
    <?php $this->endBody(); ?></body>
</html><?php $this->endPage(); ?>
