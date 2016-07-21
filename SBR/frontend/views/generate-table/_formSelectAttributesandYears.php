<?php

use yii\helpers\Html;
//step 2 pilih atribut dan tahun
//jika atribut >1 yang dipilh, jadikan variabel dan harus dipilih waktu drag and drop
//jumlah unit
//jika tahun dipilih, jadikan variabel dan harus dipilih waktu drag and drop
//survival
//tahun hanya boleh satu
//atribut: entry, exit, jml,...  default:jumlah
//tahun  default:tahun terakhir

$attributes = ['entry' => 'Masuk',
    'exit' => 'Keluar',
    'jumlah' => 'Jumlah Akhir Tahun'];
$years = ['2012' => '2012', '2013' => '2013'];
?>
    <?php
echo $form->field($model, 'attributes')->checkboxList($attributes);
echo $form->field($model, 'years')->checkboxList($years);
?>
<div class='form-group'><div class='col-lg-offset-1 col-lg-11'>
<?= Html::button('Next', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

