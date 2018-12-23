<?php

/**
 * Контроллер IndexController
 */
class  IndexController
{

    /**
     * Action для главной страницы
     */
    public function actionIndex()
    {
        require_once(ROOT . 'views/'. TEMPLATE_NAME .'/index.php');
        return true;
    }

}