<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;

//step 1
//default: ju\
?>
<h4 class="wizard-title">Step 1: Select Subject</h4>
<?=
        $form->field($model, 'subject')
        ->dropDownList(
                ['' => '-Pilih Subjek-', 'ju' => 'Jumlah Unit Usaha',
            'su' => 'Survival Unit Usaha',
            'se' => 'Survival Unit yang Masuk']
                , ['id' => 'pilihSubject'])
?>