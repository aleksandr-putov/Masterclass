<?= $view['header'] ?>

<?php if ($view['group']['active']): ?>
    <div class="btn-group" role="group" aria-label="...">
        <a href="/group/change/<?= $view['group']['id'] ?>" class="btn btn-primary">Сменить преподавателя</a> <a href="" class="btn btn-primary">Изменить расписание</a>
        <a href="/group/setarchived/<?= $view['group']['id'] ?>" class="btn btn-danger">В архив</a>
    </div>
<?php else: ?>
    <div class="btn-group" role="group" aria-label="...">
        <a href="/group/setactive/<?= $view['group']['id'] ?>" class="btn btn-danger">Убрать статус архивной</a>
    </div>
<?php endif; ?>

<br/><br/>
<?php if ($view['students']): ?>
    Список участников:<br/>
    <table class="table">
        <?php foreach ($view['students'] as $student): ?>							
            <tr><td><a href="/user/view/<?= $student['login'] ?>"><?= $student['fio'] ?></a></td></tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    Группа не содержит участников
<?php endif; ?>
</br>
<div class="btn-group" role="group" aria-label="...">
    <?php if ($view['group']['active']): ?><a href="/group/transfer/<?= $view['group']['id'] ?>" class="btn btn-primary">Перевести из группы</a><?php endif; ?><a href="/admin/export/<?= $view['group']['id'] ?>" class="btn btn-primary">Экспорт списка</a>
</div>

