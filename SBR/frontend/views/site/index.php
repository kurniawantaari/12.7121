<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = 'Beranda';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><i>Indonesian Statistical Business Register</h1></i></h1>

        <p class="lead">Direktori unit usaha terintegrasi.</p>

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-6">
                <h2>Tabel Custom</h2>

                <p>Buat tabel sesuai yang Anda inginkan dengan Tabel Custom. Dengan ini, variabel-variabel yang Anda butuhkan dapat dimasukkan. Untuk membangkitkan tabel, pilih menu <kbd>Buat Tabel</kbd> dan pilih submenu <kbd>Tabel Custom</kbd>, atau dengan klik tombol berikut.</p>

                <p><?= Html::a('Tabel Custom &raquo;', ['/generate-table/generate-custom-table'], ['class' => 'btn btn-default']) ?>
                </p>
                
            </div>
<!--            <div class="col-lg-4">
                <h2>Given Table</h2>

                <p>Buat tabel dari daftar yang tersedia. Dengan sekali klik Anda dapat melihat jumlah unit usaha yang terekam dalam SBR. Untuk membangkitkan tabel, pilih menu <kbd>Generate Table</kbd> dan pilih submenu <kbd>Given Table</kbd>, atau dengan klik tombol berikut.</p>

                <p><a class="btn btn-default" href="">Given Table &raquo;</a></p>
            </div>-->
            <div class="col-lg-6">
                <h2>SBR</h2>

                <p>An SBR is a regularly updated, structured database of specific business units in a territorial area, maintained by an NSI, and used for statistical purposes(United Nations,2015). Saat ini, BPS mulai merancang sistem SBR. Untuk menuju web BPS Pusat, klik tombol berikut.</p>

                <p><a class="btn btn-default" href="http://www.bps.go.id">Ke BPS RI &raquo;</a></p>
            </div>
        </div>

    </div>
</div>