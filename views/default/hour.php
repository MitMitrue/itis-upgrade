<?php require_once 'header.php'; ?>

    <form action="" >
        <p>Выберите прошедший астрономический  час</p>
        <br>
        <p><input type="datetime-local" name="datetime"
            <?php if(key_exists('datetime',$_REQUEST)):?>
                value="<?php echo $_REQUEST['datetime'] ?>"
            <?php else:?>
                value="2018-08-01T01:01"
            <?php endif;?>
            >
        <input type="submit" value="Отчёт"></p>
    </form>
<br>
<br>
<br>
    <?php if(@$date && @$response):?>
        <p> Нагрузка на прошедший час <?php echo $date?> состотовляет <?php echo $response['actions'] ?>  запросов.</p>
    <?php endif;?>
<?php require_once 'footer.php'; ?>
