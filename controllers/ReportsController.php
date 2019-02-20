<?php

require_once ROOT . 'models/Reports.php';

class ReportsController
{
    /**
     * Action для страницы "Отчеты посетители какой страны совершают больше всего действий на сайте?"
     */
    public function actionCountries()
    {
        $res = Reports::countries();
        include_once ROOT . '/views/'.TEMPLATE_NAME.'/countries.php';
//        echo 'hello';
        return true;
    }
    
    /**
     * Action для страницы "Отчет Какая нагрузка на сайт на астрономический час?"
     */
    public function actionHour()
    {
        if(key_exists('datetime',$_REQUEST)) {
            $response = Reports::hour();
            $date =  str_replace('T',' ',$_REQUEST['datetime']);
        }
        include_once ROOT . '/views/'.TEMPLATE_NAME.'/hour.php';
        return true;
    }


    /**
     * Action для страницы "Отчет Посетители из какой страны чаще всего интересуются товарами из определенных категорий?"
     */
    public function actionUsers()
    {
        if (key_exists('categories',$_REQUEST)) {
            $res = Reports::users();
        }
        include_once ROOT . '/views/'.TEMPLATE_NAME.'/users.php';
        return true;
    }

}
