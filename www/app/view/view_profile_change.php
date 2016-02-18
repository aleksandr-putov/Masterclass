<script src="/js/bootstrap-datepicker.min.js"></script>
<script src="/js/locales/bootstrap-datepicker.ru.min.js"></script>
<link href="/css/bootstrap-datepicker3.min.css" rel="stylesheet">

<h1><?= $view['user']['fio'] ?></h1>
<form role="form"  method="post">
    <table class="table">
        <tbody>
            <tr><td>Логин</td><td><?= $view['user']['login'] ?></td></tr>
        <input type="hidden" name="fio" value="<?= $view['user']['fio'] ?>">
        <tr><td>Место жительства</td><td><input name="placeofliving" type="text" class="form-control" value="<?= $view['user']['placeofliving'] ?>"></td></tr>

        <tr><td>Школа</td><td><input type="text" name="school" class="form-control" value="<?= $view['user']['school'] ?>"></td></tr>
        <tr><td>Класс</td><td><input type="text"  name="schoolgrade" class="form-control"value="<?= $view['user']['schoolgrade'] ?>"></td></tr>
        <tr><td>Дата рождения</td><td><input id="datepicker" type="text" name="birthdate"  class="form-control" placeholder="д.мм.гггг" value="<?=$view['user']['birthdate'] ?>"></td></tr>
                <script>
    $('#datepicker').datepicker({
    format: "d.mm.yyyy",
    startDate: "01.01.1990",
    endDate: "31.12.2015",
    startView: 2,
    language: "ru",
    autoclose: true
});
</script>
        <tr><td>E-mail</td><td><input type="email" name="email" class="form-control" value="<?= $view['user']['email'] ?>"></td></tr>
        <tr><td>Телефон</td><td><input type="tel" name="phone" class="form-control" value="<?= $view['user']['phone'] ?>"></td></tr>
        <tr><td>ФИО родителя</td><td><input type="text" name="parentfio" class="form-control" value="<?= $view['user']['parentfio'] ?>"></td></tr>
        <tr><td>Телефон родителя</td><td><input type="tel" name="parentphone" class="form-control" value="<?= $view['user']['parentphone'] ?>"></td></tr>
        </tbody>
    </table>
    <div class="btn-group" role="group" aria-label="...">
        <input type="submit" class="btn btn-primary btn-lg pull-left" value="Сохранить изменения">
        <a href="/user/view/<?= $view['user']['login'] ?>" class="btn btn-primary btn-lg pull-left">Отменить и вернуться</a>
    </div>
</form>