<?php require_once 'header.php'; ?>
    <div class="form">
        <h3>Укажите путь к логам</h3>
        <form id='logs'>
            <input type="text" name="path" id="path" value="logs.txt">
            <input id="offset" name="offset" type="hidden">
            <input id="count" name="count" type="hidden">
            <input id="submit" type="submit" value ="Получить">
            <p id="answer"></p>
        </form>
        <div class="progress" style="display: none">
            <div class="bar"></div>
        </div>
    </div>
    <div class="reports">
        <h3>Выберите отчет</h3>
        <p class='ajax'><a href="/reports/countries">Посетители какой страны совершают больше всего действий на сайте?</a></p>
        <p class='ajax'><a href="/reports/hour">Какая нагрузка на сайт на астрономический час?</a></p>
        <p class='ajax'><a href="/reports/users">Посетители из какой страны чаще всего интересуются товарами из определенных категорий?</a></p>
    </div>

    <div id="result">
    </div>
<?php require_once 'footer.php';