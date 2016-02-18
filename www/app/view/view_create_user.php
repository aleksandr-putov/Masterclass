
<script type="text/javascript" src="/js/translite.js"></script>
<script type="text/javascript" src="/js/password.js"></script>
<script type="text/javascript" src="/js/groupShow.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        pswd();
    });
</script>
<h2>Новый пользователь</h2><br/>

<form role="form"  class=" well" method="post" action="/admin/create_user">

    <?php if (isset($GLOBALS['err'])): ?>
        <p class="text-error"><?= $GLOBALS['err'] ?></p>
    <?php endif; ?>
    <label>ФИО</label><br/><input id="name" type="text" name="fio" onblur="translit()" class="form-control" size="90" value="">
    <label>Логин</label><br/><input id="alias" type="text" name="username" class="form-control" size="90" value="">
    <label>Пароль</label><br/>
    <div class="input-group">
        <input id="pass" type="text" name="password" class="form-control" size="90" value="">
        <span class="input-group-btn">
            <button class="btn btn-primary" type="button" onclick="pswd()">Сгенерировать</button>
        </span>
    </div>
    <br/><label>Тип пользователя</label>
    <select name="rights" class="form-control" value="">
        <option value="2">Участник</option>
        <option value="1">Преподаватель</option>
        <option value="0">Администратор</option>
    </select>
    <div>
        <br/><label name="group">Группа</label>
        <select name="group" class="form-control" value="">
            <?php foreach ($view['groups'] as $group): ?>
                <option <?php if ($group['id'] == $view['defaultGroupID']): ?>
                        selected
                    <?php endif; ?>
                    value="<?= $group['id'] ?>"><?= $group['grade'] . " " . $group['year'] ?></option>
                <?php endforeach; ?>
        </select>
    </div>
    <br/>

    <div class="btn-group" role="group" aria-label="...">
        <input class="btn btn-primary" type="submit" value="Добавить"><a href="/admin/" class="btn btn-primary">Отменить и вернуться</a>
    </div>
</form>