<?php require_once 'header.php'; ?>
    <?php if(!empty($res)):?>
    <p>Посетители из страны  <?php echo $res[0]['country']?> совершают большее количество действий.</p>

    <table border="1" id="table">
        <caption>Действия поселителей по странам</caption>
        <tr>
            <th>Страна</th>
            <th>Действия</th>
        </tr>
        <?php foreach($res as $ad):?>
            <tr>
                <?php if($ad['country']):?>
                <td><?=$ad['country']?></td>
                    <?php else:?>
                <td>Не определено</td>
                <?php  endif;?>
                <td><?=$ad['actions']?></td>
            </tr>
        <?php endforeach;?>
    </table>
    <?php else:?>
       <p>Логов нет.</p>
    <?php endif;?>

<?php require_once 'footer.php'; ?>
