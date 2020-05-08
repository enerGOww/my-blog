<?php

/* @var $this View */
/* @var $content string */

use app\assets\PublicAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

PublicAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<nav class="navbar main-menu navbar-default">
    <div class="container">
        <div class="menu-content">
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav text-uppercase">
                    <li>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="<?= Url::toRoute(['site/index']) ?>">Home</a>
                    </li>
                </ul>
                <div class="i_con">
                    <ul class="nav navbar-nav text-uppercase">
                        <?php if (Yii::$app->user->isGuest): ?>
                            <li><a href="<?= Url::toRoute(['auth/login']) ?>">Login</a></li>
                            <li><a href="<?= Url::toRoute(['auth/signup']) ?>">Register</a></li>
                        <?php else: ?>
                            <li>
                                <a href="<?= Url::toRoute(['auth/logout']) ?>">
                                    <?= 'Logout' . '(' . Yii::$app->user->identity->name . ')' ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<?= $content ?>

<footer class="footer-widget-section">
    <div class="footer-copy">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center">&copy; 2020
                        <a href="<?= Url::toRoute(['site/index']) ?>">My-blog, </a> Create with
                        <i class="fa fa-heart"></i> by <a href="https://github.com/enerGOww" target="_blank">enerGOww</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
