<script src="/js/bootstrap-datepicker.min.js"></script>
<script src="/js/locales/bootstrap-datepicker.ru.min.js"></script>
<link href="/css/bootstrap-datepicker3.min.css" rel="stylesheet">

<div id="content">
    <h2>Новые участники <a href="/group/view/<?= $view['group']['id'] ?>"><?= $view['group']['grade'] . " " . $view['group']['year'] ?></a></h2>
    <form role="form"  class=" well" method="post" action="/admin/bulk_create_users/<?= $view['group']['id'] ?>">
    <div>
        <label name="group">Группа</label>
        <select name="group" class="form-control" value="">
            <?php foreach ($view['groups'] as $group): ?>
                <option <?php if ($group['id'] == $view['defaultGroupID']): ?>
                        selected
                    <?php endif; ?>
                    value="<?= $group['id'] ?>"><?= $group['grade'] . " " . $group['year'] ?></option>
                <?php endforeach; ?>
        </select>
    </div>
        <p><label>ФИО новых участников (каждое ФИО с новой строки)</label><br/>
            <textarea cols="120" class="form-control" name='fios' rows="10"></textarea></p>
    <br/>
    <br/>
    <div class="btn-group" role="group" aria-label="...">
        <input class="btn btn-primary" type="submit" value="Создать участников"><a href="/admin/" class="btn btn-primary">Отменить и вернуться</a>
    </div>
    </form>	


</div>			