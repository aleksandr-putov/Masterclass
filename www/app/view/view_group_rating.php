<?= $view['header'] ?>
<h2><a href="/group/view/<?= $view['group']['id'] ?>"><?= $view['group']['grade'] . " " . $view['group']['year'] ?></a></h2>
<?php if ($view['haveRights']): ?>
    <div class="btn-group" role="group" aria-label="...">
        <a href="/task/add/<?= $view['group']['id'] ?>" class="btn btn-primary">Добавить занятие</a>
        <a href="/rating/schange/<?= $view['group']['id'] ?>" class="btn btn-primary">Изменить оценки</a>
    </div>
    <br/><br/>
<?php endif; ?>
<div class="layer">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td width="200px" rowspan="2"></td>
                <?php for ($index = 0; $index < count($view['tasks']); $index++): ?>
                    <td><a href="/task/view/<?= $view['tasks'][$index]['id'] ?>" title="<?= $view['tasks'][$index]['taskname'] ?>"><?php echo ($view['tasks'][$index]['taskdate']) ? $view['tasks'][$index]['taskdate'] : "доп" ?></a></td>

                <?php endfor; ?>
            </tr>
            <tr>
                <?php for ($index = 0; $index < count($view['tasks']); $index++): ?>
                    <td>0..<?= $view['tasks'][$index]['rating'] ?></td>        
                <?php endfor; ?>
            </tr>

            <?php if ($view['students'] || $view['studentsOld']): ?>
                <?php if ($view['students']) foreach ($view['students'] as $student): ?>							
                    <tr><td style="min-width: 235px;"><a href="/user/view/<?= $student['login'] ?>"><?= $student['fio'] ?></a></td>
                        <?php for ($index = 0; $index < count($view['tasks']); $index++):
                            if ($student['rating'][$view['tasks'][$index]['id']]['rating']>0):
                                ?>
                                <td><?= $student['rating'][$view['tasks'][$index]['id']]['rating'] ?></td>
                            <?php else: ?>
                                <td>-</td>
                            <?php endif; ?>
                    <?php endfor; ?>
                    </tr>
                <?php endforeach; ?>
                    <?php if ($view['studentsOld']) foreach ($view['studentsOld'] as $student): ?>							
                    <tr class="old"><td style="min-width: 235px;"><a  class="old" href="/user/view/<?= $student['login'] ?>"><?= $student['fio'] ?></a></td>
                        <?php for ($index = 0; $index < count($view['tasks']); $index++):
                            if ($student['rating'][$view['tasks'][$index]['id']]['rating']>0):
                                ?>
                                <td><?= $student['rating'][$view['tasks'][$index]['id']]['rating'] ?></td>
                            <?php else: ?>
                                <td>-</td>
                            <?php endif; ?>
                    <?php endfor; ?>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                Группа не содержит участников
<?php endif; ?>
        </tbody>
    </table>
</div>

