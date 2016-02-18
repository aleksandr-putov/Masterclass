<h2>
	<a href="/group/view/<?=$view['group']['id']?>"><?=$view['group']['grade'] ?> <?=$view['group']['year'] ?></a>
</h2>
<h3><?=$view['task']['taskname']?></h3>
<p>Дата занятия: <?php echo ($view['date'])?$view['date']:"без даты"?></p>
<div>Описание:</div><div><?=$view['task']['description']?></div>
<?php if ($view['haveRights']):?>
	<a href="/task/change/<?=$view['task']['id']?>" class="btn btn-primary">Изменить занятие</a><br/><br/>
<?php endif;?>
