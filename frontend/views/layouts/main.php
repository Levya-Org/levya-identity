<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\helpers\RoleHelper;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode(Yii::$app->name) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Levya Org. Indentity',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'Profile', 'visible' => !Yii::$app->user->isGuest, 'items' => [
                        ['label' => 'Action History', 'url' => ['/profile/action-history']],
                        ['label' => 'View Infos.', 'url' => ['/profile/view']],
                        //TODO Wait StripeJS integration
//                        ['label' => 'Become a Member ?', 'url' => ['registration/register-member'], 'visible' => !RoleHelper::userHasRole(Yii::$app->user->id, RoleHelper::ROLE_MEMBER)],
                    ]],  
                    ['label' => 'Services', 'items' => [
                        ['label' => 'Wiki', 'url' => 'https://wiki.levya.org/', 'linkOptions' => ['target'=>'_blank']],
                        ['label' => 'Redmine', 'url' => 'https://redmine.levya.org/', 'linkOptions' => ['target'=>'_blank']],
                        ['label' => 'Cloud', 'url' => 'https://cloud.levya.org/', 'linkOptions' => ['target'=>'_blank']],
                        ['label' => 'Gitlab', 'url' => 'https://gitlab.levya.org/', 'linkOptions' => ['target'=>'_blank']],
                        ['label' => 'Status', 'url' => 'https://status.levya.org/', 'linkOptions' => ['target'=>'_blank']],
                        ['label' => 'Forum', 'url' => 'https://forum.levya.org/', 'linkOptions' => ['target'=>'_blank']],
                        ['label' => 'ISPConfig', 'url' => 'https://ispconfig.levya.org/', 'linkOptions' => ['target'=>'_blank']],
                        ['label' => 'Kanboard', 'url' => 'https://kanboard.levya.org/', 'linkOptions' => ['target'=>'_blank']],
                        ['label' => 'Tools', 'url' => 'https://tools.levya.org/', 'linkOptions' => ['target'=>'_blank']]
                    ]],
                    ['label' => 'About', 'url' => ['/site/about']],
                    Yii::$app->user->isGuest ?
                        ['label' => 'Login', 'url' => ['/site/login']] :
                        ['label' => 'Logout (' . Yii::$app->user->identity->USER_NICKNAME . ')',
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
            NavBar::end();
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; Levya Org. <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
