<h1><?= $view['group']['grade'] . ' ' . $view['group']['year'] ?> </h1>
<form role="form"  method="post">
    <table class="table">
        <tbody>
        <input type="hidden" name="id" value="<?= $view['group']['id'] ?>">
        <br/><label>Преподаватель</label>
        <select name="teacher" class="form-control" value="">
            <? foreach ($view['teachers'] as $teacher):?>
            <option <?php if ($view['teacher'] == $teacher['id']): ?> selected <?php endif; ?> value="<?= $teacher['id'] ?>"><?= $teacher['fio'] ?></option>
            <? endforeach;?>
        </select>
        <br/></tbody>
    </table>
    <div class="btn-group" role="group" aria-label="...">
        <input type="submit" class="btn btn-primary btn-lg pull-left" value="Сохранить изменения">
        <a href="/admin/group/<?= $view['group']['id'] ?>" class="btn btn-primary btn-lg pull-left">Отменить и вернуться</a>
    </div>
</form>