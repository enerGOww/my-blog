<?php

namespace app\module\admin;

use yii\base\Module;

/**
 * admin module definition class
 */
class AdminModule extends Module
{
    /** {@inheritdoc} */
    public $controllerNamespace = 'app\module\admin\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }
}
