<?php

use yii\helpers\Html;

//step 1 pilih subject
//jumlah unit usaha
//srvival unit usaha
//survival unit yang masuk

?>
        <?= $form->field($model, 'subject')->dropDownList(['jumlah_unit' => 'Jumlah Unit Usaha', 'survival_unit' => 'Survival Unit Usaha', 'survival_masuk' => 'Survival Unit yang Masuk']) ?>
<div class='form-group'><div class='col-lg-offset-1 col-lg-11'>
<?= Html::button('Next', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

