<script src="/js/bootstrap-datepicker.min.js"></script>
<script src="/js/locales/bootstrap-datepicker.ru.min.js"></script>
<script type="text/javascript" src="/js/taskWarning.js"></script>
<link href="/css/bootstrap-datepicker3.min.css" rel="stylesheet">

<div id="content">
    <h2>Новое занятие для <a href="/group/view/<?= $view['group']['id'] ?>"><?= $view['group']['grade'] . " " . $view['group']['year'] ?></a></h2>
    <form role="form"  class=" well" method="post" action="/task/add/<?= $view['group']['id'] ?>">
        <p><label>Название занятия</label><br/><input type="text" name='name' class="form-control" size="90" value=""></p>
        <p><label>Дата проведения занятия</label><br/><input id="datepicker" type="text" name='date' class="form-control" value="<?=$view['date']?>"></p>
        <script>
    $('#datepicker').datepicker({
        format: "d.mm.yyyy",
        maxViewMode: 1,
        language: "ru",
        orientation: "bottom left",
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });
</script>
        <p><label>Описание задания</label><br/>
            <textarea cols="120" class="form-control" name='description' rows="3"></textarea></p>
        <p><label>Максимальный балл</label> <input type="number"  name='maxScore' value="10" min="0" max="100"></p>
    <br/>
    <p id="dateWarning">При отсутствии даты занятие отображаться в таблице "Посещаемость" не будет.</p>
    <br/>
    <p id="scoreWarning">При отсутствии максимального балла занятие отображаться в таблице "Рейтинг" не будет.</p>
    <br/>
        <div class="btn-group" role="group" aria-label="...">
            <input class="btn btn-primary" type="submit" value="Создать занятие"><a href="/group/view/<?= $view['group']['id'] ?>" class="btn btn-primary">Отменить и вернуться</a>
        </div>
    </form>	


</div>			