<?php

use soft\helpers\Url;

?>
<!-- Navbar and Banner Starts -->
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="#"><img src="/template/worldforum/images/logo.png" alt="worldforum uz logo"
                                              id="logo"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= Url::to(['/']) ?>">Bosh sahifa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= Url::to(['site/galery']) ?>">Galereya</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="<?= Url::to(['site/all']) ?>" id="navbarDropdown"
                       role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        Dasturlar
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="<?= Url::to(['site/kazak-programms']) ?>">Qozog’iston</a>
                        </li>
                        <li><a class="dropdown-item" href="<?= Url::to(['site/kyrgz-programms']) ?>">Qirg’iziston</a>
                        </li>
                        <li><a class="dropdown-item" href="<?= Url::to(['site/turky-programms']) ?>">Turkiya</a></li>
                        <li><a class="dropdown-item" href="<?= Url::to(['site/russian-programms']) ?>">Rossiya</a></li>
                        <li><a class="dropdown-item" href="<?= Url::to(['site/koreya-programms']) ?>">Koreya</a></li>
                        <li><a class="dropdown-item" href="<?= Url::to(['site/japan-programms']) ?>">Yaponiya</a></li>
                        <hr>
                        <li><a class="dropdown-item" href="<?= Url::to(['site/all']) ?>">Barchasi</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= Url::to(['site/blog']) ?>">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= Url::to(['site/filials']) ?>">Filiallarimiz</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= Url::to(['site/login']) ?>">Kirish</a>
                </li>
            </ul>
        </div>
    </div>
</nav>