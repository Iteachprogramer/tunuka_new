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
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                         Klient
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= Url::to(['/client']) ?>" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Klient
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Url::to(['/point/point']) ?>" class="nav-link">
                                <i class="nav-icon fas fa-hand-point-right"></i>
                                <p>
                                    Ballar
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Url::to(['/prasent']) ?>" class="nav-link">
                                <i class="nav-icon fas fa-prescription-bottle-alt"></i>
                                <p>
                                  Foiz
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?= Url::to(['/statistics']) ?>" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            Statistika
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-coins"></i>
                        <p>
                            Kassa
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= Url::to(['/account']) ?>" class="nav-link">
                                <i class="nav-icon fas fa-coins"></i>
                                <p>
                                    Kassa
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Url::to(['/account/basket']) ?>" class="nav-link">
                                <i class="nav-icon fas fa-coins"></i>
                                <p>
                                    Kassa korzinka
                                </p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-upload"></i>
                        <p>
                            Yuk oldi berdi
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= Url::to(['/income']) ?>" class="nav-link">
                                <i class="nav-icon fas fa-download"></i>
                                <p>
                                    Yuk sotib olish
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Url::to(['/outcome-group']) ?>" class="nav-link">
                                <i class="nav-icon fas fa-upload"></i>
                                <p>
                                    Yuk sotish
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?= Url::to(['/outcome/rulons']) ?>" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Rulon xisoboti
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= Url::to(['/product-list']) ?>" class="nav-link">
                        <i class="nav-icon fas fa-store-alt"></i>
                        <p>
                            Tovarlar
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= Url::to(['/make-product']) ?>" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Ishlab chiqarish
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= Url::to(['/dollar-course']) ?>" class="nav-link">
                        <i class="nav-icon fas fa-dollar-sign"></i>
                        <p>
                           Dollar Kursi
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= Url::to(['/expense-type']) ?>" class="nav-link">
                        <i class="nav-icon fas fa-store-alt"></i>
                        <p>
                            Harajatlar
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= Url::to(['/usermanager']) ?>" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Foydalanuvchilar
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Xodimlar
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= Url::to(['/employees']) ?>" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Xodimlar
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Url::to(['/report/report']) ?>" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Xodimlar hisoboti
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Url::to(['/report/report/list']) ?>" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Oylik hisoboti
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
