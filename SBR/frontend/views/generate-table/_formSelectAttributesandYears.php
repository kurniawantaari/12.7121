<?php

use yii\helpers\Html;
use yii\helpers\Url;

//step 2 pilih atribut dan tahun
?>
<h4 class="wizard-title">Step 2: Select Attributes and Years</h4>
<?= $form->field($model, 'attributes')->checkboxList([], ['id' => 'pilihAttributes']) ?>
<?php
echo "<h5>Tahun</h5>";
echo $form->field($model, 'years')->checkboxList([], ['id' => 'pilihYears'])->label(false);
echo $form->field($model, 'years')->dropdownList([], ['id' => 'pilihYears1', 'prompt' => '-Pilih Tahun-'])->label(false);
?>
<?php
//jika atribut >1 yang dipilh, jadikan variabel dan harus dipilih waktu drag and drop
//jumlah unit
//jika tahun dipilih>1, jadikan variabel dan harus dipilih waktu drag and drop
//atribut: entry, exit, jml,...  default:jumlah
//tahun  default:tahun terakhir

$this->registerJS('
    var variables = [];
    var selectedAttributes = [];
    var selectedYears = [];

    $("#stepGenerateTable_step2_next").click(function () {
        $("[id=\'pilihAtributes\']:checked").each(function () {
            selectedAttributes.push($(this).val());
            });
            window.alert(selectedAttribut.length);
        if (selectedAttributes.length > 1) {
            variables.push("Atribut");
        }
        $("[id=\'pilihYears\']:checked").each(function () {
            selectedYears.push($(this).val());
        });
        if (selectedYears.length > 1) {
            variables.push("Tahun");
        }
    });

');
?>