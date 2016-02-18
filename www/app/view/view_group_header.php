<div><h2><a href="/group/view/<?= $view['group']['id'] ?>"><?= $view['group']['grade'] . " " . $view['group']['year'] ?></a></h2>
    <? if($view['group']['active']=='1'):?>Активная<? else: ?>В архиве<? endif; ?>
    <br/>
    Преподаватель: <? if($view['group']['teacher']!=NULL):?><a href="/profile/<?= $view['group']['teacher']['login'] ?>"><?= $view['group']['teacher']['fio'] ?></a><? else: ?>-<? endif;?></br>
    Расписание: По пятницам с 18:00 до 23:00 в кабинете D426</br>

    <br/>
</div>
/ЭТОТ ВЬЮ НЕ ИСПОЛЬЗУЕТСЯ :(