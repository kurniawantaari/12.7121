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
                    'class' => 'navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                ['label' => 'HOME', 'url' => ['/site/index']],
                ['label' => 'ABOUT', 'url' => ['/site/about']],
                ['label' => 'CONTACT', 'url' => ['/site/contact']],
                ['label' => 'GENERATE TABLE', 'url' => ['/site/generate-table']],
                ['label' => 'PROFILE', 'url' => ['/site/account-detail']],
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'SIGNUP', 'url' => ['/site/signup']];
                $menuItems[] = ['label' => 'LOGIN', 'url' => ['/site/login']];
            } else {
                $menuItems[] = '<li>'
                        . Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton(
                                'LOGOUT (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link']
                        )
                        . Html::endForm()
                        . '</li>';
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
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
                <p>&copy; Indonesian Statistical Business Register <?= date('Y') ?></p>
                <p> Badan Pusat Statistik</p>
                <p>(BPS - Statistics Indonesia)</p>
                <p>Jl. Dr. Sutomo 6-8 Jakarta 10710 Indonesia, Telp (62-21) 3841195, 3842508, 3810291, Faks (62-21) 3857046</p>
                <p>facebook https://www.facebook.com/pages/Badan-Pusat-Statistik/1394866840805957</p>
                <p>twitter  https://www.twitter.com/bps_statistics</p>
                 <!--<p class="pull-right"><?= Yii::powered() ?></p>-->
            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
