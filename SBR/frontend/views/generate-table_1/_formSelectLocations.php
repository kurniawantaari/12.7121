<?php

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<h4 class="wizard-title">Step 3: Select Locations</h4>
<?php
$prop = ArrayHelper::map($propinsi, 'kdprop', 'nmprop');
echo $form->field($model, 'kdprop')->dropDownList($prop, ['prompt' => '-Pilih Propinsi-', 'id' => 'pilihPropinsi']);
echo $form->field($model, 'kdkab')->dropDownList([], ['prompt' => '-Pilih Kabupaten/Kota-', 'id' => 'pilihKabupaten']);
echo $form->field($model, 'kdkec')->dropDownList([], ['prompt' => '-Pilih Kecamatan-', 'id' => 'pilihKecamatan']);
echo $form->field($model, 'kddesa')->dropDownList([], ['prompt' => '-Pilih Desa-', 'id' => 'pilihDesa']);
//step 3 : pilih wilayah
?>
<div id="l">
</div>

<?php
$this->registerJS('
    var tempat = "di Indonesia";
    var locations = "Indonesia";
    $("#pilihDesa").attr("disabled", true);
    $("#pilihKecamatan").attr("disabled", true);
    $("#pilihKabupaten").attr("disabled", true);
    $("#pilihPropinsi").change(function () {
        $.get("' . Url::to(['get-kabupaten', 'kdprop' => '']) . '" + $(this).val(),
                function (data) {
                    select = $("#pilihKabupaten");
                    select.empty();
                    var options = "<option value=\'\'>-Pilih Kabupaten/Kota-</option>";
                    $.each(data.kabupaten, function (key, value) {
                        options += "<option value=\'" + value.kdkab + "\'>" + value.nmkab + "</option>";
                    });
                    select.append(options);
                    $("#pilihDesa").attr("disabled", true).empty().append("<option value=\'\'>-Pilih Desa-</option>");
                    $("#pilihKecamatan").attr("disabled", true).empty().append("<option value=\'\'>-Pilih Kecamatan-</option>");
                });
        if ($("#pilihPropinsi").val() != "")
        {
            $("#pilihKabupaten").attr("disabled", false);
            locations = "Propinsi";
            tempat = "di Propinsi " + $("#pilihPropinsi option:selected").text() + ", Indonesia";
        } else
        {
            $("#pilihKabupaten").attr("disabled", true).empty().append("<option value=\'\'>-Pilih Kabupaten/Kota-</option>");
            var tempat = "di Indonesia";
            var locations = "Indonesia";
        }
    });
    $("#pilihKabupaten").change(function () {
        $.get("' . Url::to(['get-kecamatan', 'kdkab' => '']) . '" + $(this).val() + "&kdprop=" + $("#pilihPropinsi").val(),
                function (data) {
                    select = $("#pilihKecamatan");
                    select.empty();
                    var options = "<option value=\'\'>-Pilih Kecamatan-</option>";
                    $.each(data.kecamatan, function (key, value) {
                        options += "<option value=\'" + value.kdkec + "\'>" + value.nmkec + "</option>";
                    });
                    select.append(options);
                    $("#pilihDesa").attr("disabled", true).empty().append("<option value=\'\'>-Pilih Desa-</option>");
                });
        if ($("#pilihKabupaten").val() != "") {
            $("#pilihKecamatan").attr("disabled", false);
            locations = "Kabupaten";
            tempat = "di Kabupaten " + $("#pilihKabupaten option:selected").text()
                    + ", Propinsi " + $("#pilihPropinsi option:selected").text()
                    + ", Indonesia";
        } else {
            $("#pilihKecamatan").attr("disabled", true).empty().append("<option value=\'\'>-Pilih Kecamatan-</option>");
            locations = "Propinsi";
            tempat = "di Propinsi " + $("#pilihPropinsi option:selected").text() + ", Indonesia";
        }
    });
    $("#pilihKecamatan").change(function () {
        $.get("' . Url::to(['get-desa', 'kdkec' => '']) . '" + $(this).val() + "&kdprop=" + $("#pilihPropinsi").val() + "&kdkab=" + $("#pilihKabupaten").val(),
                function (data) {
                    select = $("#pilihDesa");
                    select.empty();
                    var options = "<option value=\'\'>-Pilih Desa-</option>";
                    $.each(data.desa, function (key, value) {
                        options += "<option value=\'" + value.kddesa + "\'>" + value.nmdesa + "</option>";
                    });
                    select.append(options);
                });
        if ($("#pilihKecamatan").val() != "") {
            $("#pilihDesa").attr("disabled", false);
            locations = "Kecamatan";
            tempat = "di Kecamatan " + $("#pilihKecamatan option:selected").text()
                    + ", Kabupaten " + $("#pilihKabupaten option:selected").text()
                    + ", Propinsi " + $("#pilihPropinsi option:selected").text()
                    + ", Indonesia";
        } else {
            $("#pilihDesa").attr("disabled", true).empty().append("<option value=\'\'>-Pilih Desa-</option>");
            tempat = "di Kabupaten " + $("#pilihKabupaten option:selected").text()
                    + ", Propinsi " + $("#pilihPropinsi option:selected").text()
                    + ", Indonesia";
        }
    });
    $("#pilihDesa").change(function () {
        if ($("#pilihDesa").val() != "") {
            locations = "Desa";
            tempat = "di Desa " + $("#pilihDesa option:selected").text()
                    + ", Kecamatan " + $("#pilihKecamatan option:selected").text()
                    + ", Kabupaten " + $("#pilihKabupaten option:selected").text()
                    + ", Propinsi " + $("#pilihPropinsi option:selected").text()
                    + ", Indonesia";
        } else {
            locations = "Kecamatan";
            tempat = "di Kecamatan " + $("#pilihKecamatan option:selected").text()
                    + ", Kabupaten " + $("#pilihKabupaten option:selected").text()
                    + ", Propinsi " + $("#pilihPropinsi option:selected").text()
                    + ", Indonesia";
        }
    });
');
?>