<div> 
    <?php if (isset($GLOBALS['err'])): ?>
        <p class="text-error"><?= $GLOBALS['err'] ?></p>
    <?php endif; ?>
    <form class="form-horizontal" method="post" action="/user/register">
        <input type="text" name="username" class="placeholder" placeholder="Логин"/><br/>
        <input type="password" name="password" class="placeholder" placeholder="Пароль"/><br/>
        <input class="btn btn-primary" type="submit" value="Зарегистрироваться"/>
        <input type="hidden" name="action" value="reg" />
    </form>
</div>