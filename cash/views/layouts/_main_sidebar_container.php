<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$route = Yii::$app->controller->route;
$class = 'active';
$menuOpenClass = 'menu-open';

$beginDate = date('01.m.Y');
$endDate = date('t.m.Y');


?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= Url::to(['/']) ?>" class="brand-link">
        <img src="/frontend/web/adminLte3/img/AdminLTELogo.png" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3" style="opacity: .8;width: 29px">
        <span class="brand-text font-weight-light"><?= Yii::$app->name ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?= Url::to(['/']) ?>" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Bosh sahifa
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= Url::to(['/account']) ?>" class="nav-link">
                        <i class="nav-icon fas fa-coins"></i>
                        <p>
                            Kassa
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= Url::to(['/outcome-group']) ?>" class="nav-link">
                        <i class="nav-icon fas fa-upload"></i>
                        <p>
                            Sotilgan yuklar
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
