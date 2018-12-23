<?php require_once 'header.php'; ?>
    <form>
        <p>Перечислите категории через запятую</p>
        <br>
        <input type="text" name="categories" placeholder=" Пример: fresh_fish, canned_food"
               <?php if (key_exists('categories',$_REQUEST)) :?>value="<?php echo $_REQUEST['categories']?>" <?php endif?>>
        <input type="submit"></p>
    </form>
    <br>
    <?php if(isset($res)):?>
        <p>Посетители из страны  <?php echo $res[0]['country'];?> чаще всего интересуются товарами из <?php echo $_REQUEST['categories']?> категорий</p>
            <table border="1" id="table">
                <caption>Посетилели стран</caption>
                <tr>
                    <th>Страна</th>
                    <th>Посетилели</th>
                </tr>
                <?php foreach($res as $ad):?>
                    <tr>
                        <?php if($ad['country']):?>
                            <td><?=$ad['country']?></td>
                        <?php else:?>
                            <td>Не определено</td>
                        <?php  endif;?>
                        <td><?=$ad['users']?></td>
                    </tr>
                <?php endforeach;?>
            </table>
    <?php endif?>
<?php require_once 'footer.php'; ?>