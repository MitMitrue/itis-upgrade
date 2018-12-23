<?php
// константы 
include 'defines.php';
//// шаблонизатор смарти
//require ROOT . 'library/smarty/libs/Smarty.class.php';
//$smarty = new Smarty();
//$smarty->setTemplateDir(TemplatePrefix);
//$smarty->setCompileDir(ROOT . 'tmp/smarty/template_c');
//$smarty->setCacheDir(ROOT . 'tmp/smarty/cache');
//$smarty->setConfigDir(ROOT . 'library/smarty/configs');
//$smarty->assign('templatePath', TemplatePath);
//** un-comment the following line to show the debug console
// $smarty->debugging = true;

// подключение к базе данных
require_once ROOT . 'library/db.php';

// загрузка страниц
require_once ROOT . 'library/router.php';

// общие фунции сайта
function userID($ip) {
    global $conn,$m;

//    if ($m->get($ip)) {
//        return $m->get($ip);
//    }
//    else {
    $user = $conn->prepare('SELECT id FROM users WHERE ip = :ip');
    $user->bindParam(':ip', $ip, PDO::PARAM_STR);
    $user->execute();
    $user_id = $user->fetch(PDO::FETCH_ASSOC);
    if ($user_id['id']) {
//            $m->set($ip, $user_id['id']);
        return $user_id['id'];
    }

    else {
        $data_ip = @json_decode(file_get_contents("http://api.sypexgeo.net/json/{$ip}"));

        $users['ip'] = $ip;
        $users['country'] = @$data_ip->country->name_ru;
        $conn->exec(insertSQL('users',$users));
        $id = $conn->lastInsertId();
//            $m->set($ip, $id);
        return $id;
    }
//    }

}

function insertSQL($tablename,$mass) {

    $sql = "INSERT INTO $tablename (";
    foreach($mass as $key => $item) {
        if(key($mass) != $key)
            $sql .= "," . $key ;
        else
            $sql .= $key;
    }

    $sql .= ") VALUES (";

    foreach($mass as $key => $item) {
        if(key($mass) != $key)
            $sql .= ",'".str_replace("'","",$item)."'" ;
        else
            $sql .= "'".str_replace("'","",$item)."'";
    }

    $sql .="  );";
    return $sql ;

}

function CreateTable () {
    global $conn,$params;
        $sql ='   
                CREATE TABLE IF NOT EXISTS '.$params['dbname'].'.`info` ( 
                `id` INT(11) NOT NULL AUTO_INCREMENT , 
                `datetime` DATETIME NOT NULL , 
                `code` VARCHAR(64) NOT NULL , 
                `user` INT(11) NOT NULL , 
                `action` VARCHAR(100) NOT NULL , 
                PRIMARY KEY (`id`)) 
                ENGINE = InnoDB;';
        $conn->query($sql);
        $sql2 = '
                CREATE TABLE IF NOT EXISTS '.$params['dbname'].'.`users` ( 
                `id` INT NOT NULL AUTO_INCREMENT , 
                `ip` VARCHAR(64) NOT NULL , 
                `country` VARCHAR(64) NOT NULL , 
                PRIMARY KEY (`id`)) 
                ENGINE = InnoDB;
                ';
        $conn->query($sql2);
}