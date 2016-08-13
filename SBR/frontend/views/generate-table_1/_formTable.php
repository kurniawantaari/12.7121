<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

 //step 5 tabel (tampilkan tabel)
    //tempat:default: di indonesia
    //jika propinsi dipilih, tempat=di indonesia
    //jika kabupaten dipilih, tempat=di [propinsi]
    //jika kecamatan dipilh, tempat=di kabupaten/kota [kabupaten], [propinsi]
    //jika desa dipilih, tempat=di kecamatan [kecamatan], [kecamatan], [kabupaten], [propinsi]
    //penamaan tabel= [subject] +menurut [[variabel]] + tahun [[tahun]] +[[tempat]]
   
?>
<h4 class="wizard-title">Table</h4>

        <?php
        //nama tabel di uppercase
//    $gridColumns = [
//        'username',
//        'email',
//       
//    ];
//
//// Renders a export dropdown menu
//    echo ExportMenu::widget([
//      //  'dataProvider' => $dataProvider,
//        'columns' => $gridColumns
//    ]);
//    echo GridView::widget([
//       // 'dataProvider' => $dataProvider,
//        'columns' => $gridColumns,
//        'hover' => true,
//    ]);
    ?>