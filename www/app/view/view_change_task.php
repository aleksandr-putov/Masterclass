<script src="/js/bootstrap-datepicker.min.js"></script>
<script src="/js/locales/bootstrap-datepicker.ru.min.js"></script>
<link href="/css/bootstrap-datepicker3.min.css" rel="stylesheet">

<div id="content">
    <h2>Изменить занятие для <a href="/group/view/<?= $view['group']['id'] ?>"><?= $view['group']['grade'] . " " . $view['group']['year'] ?></a></h2>
    <form role="form"  class=" well" method="post" action="/task/change/<?= $view['task']['id'] ?>">
        <p><label>Название занятия</label><br/><input type="text" name='name' class="form-control" size="90" value="<?=$view['task']['taskname']?>"></p>
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
            <textarea cols="120" class="form-control" name='description' rows="3"><?=$view['task']['description']?></textarea></p>
        <p><label>Максимальный балл</label> <input type="number"  name='maxScore' value="<?=$view['task']['rating']?>" min="0" max="100"></p>
    <br/>
        <div class="btn-group" role="group" aria-label="...">
            <input class="btn btn-primary" type="submit" value="Сохранить изменения"><a href="/task/view/<?= $view['task']['id'] ?>" class="btn btn-primary">Отменить и вернуться</a>
        </div>
    </form>	


</div>			