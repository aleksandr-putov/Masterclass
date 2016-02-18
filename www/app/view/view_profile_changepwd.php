<h1><?= $view['user']['fio'] ?></h1>
<div class="well">
    <?php if (isset($GLOBALS['err'])): ?>
        <p class="text-error"><?= $GLOBALS['err'] ?></p>
    <?php endif; ?>
    <form role="form"  method="post">
        <table class="table">
            <tbody>
            	<script type="text/javascript" src="/js/pwdCheck.js"></script>
                <tr><td>Логин</td><td><?= $view['user']['login'] ?></td></tr>
                <?php if ($view['needConfirmation']): ?>	
                    <tr><td>Старый пароль</td><td><input name="oldpass" type="password" class="form-control" value=""></td></tr>
                    <tr><td>Новый пароль</td><td><input id="pass" type="password" name="newpass" class="form-control" value="" onblur="pwdCheck()"></td></tr>
                    <tr><td>Подтверждение</td><td><input type="password"  name="newpassconf" class="form-control"value=""></td></tr>
                <?php else: ?>
                <script type="text/javascript" src="/js/password.js"></script>
                <tr><td>Новый пароль</td><td><div class="input-group">
                            <input id="pass" type="text" name="newpass" class="form-control" size="90" value="" onblur="pwdCheck()">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" onclick="pswd()">Сгенерировать</button>
                            </span>
                        </div>
                    </td></tr>
            <?php endif; ?>
            </tbody>
        </table>
        <div class="btn-group" role="group" aria-label="...">
            <input type="submit" id="passChange" disabled="disabled" class="btn btn-primary btn-lg pull-left" value="Изменить пароль">
            <a href="/user/view/<?= $view['user']['login'] ?>" class="btn btn-primary btn-lg pull-left">Отменить и вернуться</a>
        </div>
    </form>
</div>