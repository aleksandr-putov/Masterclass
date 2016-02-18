<?= $view['header'] ?>

<?php if ($view['haveAdminRights'] || ($view['haveRights'])): ?>
<div class="well">
<?php endif; ?>
<?php if ($view['haveAdminRights']): ?>
    <?php if ($view['group']['active']): ?>
    <script type="text/javascript">
        $(document).ready(function(){$('#archive').click(function()
{
    if (confirm("Вы уверены, что хотите внести группу в архив? Эта операция не подлежит отмене и сделает группу недоступной для любых изменений."))
        window.location.href="/group/setarchived/<?= $view['group']['id'] ?>";
})});

</script>
        <div class="btn-group" role="group" aria-label="...">
            <a href="/group/change/<?= $view['group']['id'] ?>" class="btn btn-primary">Сменить преподавателя</a>
            <a class="btn btn-danger" id="archive">Отправить в архив</a>
                    </div><br/><br/>
                    <?php endif; ?>
       <div class="btn-group" role="group" aria-label="...">
    <?php if ($view['group']['active']): ?><a href="/group/transfer/<?= $view['group']['id'] ?>" class="btn btn-primary">Перевести участников</a><?php endif; ?><a href="/admin/export/<?= $view['group']['id'] ?>" class="btn btn-primary">Экспортировать список участников</a>
</div><br/><br/>

<?php endif; ?>
<?php if ($view['haveRights']): ?>
    <a href="/task/add/<?= $view['group']['id'] ?>" class="btn btn-primary">Добавить занятие</a><br/>
<?php endif; ?>
    
<?php if ($view['haveAdminRights'] || ($view['haveRights'])): ?>
</div>
<?php endif; ?>

<div class="btn-group" role="group" aria-label="...">
    <a href="/rating/s/<?= $view['group']['id'] ?>" class="btn btn-primary">Рейтинг</a>
    <a href="/rating/a/<?= $view['group']['id'] ?>" class="btn btn-primary">Посещаемость</a>
</div>

<br/><br/>
<?php if ($view['students'] || ($view['studentsOld']) ): ?>
    Список участников:<br/>
    <table class="table">
        <?php if ($view['students']) foreach ($view['students'] as $student): ?>							
            <tr><td><a href="/user/view/<?= $student['login'] ?>"><?= $student['fio'] ?></a></td></tr>
        <?php endforeach; ?>
        <?php if ($view['studentsOld']) foreach ($view['studentsOld'] as $student): ?>							
            <tr><td><a class="old" href="/user/view/<?= $student['login'] ?>"><?= $student['fio'] ?></a></td></tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    Группа не содержит текущих участников
<?php endif; ?>
  


</br>
<?php if ($view['tasks']): ?>
    Список заданий:<br/>
    <table class="table">
        <?php foreach ($view['tasks'] as $task): ?>							
            <tr><td><a href="/task/view/<?= $task['id'] ?>"><?= $task['taskname'] ?></a></td><td><?= $task['taskdate'] ?></td></tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    Группа не содержит занятий
<?php endif; ?>

