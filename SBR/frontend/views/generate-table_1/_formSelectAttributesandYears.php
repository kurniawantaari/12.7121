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

    $("#pilihSubject").change(function () {
        //isi tahun yang tersedia sesuai subject
        $.get("' . Url::to(['get-years', 'subject' => '']) . '" + $(this).val(),
                function (data) {
                    var options = "";
                    if ($("#pilihSubject").val() == "su" || $("#pilihSubject").val() == "se") {
                        $("#pilihYears").hide();
                        $("#pilihYears1").show();
                        select = $("#pilihYears1");
                        select.empty();
                        $.each(data.years, function (key, value) {
                            options += "<option value=\'" + value.tahun + "\'>" + (parseInt(value.tahun) - 3) + "-" + value.tahun + "</option>";
                        });
                    } else {
                        if ($("#pilihSubject").val() == "ju") {
                            $("#pilihYears1").hide();
                            $("#pilihYears").show();
                            select = $("#pilihYears");
                            select.empty();
                            $.each(data.years, function (key, value) {
                                options += "<label><input type=\'checkbox\' value=\'" + value.tahun + "\'>" + value.tahun + "</label>";
                            });
                        }
                    }
                    select.append(options);
                });
        //isi atribut sesuai subject        
        var attributes = [];
        if ($("#pilihSubject").val() == "su") {
            attributes = ["Jumlah Akhir Tahun", "Survived Tahun I", "Survival Rate Tahun I", "Survived Tahun II", "Survival Rate Tahun II", "Survived Tahun III", "Survival Rate Tahun III"];
        } else {
            if ($("#pilihSubject").val() == "se") {
                attributes = ["Jumlah Masuk", "Survived Tahun I", "Survival Rate Tahun I", "Survived Tahun II", "Survival Rate Tahun II", "Survived Tahun III", "Survival Rate Tahun III"];
            } else {
                if ($("#pilihSubject").val() == "ju") {
                    attributes = ["Jumlah Masuk", "Jumlah Keluar", "Jumlah Awal Tahun", "Jumlah Aktif Beroperasi", "Jumlah Akhir Tahun", "Perubahan"];
                }
            }
        }
        select = $("#pilihAttributes");
        select.empty();
        var opt = "";
        var i = 0;
        while (attributes[i]) {
            opt += "<label><input type=\'checkbox\' value=\'" + attributes[i] + "\'>" + attributes[i] + "</label>";
            i++;
        }
        select.append(opt);
    });
');
$this->registerCSS('
    #pilihAttributes>label,#pilihYears>label {
        display:block;
    }
');
?>