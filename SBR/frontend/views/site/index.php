<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = 'Home';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><i>Indonesian Statistical Business Register</h1></i></h1>

        <p class="lead">Direktori unit usaha terintegrasi.</p>

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Custom Table</h2>

                <p>Buat tabel sesuai yang Anda inginkan dengan Custom Table. Dengan ini, variabel-variabel yang Anda butuhkan dapat dimasukkan. Untuk membangkitkan tabel, pilih menu <kbd>Generate Table</kbd> dan pilih submenu <kbd>Custom Table</kbd>, atau dengan klik tombol berikut.</p>

                <p><?= Html::a('Custom Table &raquo;', ['/generate-table/generate-custom-table'], ['class' => 'btn btn-default']) ?>
                </p>
                
            </div>
<!--            <div class="col-lg-4">
                <h2>Given Table</h2>

                <p>Buat tabel dari daftar yang tersedia. Dengan sekali klik Anda dapat melihat jumlah unit usaha yang terekam dalam SBR. Untuk membangkitkan tabel, pilih menu <kbd>Generate Table</kbd> dan pilih submenu <kbd>Given Table</kbd>, atau dengan klik tombol berikut.</p>

                <p><a class="btn btn-default" href="">Given Table &raquo;</a></p>
            </div>-->
            <div class="col-lg-4">
                <h2>SBR</h2>

                <p>An SBR is a regularly updated, structured database of specific business units in a territorial area, maintained by an NSI, and used for statistical purposes(United Nations,2015). Saat ini, BPS mulai merancang sistem SBR. Untuk menuju web BPS Pusat, klik tombol berikut.</p>

                <p><a class="btn btn-default" href="http://www.bps.go.id">Go To BPS HQ &raquo;</a></p>
            </div>
        </div>

    </div>
</div>