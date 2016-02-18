<?php if ($view['years']): ?>
    <h2>Список архивных групп</h2><br/>
    <table class="table">
        <?php foreach ($view['years'] as $year): ?>										
            <tr><td><h4><?= $year ?></h4></td></tr>	
            <?php foreach ($view['groups'][$year] as $group): ?>							
                <tr><td><a href="/group/view/<?= $group['id'] ?>"><?= $group['grade'] ?></a></td></tr>
            <?php endforeach; ?>

        <?php endforeach; ?>
    </table>
<?php else: ?>
    Архив пуст
<?php endif; ?>