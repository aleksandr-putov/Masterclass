<p>АдминкаАДМИНОЧКА!</p>
<!-- <div class="col-md-5">
    <h3>Активные группы:</h3>
    <?php foreach ($view['groups'] as $group): ?>							
        <a href="/admin/group/<?= $group['id'] ?>" class="btn btn-primary"> <?= $group['grade'] . " " . $group['year'] ?></a><br/><br/>
    <?php endforeach; ?>
</div> -->
<div class="col-md-4">
    <h3>Управление</h3>
    <a href="/admin/create_group" class="btn btn-primary">Создать группу</a><br/><br/>
    <a href="/admin/create_user" class="btn btn-primary">Создать пользователя</a><br/><br/>
    <a href="/admin/bulk_create_users" class="btn btn-primary">Массовое создание участников</a><br/><br/>
    <a href="/group/deadSouls" class="btn btn-primary">Участники без группы</a>
</div>
<!-- <div class="col-md-3">
    <h3>Архив групп</h3>
    <a href="/group/archive" class="btn btn-primary">Архив групп</a>
</div> -->

