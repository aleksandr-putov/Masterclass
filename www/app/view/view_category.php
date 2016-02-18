<?php
function rec($array)
{?>
 	<!--<ul class="nav nav-pills">-->
		<?php foreach ($array as $key): ?>
		<li <?php if ($_SERVER['REQUEST_URI']=="/catalog/cat/".$key['id']): ?> class="active"<?php endif; ?>  ><a href="/catalog/cat/<?=$key['id']?>"><?=$key['name']?></a></li>
		<?php if (count($key['child'])>0)
		{
			rec($key['child']);
		}
			endforeach; ?>
	<!--</ul>-->
<?php }
 
	//var_dump($view['menu']);
	rec($view['menu']);
	?>