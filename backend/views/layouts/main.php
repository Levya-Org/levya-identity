<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

use common\helpers\RoleHelper;

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
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Levya Org. Indentity Admin',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'User Page', 'visible' => RoleHelper::userHasRole(Yii::$app->user->id, RoleHelper::ROLE_ADMINISTRATOR), 'items' => [
                        ['label' => 'Users', 'url' => ['/user/index']],
                        ['label' => 'UserStates', 'url' => ['/user-state/index']],
                    ]],
                    ['label' => 'Project Page', 'visible' => RoleHelper::userHasRole(Yii::$app->user->id, RoleHelper::ROLE_ADMINISTRATOR), 'items' => [
                        ['label' => 'Projects', 'url' => ['/project/index']],
                        ['label' => 'Positions', 'url' => ['/position/index']],
                    ]],
                    ['label' => 'Platform Page', 'visible' => RoleHelper::userHasRole(Yii::$app->user->id, RoleHelper::ROLE_ADMINISTRATOR), 'items' => [
                        ['label' => 'LDAP', 'url' => ['/ldap/index']],                    
                        ['label' => 'Group', 'url' => ['/group/index']],
                        ['label' => 'Service', 'url' => ['/service/index']],
                        ['label' => 'Params', 'url' => ['/param/index']],
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
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
