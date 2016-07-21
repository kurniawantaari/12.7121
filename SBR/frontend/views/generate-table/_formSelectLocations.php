<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
//step 3 pilih wilayah
    //default: indonesia
    //jika ada yang dipilih, maka wilayah harus dimasukkan sebagai variabel.
    //variabel=hierarkhir terkecil yang dipilih
    //hierarkhi: indonesia, propinsi sesuatu, kabupaten sesuatu, kecamatan sesuatu, desa sesuatu.
    
$locations='Indonesia';
?>

<div class='form-group'><div class='col-lg-offset-1 col-lg-11'>
        <?= Html::button('Next', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
