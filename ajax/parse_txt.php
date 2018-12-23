<?php


//$m = new Memcached();
//$m->addServer('localhost', 11211);

//main logic

if ($_REQUEST['path']) {
    require_once('../config/init.php');
    $conn = db::getConnection();
    CreateTable();
    $offset2 = $post_offset = (int)$_REQUEST['offset'];

    if ($post_offset == 0) {
//        $offset2 = $post_offset = 20300;
//        $conn->query('TRUNCATE TABLE `info`');
    }

    $txt_file    = file_get_contents($_REQUEST['path']);
    $rows        = explode("\n", $txt_file);
    if ($_REQUEST['count'])
        $count = $_REQUEST['count'];
    else
        $count = count($rows);

    foreach($rows as $row => $line)
    {

        if ($row  > $post_offset) {

            $conn->beginTransaction();
            $data = stristr($line, '|');
            $row_data = explode(' ', $data);

            $info['datetime']       = $row_data[1] . ' ' . $row_data[2];
            $info['code']  		    = $row_data[3];
            $info['user']       	= userID($row_data[5]);
            $info['action']         = $row_data[6] ;
//
            $conn->exec(insertSQL('info', $info));
            $conn->commit();
            $offset2++;
            if ($offset2 % 100 == 0 || $offset2 == $count) break;
        }
    }



    $res['offset'] = $offset2;
    $res['success'] = $offset2/$count;
    $res['count'] = $count;
    echo json_encode($res);
    return;
}
else {
    echo json_encode(['error' => 'not find file']);
    return;
}
