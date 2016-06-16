<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Dinamic Table';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-dinamicTable">
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- select elemnt from here-->
    <!--variable view. on small on top of page, on medium iconize?. tampilannya seperti icon di visual paradigm.
             jadi, kalau diklik, muncul di buttonnya yang terpilih. setelah itu bar di drag and drop.-->
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
       

    </div> <div class="row">
                <button type="button" class="btn btn-default col-xs-offset-5" style="margin-top: 5px;">Generate Table</button>
            </div>


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
?>