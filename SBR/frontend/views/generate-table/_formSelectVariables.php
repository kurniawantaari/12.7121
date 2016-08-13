<?php

use yii\helpers\Html;

//step 4 pilih variabel dan tempatkan. max=3. kalo bisa kasih filter.
//jika atribut, tahun, dan lokasi telah dipilih, maka hide pilihan lain.
//variabel:kategori industri dll
//survival: pilihan variabel hanya boleh satu yang dipilih. tahun dan stribut pasti masuk variabel
?>
<h4 class="wizard-title">Step 4: Select Variables</h4>
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
    <?= Html::submitButton('Generate Table',['class '=>'btn btn-primary']) ?>
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
    ?>