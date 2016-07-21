<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
  //step 4 pilih variabel dan tempatkan. max=3. kalo bisa kasih filter.
    //jika atribut, tahun, dan lokasi telah dipilih, maka hide pilihan lain.
    //variabel:kategori industri dll
    //survival: pilihan variabel hanya boleh satu yang dipilih. tahun dan stribut pasti masuk variabel
?>
<div class="form-group">
<?= Html::submitButton('Generate', ['class' => 'btn btn-primary', 'name' => 'generate-button']) ?>
</div>

