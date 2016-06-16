<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Table';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-table">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <table class="striped hoverable responsive-table">
                            <thead>
                                <tr>
                                    <th data-field="id">Name</th>
                                    <th data-field="name">Item Name</th>
                                    <th data-field="price">Item Price</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>Alvin</td>
                                    <td>Eclair</td>
                                    <td>$0.87</td>
                                </tr>
                                <tr>
                                    <td>Alan</td>
                                    <td>Jellybean</td>
                                    <td>$3.76</td>
                                </tr>
                                <tr>
                                    <td>Jonathan</td>
                                    <td>Lollipop</td>
                                    <td>$7.00</td>
                                </tr>
                            </tbody>
                        </table>
</div>
