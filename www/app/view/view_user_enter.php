<div class="col-md-2"></div>
<div class="col-md-8 well"> 
    <?php if (isset($GLOBALS['err'])): ?>
        <p class="text-error"><?= $GLOBALS['err'] ?></p>
    <?php endif; ?>
    <form role="form"  method="post" action="/user/enter">
        <input class="form-control" type="text" name="username" placeholder="Логин"><br/>
        <input class="form-control" type="password" name="password" placeholder="Пароль"><br/>
        <input class="btn btn-primary" type="submit" value="Войти">
        <input type="hidden" name="action" value="auth" />
    </form>
</div>
<div class="col-md-2"></div>