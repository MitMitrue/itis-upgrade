<?php

/**
 * Класс User - модель для работы с пользователями
 */
class Reports
{

    /**
     * Регистрация пользователя
     * @param string $name <p>Имя</p>
     * @param string $email <p>E-mail</p>
     * @param string $password <p>Пароль</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function countries()
    {
        // Соединение с БД
        $conn = db::getConnection();

        $query='
        SELECT users.country,count(info.action) as actions 
        FROM `info` 
        JOIN  `users` ON `users`.id = `info`.user
        group by `users`.country
        ORDER BY actions DESC
        ';
        $logs = $conn->query($query);
        $res = $logs->fetchall(PDO::FETCH_ASSOC);
        return $res;
    }

    /**
     * Редактирование данных пользователя
     * @param integer $id <p>id пользователя</p>
     * @param string $name <p>Имя</p>
     * @param string $password <p>Пароль</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function hour()
    {
        // Соединение с БД
        $db = Db::getConnection();

        $date =  str_replace('T',' ',$_REQUEST['datetime']);

        $query = "SELECT count(action) as actions FROM `info` WHERE `datetime` BETWEEN DATE_ADD( :date, INTERVAL -1 HOUR) AND :date";
        $actions = $db->prepare($query);
        $actions->bindParam(':date', $date, PDO::PARAM_STR);
        $actions->execute();
        $res = $actions->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    /**
     * Проверяем существует ли пользователь с заданными $email и $password
     * @param string $email <p>E-mail</p>
     * @param string $password <p>Пароль</p>
     * @return mixed : integer user id or false
     */
    public static function users()
    {
        // Соединение с БД
        $conn = Db::getConnection();

        // Текст запроса к БД

        $cats = explode(", ",$_REQUEST['categories']);
        $query_instr = '';
        foreach ($cats as $key => $category) {
            if ($key > 0)
                $query_instr .= 'OR INSTR(`action`, "'.$category.'") != 0 ';
        }
        $query='
                SELECT `users`.`country`,count(DISTINCT(ip)) as users
                 FROM `info` 
                 JOIN  `users` ON `users`.id = `info`.user
                 WHERE INSTR(`action`, "'.$cats[0].'") != 0 '.$query_instr.' 
                 GROUP BY `users`.`country` 
                 ORDER BY users DESC';

        $logs = $conn->query($query);
        $res = $logs->fetchall(PDO::FETCH_ASSOC);
        return $res;

    }
}
