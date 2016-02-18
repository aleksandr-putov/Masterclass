<h1><?= $view['user']['fio'] ?></h1>
<h4><? switch ($view['user']['rights']) {
    case '0':
    echo "Администратор";
    break;
    case '1':
    echo "Преподаватель";
    break;
    default:
    echo "Участник";
    break;
    }?></h4>
<?php if (isset($GLOBALS['err'])): ?>
		<p class="text-error"><?=$GLOBALS['err']?></p>
	<?php endif; ?>
<table class="table">
    <tbody>
        <tr>
	<?php if ($view['canEdit']): ?>
            <td>Логин</td><td><?= $view['user']['login'] ?></td></tr>
        
            <tr><td>Пароль</td><td> <a href="/user/changepwd/<?= $view['user']['login'] ?>"> Сменить</a></td></tr>
        <?php endif; ?>
        <?php if ($view['user']['rights'] == 2): ?>
            <tr><td>Группа</td><td><a href="/group/view/<?=$view['group_id']?>"><?=$view['group_name']?></a></td></tr>
            <?php if ($view['canViewPrivate']): ?>
            tr><td>Место жительства</td><td><?= $view['user']['placeofliving'] ?></td></tr>

            <tr><td>Учёба</td><td><?= $view['user']['school'] ?>
                    <? if ($view['user']['schoolgrade']):?>, <?= $view['user']['schoolgrade'] ?> класс<?endif?></td></tr>

            <tr><td>Дата рождения</td><td><?php if ($view['user']['birthdate']!='30.11.-0001'):?> <?=$view['user']['birthdate'] ?><?php endif;?></td></tr>
            
                <tr><td>E-mail</td><td><?= $view['user']['email'] ?></td></tr>
                <tr><td>Телефон</td><td><?= $view['user']['phone'] ?></td></tr>
                <tr><td>ФИО родителя</td><td><?= $view['user']['parentfio'] ?></td></tr>
                <tr><td>Телефон родителя</td><td><?= $view['user']['parentphone'] ?></td></tr>
            <?php endif; ?>

            <?php if ($view['canEdit']): ?>
            <tr><td><a href="/user/change/<?= $view['user']['login'] ?>" class="btn btn-primary btn-lg pull-left">Изменить личные данные</a></td></tr>
        <?php endif; ?>
    <?php endif; ?>
</tbody>
</table>
