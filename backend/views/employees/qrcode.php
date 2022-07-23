<?php
/** @var \common\models\Table $model */
$this->title = 'Qrcode'
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>QR Code Styling</title>
        <script type="text/javascript" src="https://unpkg.com/qr-code-styling@1.5.0/lib/qr-code-styling.js"></script>
    </head>
    <body>
    <?php
    $url = 'https://asprofil.brim.uz/report/report/add?id=' . $model->id;
    ?>

    </body>
    </html>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-8">
                    <div class="card card-primary card-outline card-tabs">
                        <div class="card-header p-0 pt-1 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill"
                                       href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home"
                                       aria-selected="true">Chop etish</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-three-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel"
                                     aria-labelledby="custom-tabs-three-home-tab">
                                    <div id="canvas"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <script type="text/javascript">
        const qrCode = new QRCodeStyling({
            width: 500,
            height: 530,
            type: "svg",
            data: "<?=$url?>",
            dotsOptions: {
                color: "#000000",
                type: "rounded"
            },
            backgroundOptions: {
                color: "#ffffff",
            },
            imageOptions: {
                crossOrigin: "anonymous",
                margin: 10
            }
        });
        qrCode.append(document.getElementById("canvas"));
    </script>
<?php
$js = <<< JS
 $('#custom-tabs-three-home-tab').click(function (e){
                 w = window.open();
                w.document.write($('#canvas').html());
                w.print($('#canvas').html());
                w.close();
 })
JS;
$this->registerJs($js)


?>