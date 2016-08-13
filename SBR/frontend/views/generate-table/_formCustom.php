<?php
/* @var $this yii\web\View */

use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use frontend\models\Propinsi;

$this->title = 'Tes Table Generator';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="generate-table">
    <h1><?= Html::encode($this->title) ?></h1>


    <?php
    $form = ActiveForm::begin([
                'id' => 'table-generator-form',
                'options' => ['class' => 'form-horizontal'],
    ]);
    ?>
    <h4 class="wizard-title">Step 1: Select Subject</h4>
    <?php
    echo $form->field($model, 'subject')->widget(Select2::classname(), [
        'data' => ['ju' => 'Jumlah Unit Usaha', 'su' => 'Survival Unit Usaha', 'se' => 'Survival Unit yang Masuk'],
        'language' => 'en',
        'options' => [
            'placeholder' => 'Select Subject ...',
            'id' => 'selectSubject',
            'onchange' => '$("select#selectAttributes").val("").trigger("change");'
            . '$("select#selectAttributes").attr("disabled", false);'
            . 'if ($(this).val() == "su" || $(this).val() == "se") {
                $("select#selectYears").removeAttr("multiple");
                } else {
                $("select#selectYears").attr("multiple", "");
                }'
            . '$("select#selectYears").val("").trigger("change");'
            . '$("select#selectYears").attr("disabled", false);'
            . '    $.post("' . Url::to(['get-years', 'subject' => '']) . '" + $(this).val(),
                    function (data) {
                    $("select#selectYears").html(data);
                    });' 
            . '    $.post("' . Url::to(['get-attributes', 'subject' => '']) . '" + $(this).val(),
                    function (data) {
                    $("select#selectAttributes").html(data);
                    });',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]);
    ?>
    <h4 class="wizard-title">Step 2: Select Attributes and Years</h4>
    <?php
    //jika atribut >1 yang dipilh, jadikan variabel dan harus dipilih waktu drag and drop
//jumlah unit
//jika tahun dipilih>1, jadikan variabel dan harus dipilih waktu drag and drop
//atribut: entry, exit, jml,...  default:jumlah
//tahun  default:tahun terakhir
    ?>
    <?=
    $form->field($model, 'attributes')->widget(Select2::classname(), [
        'data' => [],
        'language' => 'en',
        'options' => [
            'placeholder' => 'Select Attributes...',
            'id' => 'selectAttributes',
            'disabled' => true,
            'multiple' => true,
        //         'onchange' => 'if($(this).val().length>1){attributes=true;}else{attributes=false;}',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])
    ?>
    <h5>Select Years</h5>
    <?=
    $form->field($model, 'years')->widget(Select2::classname(), [
        'data' => [],
        'language' => 'en',
        'disabled' => true,
        'options' => [
            'placeholder' => 'Select Years...',
            'id' => 'selectYears',
        //'multiple'=>false,
        //       'onchange' => 'if($(this).val().length>1){years=true;}else{years=false;}',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])
    ?>

    <h4 class="wizard-title">Step 3: Select Locations</h4>
    <?php
// Parent Propinsi
    echo $form->field($model, 'kdprop')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Propinsi::find()->where(['not', ['kdprop' => '00']])->andWhere(['not', ['kdprop' => '95']])->all(), 'kdprop', 'nmprop'),
        'language' => 'en',
        'disabled' => true,
        'options' => [
            'placeholder' => 'Select Province ...',
            //'multiple' => true,
            'id' => 'selectProvinces',
            'onchange' => '$("select#selectKabupaten").val("").trigger("change");'
            . '$.post("' . Url::to(['get-kabupaten', 'kdprop' => '']) . '" + $(this).val(),
                function (data) {
                $("select#selectKabupaten").html(data);
                $("#selectDesa").attr("disabled", true).empty().append("<option value=\'\'>-Pilih Desa-</option>");
                $("#selectKecamatan").attr("disabled", true).empty().append("<option value=\'\'>-Pilih Kecamatan-</option>");
                });',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]);
    echo $form->field($model, 'kdkab')->widget(Select2::classname(), [
        'data' => [],
        'language' => 'en',
        'disabled' => true,
        'options' => [
            'placeholder' => 'Select Kabupaten/Kota...',
            //'multiple' => true,
            'id' => 'selectKabupaten',
            'onchange' => '$("select#selectKecamatan").val("").trigger("change");'
            . '$.post("' . Url::to(['get-kecamatan', 'kdkab' => '']) . '" + $(this).val() + "&kdprop=" + $("#selectProvinces").val(),
                function (data) {
                $("select#selectKecamatan").html(data);
                $("#selectDesa").attr("disabled", true).empty().append("<option value=\'\'>-Pilih Desa-</option>");
            });',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]);
    echo $form->field($model, 'kdkec')->widget(Select2::classname(), [
        'data' => [],
        'language' => 'en',
        'disabled' => true,
        'options' => [
            'placeholder' => 'Select Kecamatan...',
            //'multiple' => true,
            'id' => 'selectKecamatan',
            'onchange' => '$("select#selectDesa").val("").trigger("change");'
            . '$.post("' . Url::to(['get-desa', 'kdkec' => '']) . '" + $(this).val() + "&kdprop=" + $("#selectProvinces").val() + "&kdkab=" + $("#selectKabupaten").val(),
                function (data) {
                $("select#selectDesa").html(data);
                            });',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]);
    echo $form->field($model, 'kddesa')->widget(Select2::classname(), [
        'data' => [],
        'language' => 'en',
        'disabled' => true,
        'options' => [
            'placeholder' => 'Select Desa...',
            //'multiple' => true,
            'id' => 'selectDesa',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]);
    ?>
    <h4 class="wizard-title">Step 4: Select Variables</h4>
    <?=
    $form->field($model, 'variables')->widget(Select2::classname(), [
        'data' => [],
        'options' => [
            'multiple' => true,
            'id' => 'selectVariables',
        ],
    ])
    ?>
    <div class="select-variables">

        <div class="container-fluid">
            <div class=" col-xs-12 col-sm-4">
                <p>select element here</p>
                <ul id="variables" class="connectedVariables" style="padding:5px;min-height: 50px;background:#eaeae1;">
                    <li>Variable 1</li>
                    <li>Variable 2</li>
                    <li>Variable 3</li>
                    <li>Variable 4</li>
                    <li>satu satu</li>
                    <li>dua dua</li>
                    <li>tiga-tiga</li>
                    <li>satu</li>
                    <li>dua</li>
                </ul>
            </div>
            <!--drop object here-->
            <div class="col-xs-12 col-sm-8 drop">  
                <p>drop variable here</p>

                <ul id="tabrow" class="connectedVariables col-xs-6 col-sm-5" style="min-height:200px;padding:2px 0 2px 0;background:whitesmoke">

                </ul>


                <ul id="tabcol" class="connectedVariables col-xs-6 col-sm-7" style="min-height:100px;padding: 2px 0 2px 0;background:whitesmoke;border-left:dotted lightgrey 2px;">

                </ul>

            </div>
        </div>
        <?= Html::submitButton('Generate Table', ['class ' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>

<?php
$css = <<< CSS
            /* ---- variables---- */
    .drop{
       background:#eaeae1; 
        padding:10px;
   }
        #variables li,#tabrow li,#tabcol li {
        background-color: #ffad33;/*item yang di-drag n drop*/
        padding: 5px;
        margin: 2px;
        list-style-position: inside;
        list-style-type: none;
    }

    .drop-placeholder {/*placeholder=pembantu dimana item akan ditempatkan*/
        background-color:transparent !important;
        border: 2px dashed darkorange;
            }
       .watermark {
    opacity: 0.5;
    color: blue;
    position: absolute;
    top: 50%;
        
        
    
}
CSS;
$this->registerCss($css);

$this->registerJS('
        $("#variables, #tabcol,#tabrow").sortable({
        items: "> li",
        connectWith: ".connectedVariables",
        // axis: "x" //only horizontally or vertically
        cancel: "a.ui-icon", // clicking an icon wont initiate dragging
        containment: $(".select-variables"),
        cursor: "move",
        //handle:".handle"
        //helper: "clone",
        // forceHelperSize: false,
        //opacity: 0.7, //opacity helper
        dropOnEmpty: true,
        placeholder: "drop-placeholder",
        forcePlaceholderSize: true,
        revert: true,
        //scroll:false
        tolerance: "pointer",
    }).disableSelection();
');
//definisikan variable vartempat dan judul tabel [tempat]
$this->registerJs('
    var attributes=false;
    var years=false;
    var tempat = "di Indonesia";
    var vartempat = "Indonesia";
    $("#selectProvinces").change(function () {
        if ($("#selectProvinces").val() != "")
        {
            $("#selectKabupaten").attr("disabled", false);
            vartempat = "Propinsi";
            tempat = "di Propinsi " + $("#selectProvinces option:selected").text() + ", Indonesia";
        } else
        {
            $("#selectKabupaten").attr("disabled", true).empty().append("<option value=\'\'>-Pilih Kabupaten/Kota-</option>");
            var tempat = "di Indonesia";
            var vartempat = "Indonesia";
        }
    });
    $("#selectKabupaten").change(function () {

        if ($("#selectKabupaten").val() != "") {
            $("#selectKecamatan").attr("disabled", false);
            vartempat = "Kabupaten";
            tempat = "di Kabupaten " + $("#selectKabupaten option:selected").text()
                    + ", Propinsi " + $("#selectProvinces option:selected").text()
                    + ", Indonesia";
        } else {
            $("#selectKecamatan").attr("disabled", true).empty().append("<option value=\'\'>-Pilih Kecamatan-</option>");
            vartempat = "Propinsi";
            tempat = "di Propinsi " + $("#selectProvinces option:selected").text() + ", Indonesia";
        }
    });
    $("#selectKecamatan").change(function () {
        if ($("#selectKecamatan").val() != "") {
            $("#selectDesa").attr("disabled", false);
            vartempat = "Kecamatan";
            tempat = "di Kecamatan " + $("#selectKecamatan option:selected").text()
                    + ", Kabupaten " + $("#selectKabupaten option:selected").text()
                    + ", Propinsi " + $("#selectProvinces option:selected").text()
                    + ", Indonesia";
        } else {
            $("#selectDesa").attr("disabled", true).empty().append("<option value=\'\'>-Pilih Desa-</option>");
            vartempat = "Kabupaten";
            tempat = "di Kabupaten " + $("#selectKabupaten option:selected").text()
                    + ", Propinsi " + $("#selectProvinces option:selected").text()
                    + ", Indonesia";
        }
    });
    $("#selectDesa").change(function () {
        if ($("#selectDesa").val() != "") {
            vartempat = "Desa";
            tempat = "di Desa " + $("#selectDesa option:selected").text()
                    + ", Kecamatan " + $("#selectKecamatan option:selected").text()
                    + ", Kabupaten " + $("#selectKabupaten option:selected").text()
                    + ", Propinsi " + $("#selectProvinces option:selected").text()
                    + ", Indonesia";
        } else {
            vartempat = "Kecamatan";
            tempat = "di Kecamatan " + $("#selectKecamatan option:selected").text()
                    + ", Kabupaten " + $("#selectKabupaten option:selected").text()
                    + ", Propinsi " + $("#selectProvinces option:selected").text()
                    + ", Indonesia";
        }
    });
');
?>  


