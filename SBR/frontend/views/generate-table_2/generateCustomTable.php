<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use kartik\tabs\TabsX;
//use drsdre\wizardwidget\WizardWidget;
use yii\widgets\ActiveForm;

$this->title = 'Tes Table Generator';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="generate-table">
    <h1><?= Html::encode($this->title) ?></h1>


    <?php
    $form = ActiveForm::begin([
                'id' => 'table-generator-form',
                'options' => ['class' => 'form-horizontal'],
             //   'enableAjaxValidation' => true,
               // 'enableClientValidation' => true,
                'action' => ['view'],
                'method' => 'post',
    ]);
//
//    $wizard_config = [
//        'id' => 'stepGenerateTable',
//        'steps' => [
//            1 => [
//                'title' => 'Step 1: Select Subject',
//                'icon' => 'glyphicon glyphicon-plus',
//                'content' => $this->render('_formSelectSubject', ['model' => $model, 'form' => $form]),
//                'buttons' => [
//                    'next' => [
//                        'title' => 'Next: Select Attributes and Years',
//                        'options' => [
//                            'class' => 'btn btn-primary control',
//                        //'id'=>'control'
//                        ],
//                    ],
//                ],
//            ],
//            2 => [
//                'title' => 'Step 2: Select Attributes and Years',
//                'icon' => 'glyphicon glyphicon-time',
//                'content' => $this->render('_formSelectAttributesandYears', [
//                    'model' => $model,
//                    'form' => $form,
//                ]),
//                'buttons' => [
//                    'prev' => [
//                        'title' => 'Back'],
//                    'next' => [
//                        'title' => 'Next: Select Locations',
//                        'options' => [
//                            'class' => 'btn btn-primary control'
//                        ],
//                    ],
//                ],
//            //'skippable' => true,
//            ],
//            3 => [
//                'title' => 'Step 3: Select Locations',
//                'content' => $this->render('_formSelectLocations', [
//                    'model' => $model,
//                    'form' => $form,
//                    'propinsi' => $propinsi,
//                ]),
//                'icon' => 'glyphicon glyphicon-map-marker',
//                'buttons' => [
//                    'prev' => [
//                        'title' => 'Back'],
//                    'next' => [
//                        'title' => 'Next: Select Variables',
//                        'options' => [
//                            'class' => 'btn btn-primary control'
//                        ],
//                    ],
//                ],
//            ],
//            4 => [
//                'title' => 'Step 4: Select Variables',
//                'content' => $this->render('_formSelectVariables', ['model' => $model, 'form' => $form]),
//                'icon' => 'glyphicon glyphicon-list-alt',
//                'buttons' => [
//                    'prev' => [
//                        'title' => 'Back',
//                    ],
//                    'save' => [
//                        'title' => 'Generate',
//                        'options' => [
//                            'class' => 'btn btn-primary control'
//                        ],
//                    ],
//                ],
//            ],
//        ],
//        'complete_content' => $this->render('_formTable', ['model' => $model,
//            'form' => $form]), // Optional final screen
//        'start_step' => 1, // Optional, start with a specific step
//    ];
//
//
//    echo WizardWidget::widget($wizard_config);

    echo TabsX::widget([
        'items' => [
            [
                'label' => 'Step 1: Select Subject',
                'content' => $this->render('_formSelectSubject', ['model' => $model, 'form' => $form]),
                'active' => true
            ],
            [
                'label' => 'Step 2: Select Attributes and Years',
                'content' => $this->render('_formSelectAttributesandYears', [
                    'model' => $model,
                    'form' => $form,
                ])
            ],
            [
                'label' => 'Step 3: Select Locations',
                'content' => $this->render('_formSelectLocations', [
                    'model' => $model,
                    'form' => $form,
                    'propinsi' => $propinsi,
                ])
            ],
            [
                'label' => 'Step 4: Select Variables',
                'content' => $this->render('_formSelectVariables', ['model' => $model, 'form' => $form])
            ],
        ],
        'position' => TabsX::POS_ABOVE,
        'encodeLabels' => false,
        'bordered' => true,
        'options' => ['class' => 'nav-pills']
    ]);
    ActiveForm::end()
    ?>
</div>
<?php
$this->registerCss('
    .wizard-title{
    }
    span.round-tab i{
    color: #e0e0e0; !important
        }
        span.round-tab:hover{
cursor:default;!important}

');
//$this->registerJs('
//        $(".wizard li").click(function(){
//        $(".wizard li.active").siblings().removeClass("disabled").addClass("disabled");
//               $(".wizard li.active").prev().removeClass("disabled");
//        $(".wizard li.active").next().removeClass("disabled");
//            });
//        
//');

$this->registerJs('
            $("form#{$model->formName()}").on("beforeSubmit", function(e){
    var \$form = $(this);
            $.post(
                    \$form.attr("action"),
                    \$from.serialize()
                    )
            .done(function(result){
            if (result.message == "Success"){
            $(document).find("#secondmodal").modal("hide");
                    $.pjax.reload({container:"#commodity-grid"});
            } else
            {
            $(\$form).trigger("reset");
                    $("#message").html(result.message);
            }
            }).fail(function(){
    console.log("server error");
    });
            return false;
    });
');
?>