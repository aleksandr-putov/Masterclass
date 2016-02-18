<div> 
    <form class="form-horizontal" method="post" action="/user/contact">
        <textarea rows="3" name="contact"><?= $view['contact'] ?></textarea><br/>
        <input class="btn btn-primary" type="submit" value="Сменить">
        <input type="hidden" name="action" value="change" />
    </form>
</div>