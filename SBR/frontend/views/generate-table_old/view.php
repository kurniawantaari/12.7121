<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Result Table';
$this->params['breadcrumbs'][] = $this->title;
//kasih button buat kembali ke generate table
?>
<h1><?= Html::encode($this->title) ?></h1>
<div id="result">
  
</div>
<?php
$this->registerJs('
   
');
?>