<?php
/* @var $this yii\web\View */

use kartik\select2\Select2;
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
            'onchange' => '$("select#selectAttributes").select2("val", "", true);'
            . '$("select#selectYears").select2("val", "", true);'
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
    ]);
    ?>
    <?= Html::button('Next: Step2: Select Attributes and Years', [ 'class' => 'btn btn-primary']) ?>
    <h4 class="wizard-title">Step 2: Select Attributes and Years</h4>
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
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])
    ?>
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
    ])
    ?>
    <?= Html::button('Next: Select Locations', [ 'class' => 'btn btn-primary',
        'onclick' => '$.post("' . Url::to(['get-mandatoryvariables', 'attributes' => ''])
        . '"+$("#selectAttributes").val()'
        . '+"&tahun="+ $("#selectYears").val(),function (data) {'
        .'$("#mandatoryVariables").html(data);'
        .'});'
    ])?>
    <div id="result"></div>
    <h4 class="wizard-title">Step 3: Select Locations</h4>
    <?php
// Parent Propinsi
    echo $form->field($model, 'kdprop')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Propinsi::find()->where(['not', ['kdprop' => '00']])
                ->andWhere(['not', ['kdprop' => '95']])->all(), 'kdprop', 'nmprop'),
        'language' => 'en',
        'options' => [
            'placeholder' => 'Select Province ...',
          //  'multiple' => true,
            'id' => 'selectProvinces',
            'onchange' => '$.post("' . Url::to(['get-kabupaten', 'kdprop' => '']) . '" + $(this).val(),
        function (data) {
          $("select#selectKabupaten").select2("val", "", true);
            $("#selectKabupaten").empty();
            $("select#selectKabupaten").html(data);
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
    ]);

    echo $form->field($model, 'kdkab')->widget(Select2::classname(), [
        'data' => [],
        'language' => 'en',
        'disabled' => true,
        'options' => [
            'placeholder' => 'Select Kabupaten/Kota...',
            //'multiple' => true,
            'id' => 'selectKabupaten',
            'onchange' => '$.post("' . Url::to(['get-kecamatan', 'kdkab' => '']) 
            . '" + $(this).val() + "&kdprop=" + $("#selectProvinces").val(),
        function (data) {
            $("select#selectKecamatan").select2("val", "", true);
            $("#selectKecamatan").empty();
            $("select#selectKecamatan").html(data);
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
    ]);
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
            $("select#selectDesa").select2("val", "", true);
            $("#selectDesa").empty();
            $("select#selectDesa").html(data);
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
    ]);
    echo $form->field($model, 'kddesa')->widget(Select2::classname(), [
        'data' => [],
        'language' => 'en',
        'disabled' => true,
        'options' => [
            'placeholder' => 'Select Desa...',
         //   'multiple' => true,
            'id' => 'selectDesa',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]);
    ?>
    
    <?php
    echo Html::button('Next: Select Variables', [ 'class' => 'btn btn-primary',
        'onclick' => '$.post("' . Url::to(['get-variablelist', 'kdprop' => '']) . '"+ $("#selectProvinces").val(),function (data) {
                $("#optionalVariables").html(data);});'
        . '$.post("' . Url::to(['get-locationvariables', 'kdprop' => '']) . '"+ $("#selectProvinces").val()+ "&kdkab=" + $("#selectKabupaten").val() + "&kdkec=" + $("#selectKecamatan").val()+ "&kddesa=" + $("#selectDesa").val(),function (data) {
               '.'$("#locationVariables").html(data);'
        //.        ' $("#vvertikal").html(data);'
        //.'       $("#vhorizontal").html(data);'
        . '});
                ']);
    ?>
    <h4 class="wizard-title">Step 4: Select Variables</h4>

    <?= $form->field($model, 'vvertikal')->textInput(['id' => 'vvertikal']) ?>
    <?= $form->field($model, 'vhorizontal')->textInput(['id' => 'vhorizontal']) ?>
    <?php
//    echo $form->field($model, 'vvertikal')->widget(Select2::classname(), [
//        'data' => [],
//        'maintainOrder' => true,
//        'options' => [
//            'multiple' => true,
//            'id' => 'vvertikal',
//        ],
//    ]);
//   
//    echo $form->field($model, 'vhorizontal')->widget(Select2::classname(), [
//        'data' => [],
//        'maintainOrder' => true,
//        'options' => [
//            'multiple' => true,
//            'id' => 'vhorizontal',
//        ],
//    ]);
    ?>
    <div class="select-variables">

        <div class="container-fluid">
            <div class=" col-xs-12 col-sm-4">
                <p>select element here</p>
                <ul id="mandatoryVariables" class="mandatoryVariables" style="padding:5px;min-height: 50px;background:#eaeae1;">
                </ul>
                <ul id="locationVariables" class="locationVariables" style="padding:5px;min-height: 50px;background:#eaeae1;">
                </ul>
                <ul id="optionalVariables" class="optionalVariables" style="padding:5px;min-height: 50px;background:#eaeae1;">
                </ul>
            </div>
            <!--drop object here-->
            <div class="col-xs-12 col-sm-8 drop">  
                <p>drop variable here</p>

                <ul id="variabelVertikal" class="optionalVariables mandatoryVariables locationVariables col-xs-6 col-sm-5" style="min-height:200px;padding:2px 0 2px 0;background:whitesmoke">

                </ul>


                <ul id="variabelHorizontal" class="optionalVariables mandatoryVariables locationVariables col-xs-6 col-sm-7" style="min-height:100px;padding: 2px 0 2px 0;background:whitesmoke;border-left:dotted lightgrey 2px;">

                </ul>

            </div>
        </div>
        <?= Html::button('Simpan Struktur', ['class ' => 'btn btn-primary', 'id' => 'simpanStruktur']) ?>
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
        #optionalVariables li, #locationVariables li,#mandatoryVariables li,#variabelVertikal li,#variabelHorizontal li {
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
        $("#mandatoryVariables, #variabelHorizontal,#variabelVertikal").sortable({
        items: "> li",
        connectWith: ".mandatoryVariables",
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
     $("#locationVariables, #variabelHorizontal,#variabelVertikal").sortable({
        items: "> li",
        connectWith: ".locationVariables",
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
    $("#optionalVariables, #variabelHorizontal,#variabelVertikal").sortable({
        items: "> li",
        connectWith: ".optionalVariables",
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
    $("#simpanStruktur").click(function(){
    var arrayvvar="";
    $("ul#variabelVertikal" ).children("li").each(function() {
    var v=$(this).attr("value");
    arrayvvar=arrayvvar+",,"+v;
    })
    ;$("#vvertikal").val(arrayvvar);
    var arrayhvar="";
    $("ul#variabelHorizontal" ).children("li").each(function() {
    var v=$(this).attr("value");
    arrayhvar=arrayhvar+",,"+v;
    })
    ;$("#vhorizontal").val(arrayhvar);
    });
');
?>