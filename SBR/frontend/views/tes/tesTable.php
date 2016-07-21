<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = 'Tes Table';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="generate-table">
    <h1><?= Html::encode($this->title) ?></h1>
<?php
//tabel generator
    //step 1 pilih subject
        //jumlah unit usaha
        //srvival unit usaha
        //survival unit yang masuk

    //step 2 pilih atribut dan tahun
    
    //jika atribut >1 yang dipilh, jadikan variabel dan harus dipilih waktu drag and drop
    //jumlah unit
        //jika tahun dipilih, jadikan variabel dan harus dipilih waktu drag and drop
    //survival
        //tahun hanya boleh satu
       
    //atribut: entry, exit, jml,...  default:jumlah
    //tahun  default:tahun terakhir

    //step 3 pilih wilayah
    //default: indonesia
    //jika ada yang dipilih, maka wilayah harus dimasukkan sebagai variabel. variabel=hierarkhir terkecil yang dipilih
    //hierarkhi: indonesia, propinsi sesuatu, kabupaten sesuatu, kecamatan sesuatu, desa sesuatu.
    

    //step 4 pilih variabel dan tempatkan. max=3. kalo bisa kasih filter.
    //jika atribut, tahun, dan lokasi telah dipilih, maka hide pilihan lain.
    //variabel:kategori industri dll
        //survival: pilihan variabel hanya boleh satu yang dipilih. tahun dan stribut pasti masuk variabel
    
    //step 5 tabel (tampilkan tabel)
        //tempat:default: di indonesia
        //jika propinsi dipilih, tempat=di indonesia
        //jika kabupaten dipilih, tempat=di [propinsi]
        //jika kecamatan dipilh, tempat=di kabupaten/kota [kabupaten], [propinsi]
        //jika desa dipilih, tempat=di kecamatan [kecamatan], [kecamatan], [kabupaten], [propinsi]
    //penamaan tabel= [subject] +menurut [[variabel]] + tahun [[tahun]] +[[tempat]]

    //step 6 grafik dan peta

//survival

?>
    <?php
    $gridColumns = [
        'harga',
        'buah',
        'jumlah',
    ];

// Renders a export dropdown menu
    echo ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns
    ]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'hover' => true,
           ]);
    ?>
</div>
