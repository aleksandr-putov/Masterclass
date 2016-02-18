<script type="text/javascript">
function checkAll(obj) {
  'use strict';
  // Получаем NodeList дочерних элементов input формы: 
  var items = obj.form.getElementsByTagName("input"), 
      len, i;
  // Здесь, увы цикл по элементам формы:
  for (i = 0, len = items.length; i < len; i += 1) {
    // Если текущий элемент является чекбоксом...
    if (items.item(i).type && items.item(i).type === "checkbox") {
      // Дальше логика простая: если checkbox "Выбрать всё" - отмечен            
      if (obj.checked) {
        // Отмечаем все чекбоксы...
        items.item(i).checked = true;
      } else {
        // Иначе снимаем отметки со всех чекбоксов:
        items.item(i).checked = false;
      }       
    }
  }
}
</script>

<h2>Участники без группы</h2>

<form role="form"  class=" well" method="post" action="/group/transfer/-1">
<div class="layer">
    <table class="table table-bordered">
        <tbody>
            <?php if ($view['students']): ?>
                    <tr>
                        <td style="min-width: 50px;"><label for="one">Выбрать всех</label></p><input id="one" type="checkbox" name="one" value="all" onclick="checkAll(this)" /></td>
                        <td>
                            <label name="group">Группа</label>
                            <select name="group" class="form-control" value="">
                                <?php foreach ($view['groups'] as $group): ?>

                                        <option value="<?= $group['id'] ?>"><?= $group['grade'] . " " . $group['year'] ?></option>

                                 <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                <?php foreach ($view['students'] as $student): ?>							
                    <tr>
                        <td style="width: 20px;" ><input class="input" type="checkbox" name="<?=$student['id']?>" id="<?=$student['id']?>"></td>
                        <td style="min-width: 235px;"><a href="/user/view/<?= $student['login'] ?>"><?= $student['fio'] ?></a></td>                        
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                Нет участников без групп.
            <?php endif; ?>
        </tbody>
    </table>
</div>
 
<div class="btn-group" role="group" aria-label="...">
    <input class="btn btn-primary" type="submit" value="Добавить" />
    <a href="/admin" class="btn btn-primary">Отменить и вернуться</a>
</div>

   </form>
