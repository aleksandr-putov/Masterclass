<?= $view['header'] ?>
<script type="text/javascript" src="/js/rating.js"></script>
<script>
$( document ).ready(attendance_ready);
</script>
<h2><a href="/group/view/<?= $view['group']['id'] ?>"><?= $view['group']['grade'] . " " . $view['group']['year'] ?></a></h2>
<?php if ($view['haveRights']): ?>
<div class="btn-group" role="group" aria-label="...">
    <a onclick="attendance_send()" class="btn btn-primary">Сохранить изменения</a>
    <a href="/rating/a/<?= $view['group']['id'] ?>" class="btn btn-primary">Отменить и вернуться</a>
</div>
<br/><br/>
    <?php endif; ?>
<div class="layer">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td rowspan="2"></td>
                <?php for ($index = 0; $index < count($view['tasks']); $index++): ?>
                  <td><a href="/task/view/<?= $view['tasks'][$index]['id']?>" title="<?= $view['tasks'][$index]['taskname']?>"><?php echo ($view['tasks'][$index]['taskdate'])?$view['tasks'][$index]['taskdate']:"доп" ?></a></td>


                <?php endfor; ?>
            </tr>
            <tr>
                <?php for ($index = 0; $index < count($view['tasks']); $index++):?><td><?php if ($view['tasks'][$index]['rating']>0):?>
                    0..<?= $view['tasks'][$index]['rating'] ?>  
                    <?php endif;?>   
                    </td> 
                <?php endfor; ?>
            </tr>

            <?php if ($view['students']): ?>
                <?php foreach ($view['students'] as $student): ?>							
                    <tr><td style="min-width: 235px;"><a href="/user/view/<?= $student['login'] ?>"><?= $student['fio'] ?></a></td>
                        <?php for ($index = 0; $index < count($view['tasks']); $index++): ?>
                    <td><input class="input" type="checkbox" id_s="<?=$student['id']?>" id_t="<?=$view['tasks'][$index]['id']?>"
                    <?php if ($student['rating'][$view['tasks'][$index]['id']]['attendance']): ?>
                       checked
                    <?php endif; ?>                       
                        >
                        </td>
                <?php endfor; ?>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            Группа не содержит участников
        <?php endif; ?>
        </tbody>
    </table>
</div>

