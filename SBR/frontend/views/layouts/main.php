<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="<?php echo Yii::$app->request->baseUrl; ?>/favicon.png"/>
        <link href='https://fonts.googleapis.com/css?family=Lato:400,700italic,700,400italic' rel='stylesheet' type='text/css'>

        <?= Html::csrfMetaTags() ?>
        <title>SBR-<?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>

    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            <?php
            NavBar::begin([
                'brandLabel' => '<img src="favicon.png" class="pull-left"/><span>SBR</span>',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-fixed-top navbar-inverse',
                ],
            ]);
            $menuItems = [
                ['label' => 'Home', 'url' => ['/site/index']],
                // ['label' => 'Contact', 'url' => ['/site/contact']],
                ['label' => 'Generate Table',
                    'items' => [
                        ['label' => 'Given Table', 'url' => ['/generate-table/generate-given-table']],
                        ['label' => 'Custom Table', 'url' => ['/generate-table/generate-custom-table']],
                    ],
                ],
                ['label' => 'Manage', 'visible' => Yii::$app->user->can('manageGivenTable') || Yii::$app->user->can('manageUsers'),
                    'items' => [
                        [
                            'label' => 'Dictionary',
                            'url' => ['/manage-dictionary'],
                            'visible' => Yii::$app->user->can('manageGivenTable')
                        ],
                        '<li class="divider"></li>',
                        ['label' => 'History of Table',
                            'url' => ['/manage-table-history'],
                            'visible' => Yii::$app->user->can('manageUsers')
                        ],
                        [
                            'label' => 'Users',
                            'url' => ['/manage-user'],
                            'visible' => Yii::$app->user->can('manageUsers')
                        ]
                    ],
                ],
            ];
            $menuItems[]=['label' => 'About', 'url' => ['/site/about']];
            if (Yii::$app->user->isGuest) {

                $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
            } else {
                $submenuUser[] = ['label' => 'Profile', 'url' => ['/site/profile']];
                $submenuUser[] = '<li class="divider"></li>';
                $submenuUser[] = '<li>'
                        . Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton(
                                'Logout', ['class' => 'btn btn-link btn-block plain']
                        )
                        . Html::endForm()
                        . '</li>';

                
                $menuItems[] = ['label' => Yii::$app->user->identity->username,
                    'items' => $submenuUser];

            }
            echo Nav::widget([

                'options' => ['class' => 'navbar-nav'],
                'items' => $menuItems,
            ]);
            NavBar::end();
            ?>

            <div class="container">
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <a href="https://www.facebook.com/pages/Badan-Pusat-Statistik/1394866840805957"><kbd>facebook</kbd></a>
                <a href="https://www.twitter.com/bps_statistics"><kbd>twitter</kbd></a>
                <p class="footer-info text-center">
                &copy;Statistical Business Register <?= date('Y') ?><br>
                Badan Pusat Statistik - Statistics Indonesia<br>
                Jl. Dr. Sutomo 6-8 Jakarta 10710 Indonesia<br> <i class="glyphicon glyphicon-phone-alt"></i>  (62-21) 3841195, 3842508, 3810291</p>
                                </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
