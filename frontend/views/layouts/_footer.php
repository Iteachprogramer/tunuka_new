<?php



/* @var $this \yii\web\View */

use soft\helpers\Url;

?>
<!-- Footer Starts -->
<footer class="footer mt-auto py-3 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-3" id="copy-size">
                <a href="index.html"><img src="/template/worldforum/images/logo.png" id="logo_footer" alt="World Forum Uz Logo"></a>
                <h1 style="font-size: 1em;">Worldforum.uz</h1>
                <p>Bizni ijtimoiy tarmoqlarda kuzating:</p>
                <span class="social-links">
            <a href="https://t.me/World_Forum_Uzb"><i class="fab fa-telegram" style="color: #0088cc;"></i></a>
            <a href="#"><i class="fab fa-instagram" style="color: #833AB4;"></i></a>
            <a href="#"><i class="fab fa-facebook" style="color: #3b5998;"></i></a>
            <a href="#"><i class="fab fa-youtube" style="color: #c4302b;"></i></a>
          </span>
                <br>
                <br>
                <span id="copyright">&copy; Powered By <a href="https://besmartest.uz/" target="_blank">BeSmartest.uz</a></span>
            </div>
            <div class="col-md-3 icons-size">
                <h3>Aloqa</h3>
                <p><span><i class="fas fa-phone-alt"></i></span> +998995522113 <br>+998330616726</p>
                <p><span><i class="far fa-envelope"></i></span>worldforum@gmail.com</p>
                <p><span><i class="fas fa-map-marker-alt"></i></span>Toshkent shahar Yunusobod tumani</p>
            </div>
            <div class="col-md-3 in-map">
                <h3>Xaritada</h3>
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d23956.582419242204!2d69.263902!3d41.361638299999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1suz!2s!4v1618804473166!5m2!1suz!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
            <div class="col-md-3 filials">
                <h3>Filiallarimiz</h3>
                <ul>
                    <li><a href="<?=Url::to(['site/filials'])?>">Toshkent</a></li>
                    <li><a href="<?=Url::to(['site/filials'])?>">Samarand</a></li>
                    <li><a href="<?=Url::to(['site/filials'])?>">Buxoro</a></li>
                    <li><a href="<?=Url::to(['site/filials'])?>">Navoiy</a></li>
                    <li><a href="<?=Url::to(['site/filials'])?>">Xorazm</a></li>
                    <li><a href="<?=Url::to(['site/filials'])?>">Qashqadaryo</a></li>
                    <li><a href="<?=Url::to(['site/filials'])?>">Surxondaryo</a></li>
                </ul>
            </div>
        </div>

    </div>
</footer>
<!-- Footer Ends -->
