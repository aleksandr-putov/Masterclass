<h2>Новая группа</h2><br/>

<form role="form"  class=" well" method="post" action="/admin/create_group">

    <?php if (isset($GLOBALS['err'])): ?>
        <p class="text-error"><?= $GLOBALS['err'] ?></p>
    <?php endif; ?>
    <label>Название</label><br/><input type="text" name="grade" class="form-control" size="90" value="">
    <label>Год</label><br/><input type="text" name="year" class="form-control" size="90" value="">
    <br/><label>Преподаватель</label>
    <select name="teacher" class="form-control" value="">
        <? foreach ($view['teachers'] as $teacher):?>
        <option value="<?= $teacher['id'] ?>"><?= $teacher['fio'] ?></option>
        <? endforeach;?>
    </select>
    <br/>

    <div class="btn-group" role="group" aria-label="...">
        <input class="btn btn-primary" type="submit" value="Добавить"><a href="/admin/" class="btn btn-primary">Отменить и вернуться</a>
    </div>
</form>