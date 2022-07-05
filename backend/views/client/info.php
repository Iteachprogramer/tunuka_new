<div class="row">
    <div class="col-md-6 col-6">
        <div class="info-box shadow-lg">
            <span class="info-box-icon bg-success"><i class="fas fa-funnel-dollar"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Hozirgi hisob so'mda:</span>
                <span class="info-box-number"><?=number_format($model->finishAccountSum,0,' ',' ')?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-md-6 col-6">
        <div class="info-box shadow-lg">
            <span class="info-box-icon bg-success"><i class="fas fa-funnel-dollar"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Hozirgi hisob Dollarda:</span>
                <span class="info-box-number"><?=number_format($model->finishAccountSumDollar,3,'.',' ')?></span>
            </div>
        </div>
    </div>

</div>