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

$this->title = 'Buat Tabel Custom';
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
    <div class="col-lg-6">

        <h4 class="wizard-title" data-toggle="tooltip" data-placement="bottom" title="Subjek adalah kelompok statistik unit usaha.">Langkah 1: Pilih Subjek</h4>
        <div class="well"> 
            <?php
            echo $form->field($model, 'subject')->widget(Select2::classname(), [
                'data' => ['ju' => 'Jumlah Unit Usaha', 'su' => 'Survival Unit Usaha', 'se' => 'Survival Unit yang Masuk'],
                'language' => 'en',
                'options' => [
                    'placeholder' => 'Pilih Subjek ...',
                    'id' => 'selectSubject',
                    'class' => 'col-lg-6',
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
            ])->label("Subjek *");
            ?>
        </div>

        <h4 class="wizard-title" data-toggle="tooltip" data-placement="bottom" title="Atribut adalah statistik unit usaha. Tahun yaitu tahun publikasi.">Langkah 2: Pilih Atribut dan Tahun</h4>
        <div class="well"><?=
            $form->field($model, 'attributes')->widget(Select2::classname(), [
                'data' => [],
                'language' => 'en',
                'options' => [
                    'placeholder' => 'PIlih Atribut...',
                    'id' => 'selectAttributes',
                    'class' => 'col-lg-6',
                    'disabled' => true,
                    'multiple' => true,
                ],
                'theme' => Select2::THEME_KRAJEE,
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label("Atribut *")
            ?>
            <?=
            $form->field($model, 'years')->widget(Select2::classname(), [
                'data' => [],
                'language' => 'en',
                'disabled' => true,
                'options' => [
                    'placeholder' => 'Pilih Tahun...',
                    'id' => 'selectYears',
                    'multiple' => true,
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label("Tahun *")
            ?>    
        </div>
    </div>
    <div class="col-lg-6">


        <h4 class="wizard-title" data-toggle="tooltip" data-placement="bottom" title="Lokasi adalah wilayah teritorial unit usaha. Jika tidak diisi, secara default akan dipilih nasional.">Langkah 3: Pilih Lokasi</h4>
        <div class="well">
            <?php
            echo $form->field($model, 'kdprop')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Propinsi::find()->where(['not', ['kdprop' => '00']])
                                ->andWhere(['not', ['kdprop' => '95']])->all(), 'kdprop', 'nmprop'),
                'language' => 'en',
                'options' => [
                    'placeholder' => 'Pilih Provinsi ...',
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
                    'placeholder' => 'Pilih Kabupaten/Kota...',
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
                    'placeholder' => 'Pilih Kecamatan...',
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
                    'placeholder' => 'Pilih Desa...',
                    // 'multiple' => true,
                    'id' => 'selectDesa',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label("Desa");
            ?>
        </div>
    </div>
    
        <h4 class="wizard-title col-lg-12" data-toggle="tooltip" data-placement="bottom" title="Variabel harus dipilih lebih dari dua jika ingin dirinci dalam tabel.">Langkah 4: Pilih Variabel</h4>
        <h5 class="bg-info col-lg-12">Pilih dan filter variabel yang diinginkan.</h5> 
        
 <div class="col-lg-6"> 
        <div class="well">
     
            <?=
            $form->field($model, 'kdkategori')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Kategori::find()->where(['tahun' => '2015'])->all(), 'kdkategori', 'nmkategori'),
                'language' => 'en',
                'options' => [
                    'placeholder' => 'Pilih Kategori...',
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
            echo Html::button('Filter Kbli', ['class' => 'btn btn-primary',
                'onclick' => 'if($("#selectKategori").val()!=null&&$("#selectKategori").val()!=""){$.post("' . Url::to(['get-kbli', 'kdkategori' => '']) . '" + $("#selectKategori").val(), function (data) {
    $("#selectKbli").html(data);$("#selectKbli").attr("disabled",false);
});}else{window.alert("tidak ada kategori yang dipilih");}']);
            ?>
            <?=
            $form->field($model, 'kdkbli')->widget(Select2::classname(), [
                'data' => [],
                'language' => 'en',
                'options' => [
                    'placeholder' => 'Pilih KBLI...',
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
                    'placeholder' => 'Pilih Unit Statistik...',
                    'id' => 'selectUnitstatistik',
                    'multiple' => true,
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label("Unit Statistik")
            ?>
      </div>
 </div>
             <div class="col-lg-6"> 
        <div class="well">
            <?=
            $form->field($model, 'statusperusahaan')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Statusperusahaan::find()->all(), 'kdkondisi', 'nmkondisi'),
                'language' => 'en',
                'options' => [
                    'placeholder' => 'Pilih Status Perusahaan...',
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
                    'placeholder' => 'Pilih Sektor Institusi...',
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
                'placeholder' => 'Pilih Kepemilikan...',
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
                'placeholder' => 'Pilih Jaringan Usaha...',
                'id' => 'selectJaringanusaha',
                'multiple' => true,
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ])->label("Jaringan Usaha")
        ?>
            

 </div>
    </div>
            <?=
    Html::button('Pilih Tata Letak', ['class' => 'btn btn-primary', 'id' => 'btn-next-to-step5',
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
    <h4 class="wizard-title" data-toggle="tooltip" data-placement="bottom" title="Drag and drop variabel yang ingin dirinci dalam tabel.">Pilih 5: Pilih Tata Letak</h4>
    <div class="bg-info">Atur tata letak tabel yang diinginkan. Saat ini, sistem hanya dapat memproses 1 variabel horizontal.</div>
    <br>
    <div class="select-variables">
        <div class="container-fluid">
            <div class=" col-xs-12 col-sm-4">
                <p>Variabel yang Tersedia:</p>
                <ul id="optionalVariables" class="optionalVariables" style="padding:5px;min-height: 50px;background:#eaeae1;">
                </ul>
            </div>
            <!--drop object here-->
            <div class="col-xs-12 col-sm-8 drop">  
                <p>Drag and drop variabel ke sini:</p>

                <ul id="variabelVertikal" class="optionalVariables col-xs-6 col-sm-5" style="min-height:200px;padding:2px 0 2px 0;background:whitesmoke">

                </ul>


                <ul id="variabelHorizontal" class="optionalVariables col-xs-6 col-sm-7" style="min-height:100px;padding: 2px 0 2px 0;background:whitesmoke;border-left:dotted lightgrey 2px;">

                </ul>

            </div>
        </div>
    </div>
    <?php
    echo $form->field($model, 'vvertikal')->textInput(['id' => 'vvertikal', 'class' => 'hidden'])->label(false);
    echo $form->field($model, 'vhorizontal')->textInput(['id' => 'vhorizontal', 'class' => 'hidden'])->label(false);
    echo Html::button('Ringkasan', ['class ' => 'btn btn-primary', 'id' => 'summary']);
    ?>
    <h4>Ringkasan:</h4>
    <p id="summaryText" class="well">

    </p>
    <?= Html::submitButton('Buat Tabel', ['class ' => 'btn btn-success disabled', 'id' => 'generateTable']) ?>
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
            arrayvvar = arrayvvar +  v + ",";
        });
        $("#vvertikal").val(arrayvvar);
        var arrayhvar = "";
        $("ul#variabelHorizontal").children("li").each(function () {
            var v = $(this).attr("value");
            arrayhvar = arrayhvar + v +  "," ;
        });
        $("#vhorizontal").val(arrayhvar);
        var a = $("#vvertikal").val();
         if (a == null || a == "" || a == "null"){a = " -";}
        var b = $("#vhorizontal").val();
         if (b == null || b == "" || b == "null"){b = " -";}
        var c = $("#selectSubject").val();
         if (c == null || c == "" || c == "null"){c = " -";}
         var d = $("#selectAttributes").val();
          if (d == null || d == "" || d == "null"){d = " -";}
        var e = $("#selectYears").val();
         if (e == null || e == "" || e == "null"){e = " -";}
        var f = $("#selectProvinces").val();
          if (f == null || f == "" || f == "null"){f = " -";}
        var g = $("#selectKabupaten").val();
         if (g == null || g == "" || g == "null"){g = " -";}
        var h = $("#selectKecamatan").val();
         if (h == null || h == "" || h == "null"){h = " -";}
        var i = $("#selectDesa").val();
         if (i == null || i == "" || i == "null"){i = " -";}
        var j = $("#selectKategori").val();
         if (j == null || j == "" || j == "null"){j = " -";}
        var k = $("#selectKbli").val();
         if (k == null || k == "" || k == "null"){k = " -";}
        var l = $("#selectUnitstatistik").val();
         if (l == null || l == "" || l == "null"){l = " -";}
        var m = $("#selectStatusperusahaan").val();
         if (m == null || m == "" || m == "null"){m = " -";}
        var n = $("#selectInstitusi").val();
         if (n == null || n == "" || n == "null"){n = " -";}
        var o = $("#selectKepemilikan").val();
         if (o == null || o == "" || o == "null"){o = " -";}
        var p = $("#selectJaringanusaha").val();
        if (p == null || p == "" || p == "null"){p = " -";}
        $("#summaryText").html("Variabel vertikal:" + a + "<br>" +
                "Variabel horizontal:" + b + "<br>" +
                "Subjek:" + c + "<br>" +
                "Atribut:" + d + "<br>" +
                "Tahun:" + e + "<br>" +
                "Kode provinsi:" + f + "<br>" +
                "Kode kabupaten/kota:" + g + "<br>" +
                "Kode kecamatan:" + h + "<br>" +
                "Kode desa:" + i + "<br>" +
                "Kategori:" + j + "<br>" +
                "KBLI:" + k + "<br>" +
                "Unit statistik:" + l + "<br>" +
                "Status:" + m + "<br>" +
                "Unit institusi:" + n + "<br>" +
                "Kepemilikan:" + o + "<br>" +
                "Jaringan usaha:" + p);
    if(a!=" -" && b!=" -"){$("#generateTable").removeClass("disabled");}    
    else {  $("#summaryText").html("Variabel vertikal dan horizontal harus dipilih.");}
    });
');
$this->registerCss('
        div.bg-info{
    padding:10px;
        }
');
?>