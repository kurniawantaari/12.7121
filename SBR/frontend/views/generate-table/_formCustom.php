<?php
/* @var $this yii\web\View */

use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use frontend\models\Kategori;
use frontend\models\Unitstatistik;
use frontend\models\Statusperusahaan;
use frontend\models\Institusi;
use frontend\models\Kepemilikan;
use frontend\models\Jaringanusaha;
use frontend\models\Propinsi;

$this->title = 'Generate Custom Table';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="generate-table">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $form = ActiveForm::begin([
                'id' => 'table-generator-form',
                'method' => 'post',
                'options' => ['class' => 'form-horizontal'],
    ]);
    ?>
    <h4 class="wizard-title">Step 1: Select Subject</h4>
    <div class="bg-info">*Subjek harus dipilih.</div>
    <?php
    echo $form->field($model, 'subject')->widget(Select2::classname(), [
        'data' => ['ju' => 'Jumlah Unit Usaha', 'su' => 'Survival Unit Usaha', 'se' => 'Survival Unit yang Masuk'],
        'language' => 'en',
        'options' => [
            'placeholder' => 'Select Subject ...',
            'id' => 'selectSubject',
            'onchange' => '$("select#selectAttributes").val("").trigger("change");'
            . '$("select#selectYears").val("").trigger("change");'
            . 'if ($(this).val() == "") {
                $("select#selectAttributes").attr("disabled", true);
                $("select#selectYears").attr("disabled", true);
                } else {
                $("select#selectAttributes").attr("disabled", false);
                $("select#selectYears").attr("disabled", false);
                }'
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
    ])->label("Subject");
    ?>
    
    <h4 class="wizard-title">Step 2: Select Attributes and Years</h4>
    <div class="bg-info">*Atribut harus dipilih, minimal 1.</div>
    <?=
    $form->field($model, 'attributes')->widget(Select2::classname(), [
        'data' => [],
        'language' => 'en',
        'options' => [
            'placeholder' => 'Select Attributes...',
            'id' => 'selectAttributes',
            'disabled' => true,
            'multiple' => true,
        ],
        'theme' => Select2::THEME_KRAJEE,
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label("Attributes")
    ?>
    <div class="bg-info">*Tahun harus dipilih, minimal 1.</div>
            <?=
    $form->field($model, 'years')->widget(Select2::classname(), [
        'data' => [],
        'language' => 'en',
        'disabled' => true,
        'options' => [
            'placeholder' => 'Select Years...',
            'id' => 'selectYears',
            'multiple' => true,
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label("Years")
    ?>
   
    <h4 class="wizard-title">Step 3: Select Locations</h4>
    <div class="bg-info">*Lokasi dapat diabaikan (di-skip).</div>
        <?php
    echo $form->field($model, 'kdprop')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Propinsi::find()->where(['not', ['kdprop' => '00']])
                        ->andWhere(['not', ['kdprop' => '95']])->all(), 'kdprop', 'nmprop'),
        'language' => 'en',
        'options' => [
            'placeholder' => 'Select Provinsi ...',
            //  'multiple' => true,
            'id' => 'selectProvinces',
            'onchange' => '$.post("' . Url::to(['get-kabupaten', 'kdprop' => '']) . '" + $(this).val(),
        function (data) {
            $("select#selectKabupaten").html(data);
            $("select#selectKabupaten").val("").trigger("change");
            $("#selectDesa").attr("disabled", true);
            $("#selectKecamatan").attr("disabled", true);
                    });

if ($(this).val() == "" || $(this).val() == null) {
    $("#selectKabupaten").attr("disabled", true);

} else {
    $("#selectKabupaten").attr("disabled", false);
}
',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label("Provinsi");
    echo $form->field($model, 'kdkab')->widget(Select2::classname(), [
        'data' => [],
        'language' => 'en',
        'disabled' => true,
        'options' => [
            'placeholder' => 'Select Kabupaten/Kota...',
            // 'multiple' => true,
            'id' => 'selectKabupaten',
            'onchange' => '$.post("' . Url::to(['get-kecamatan', 'kdkab' => ''])
            . '" + $(this).val() + "&kdprop=" + $("#selectProvinces").val(),
        function (data) {
            $("select#selectKecamatan").html(data);
            $("select#selectKecamatan").val("").trigger("change");
            $("#selectDesa").attr("disabled", true);
                    });
if ($(this).val() == "" || $(this).val() == null) {
    $("#selectKecamatan").attr("disabled", true);
} else {
    $("#selectKecamatan").attr("disabled", false);
}
                ',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label("Kabupaten");
    echo $form->field($model, 'kdkec')->widget(Select2::classname(), [
        'data' => [],
        'language' => 'en',
        'disabled' => true,
        'options' => [
            'placeholder' => 'Select Kecamatan...',
            //'multiple' => true,
            'id' => 'selectKecamatan',
            'onchange' => '$.post("' . Url::to(['get-desa', 'kdkec' => '']) . '" + $(this).val() + "&kdprop=" + $("#selectProvinces").val() + "&kdkab=" + $("#selectKabupaten").val(),
        function (data) {
            $("select#selectDesa").html(data);
             $("select#selectDesa").val("").trigger("change");
                     });
if ($(this).val() == "" || $(this).val() == null) {
    $("#selectDesa").attr("disabled", true);
} else {
    $("#selectDesa").attr("disabled", false);
}',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label("Kecamatan");
    echo $form->field($model, 'kddesa')->widget(Select2::classname(), [
        'data' => [],
        'language' => 'en',
        'disabled' => true,
        'options' => [
            'placeholder' => 'Select Desa...',
            // 'multiple' => true,
            'id' => 'selectDesa',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label("Desa");
    ?>
   
    <h4 class="wizard-title">Step 4: Select Variables</h4>
    <div class="bg-info">*Pilih dan filter variabel yang diinginkan.</div>
    <?=
    $form->field($model, 'kdkategori')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Kategori::find()->where(['tahun' => '2015'])->all(), 'kdkategori', 'nmkategori'),
        'language' => 'en',
        'options' => [
            'placeholder' => 'Select Kategori...',
            'id' => 'selectKategori',
            'multiple' => true,
            'onchange' => '$("select#selectKbli").val("").trigger("change");
                $("select#selectKbli").attr("disabled", true);'
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label("Kategori")
    ?>
    <?php
    echo Html::button('Filter Kbli', [ 'class' => 'btn btn-primary',
        'onclick' => 'if($("#selectKategori").val()!=null&&$("#selectKategori").val()!=""){$.post("' . Url::to(['get-kbli', 'kdkategori' => '']) . '" + $("#selectKategori").val(), function (data) {
    $("#selectKbli").html(data);$("#selectKbli").attr("disabled",false);
});}else{window.alert("tidak ada kategori yang dipilih");}']);
    ?>
    <?=
    $form->field($model, 'kdkbli')->widget(Select2::classname(), [
        'data' => [],
        'language' => 'en',
        'options' => [
            'placeholder' => 'Select KBLI...',
            'id' => 'selectKbli',
            'multiple' => true,
            'disabled' => true,
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label("KBLI")
    ?>
    <?=
    $form->field($model, 'unitstatistik')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Unitstatistik::find()->all(), 'kdsu', 'nmsu'),
        'language' => 'en',
        'options' => [
            'placeholder' => 'Select Unit Statistik...',
            'id' => 'selectUnitstatistik',
            'multiple' => true,
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label("Unit Statistik")
    ?>
    <?=
    $form->field($model, 'statusperusahaan')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Statusperusahaan::find()->all(), 'kdkondisi', 'nmkondisi'),
        'language' => 'en',
        'options' => [
            'placeholder' => 'Select Status Perusahaan...',
            'id' => 'selectStatusperusahaan',
            'multiple' => true,
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label("Status Perusahaan")
    ?>

    <?=
    $form->field($model, 'institusi')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Institusi::find()->all(), 'kdinstitusi', 'nminstitusi'),
        'language' => 'en',
        'options' => [
            'placeholder' => 'Select Sektor Institusi...',
            'id' => 'selectInstitusi',
            'multiple' => true,
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label("Sektor Institusi")
    ?>
    <?=
    $form->field($model, 'kepemilikan')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Kepemilikan::find()->all(), 'kdkepemilikan', 'nmkepemilikan'),
        'language' => 'en',
        'options' => [
            'placeholder' => 'Select Kepemilikan...',
            'id' => 'selectKepemilikan',
            'multiple' => true,
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label('Kepemilikan')
    ?>
    <?=
    $form->field($model, 'jaringanusaha')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Jaringanusaha::find()->all(), 'kdjaringanusaha', 'nmjaringanusaha'),
        'language' => 'en',
        'options' => [
            'placeholder' => 'Select Jaringan Usaha...',
            'id' => 'selectJaringanusaha',
            'multiple' => true,
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label("Jaringan Usaha")
    ?>
        <?=
    Html::button('Select Layout', [ 'class' => 'btn btn-primary', 'id' => 'btn-next-to-step5',
        'onclick' => ' $("#variabelVertikal,#variabelHorizontal").empty();$.post("' . Url::to(['get-variables', 'kdkategori' => '']) . '"+ $("#selectKategori").val()
            + "&kdkbli=" + $("#selectKbli").val()
            + "&kdsu=" + $("#selectUnitstatistik").val()
            + "&kdkondisi=" + $("#selectStatusperusahaan").val()
            + "&kdinstitusi=" + $("#selectInstitusi").val()
            + "&kdkepemilikan=" + $("#selectKepemilikan").val()
            + "&kdjaringanusaha=" + $("#selectJaringanusaha").val()
            + "&attributes=" +$("#selectAttributes").val()
            + "&tahun="+ $("#selectYears").val()
            + "&kdprop="+ $("#selectProvinces").val()
            + "&kdkab=" + $("#selectKabupaten").val()
            + "&kdkec=" + $("#selectKecamatan").val()
            + "&kddesa=" + $("#selectDesa").val()
            ,function (data) {$("#optionalVariables").html(data);});'])
    ?>
    <h4 class="wizard-title">Step 5: Select Layout</h4>
    <div class="bg-info">*Atur tata letak tabel yang diinginkan. Saat ini, sistem hanya dapat memproses 1 variabel horizontal.</div>
    <br>
    <div class="select-variables">
        <div class="container-fluid">
            <div class=" col-xs-12 col-sm-4">
                <p>Available variables:</p>
                <ul id="optionalVariables" class="optionalVariables" style="padding:5px;min-height: 50px;background:#eaeae1;">
                </ul>
            </div>
            <!--drop object here-->
            <div class="col-xs-12 col-sm-8 drop">  
                <p>Drag and drop variables here:</p>

                <ul id="variabelVertikal" class="optionalVariables col-xs-6 col-sm-5" style="min-height:200px;padding:2px 0 2px 0;background:whitesmoke">
                    
                </ul>


                <ul id="variabelHorizontal" class="optionalVariables col-xs-6 col-sm-7" style="min-height:100px;padding: 2px 0 2px 0;background:whitesmoke;border-left:dotted lightgrey 2px;">
                    
                </ul>

            </div>
        </div>
        <?php
        echo $form->field($model, 'vvertikal')->textInput(['id' => 'vvertikal', 'class' => 'hidden'])->label(false);
        echo $form->field($model, 'vhorizontal')->textInput(['id' => 'vhorizontal', 'class' => 'hidden'])->label(false);
        echo Html::button('Summary', ['class ' => 'btn btn-primary', 'id' => 'summary']);
        ?>
        <h4>Summary:</h4>
        <p id="summaryText" class="well">

        </p>
      <?= Html::submitButton('Generate Table', ['class ' => 'btn btn-success disabled', 'id' => 'generateTable']) ?>
    </div>
    <?php ActiveForm::end() ?>

<?php
$css = <<< CSS
    .drop{
       background:#eaeae1; 
        padding:10px;
   }
        #optionalVariables li,#variabelVertikal li,#variabelHorizontal li {
        padding: 5px;
        margin: 2px;
        list-style-position: inside;
        list-style-type: none;
        background:#ffcc99;
    }
    .drop-placeholder {/*placeholder=pembantu dimana item akan ditempatkan*/
        background-color:transparent !important;
        border: 2px dashed darkorange;
            }
        .hidden{
            visibility:hidden;}
CSS;
$this->registerCss($css);
$this->registerJS('
    
    $("#optionalVariables, #variabelHorizontal,#variabelVertikal").sortable({
        items: "> li",
        connectWith: ".optionalVariables",
        containment: $(".select-variables"),
        cursor: "move",
        dropOnEmpty: true,
        placeholder: "drop-placeholder",
        forcePlaceholderSize: true,
        revert: true,
        tolerance: "pointer"
    }).disableSelection();
    $("#summary").click(function () {
        var arrayvvar = "";
        $("ul#variabelVertikal").children("li").each(function () {
            var v = $(this).attr("value");
            arrayvvar = arrayvvar + "," + v;
        });
        $("#vvertikal").val(arrayvvar);
        var arrayhvar = "";
        $("ul#variabelHorizontal").children("li").each(function () {
            var v = $(this).attr("value");
            arrayhvar = arrayhvar + "," + v;
        });
        $("#vhorizontal").val(arrayhvar);
        var a = $("#vvertikal").val();
        var b = $("#vhorizontal").val();
        var c = $("#selectSubject").val();
        var d = $("#selectAttributes").val();
        var e = $("#selectYears").val();
        var f = $("#selectProvinces").val();
        var g = $("#selectKabupaten").val();
        var h = $("#selectKecamatan").val();
        var i = $("#selectDesa").val();
        var j = $("#selectKategori").val();
        var k = $("#selectKbli").val();
        var l = $("#selectUnitstatistik").val();
        var m = $("#selectStatusperusahaan").val();
        var n = $("#selectInstitusi").val();
        var o = $("#selectKepemilikan").val();
        var p = $("#selectJaringanusaha").val();
        $("#summaryText").html("variabel vertikal:" + a + "<br>" +
                "variabel horisontal:" + b + "<br>" +
                "subject:" + c + "<br>" +
                "attr:" + d + "<br>" +
                "thn:" + e + "<br>" +
                "prop:" + f + "<br>" +
                "kab:" + g + "<br>" +
                "kec:" + h + "<br>" +
                "desa:" + i + "<br>" +
                "kategori:" + j + "<br>" +
                "kbli:" + k + "<br>" +
                "unit statistik:" + l + "<br>" +
                "status:" + m + "<br>" +
                "institusi:" + n + "<br>" +
                "kepemilikan:" + o + "<br>" +
                "jaringan usaha:" + p);
        $("#generateTable").removeClass("disabled");
    });
');
$this->registerCss('
        div.bg-info{
    padding:10px;
        }
');
?>