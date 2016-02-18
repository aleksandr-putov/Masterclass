<script type="text/javascript">
	function addToCartJS (id) {
		$.get("/cart/addToCart/"+id, function(){
		//alert("Товар добавлен");

		});

	}


</script>
<?php foreach ($view['cats'] as $key): ?>
<div class="row"><div class="span8"><a href="/catalog/cat/<?=$key['id']?>"><?=$key['name']?></a></div></div>
<?php endforeach;?>

<?php foreach ($view['items'] as $key) include "app/view/view_item.php"; ?>
<div class="row span8">
<?php
$n=5;
if ($view['page']>$n+1):?>
<a href="/catalog/cat/<?=$view['cat']?>/1">1</a> <?php if ($view['page']>$n+2):?>... <?endif;?>
<?endif;?>
<?php for($i=max($view['page']-$n,1); $i<=min($view['page']+$n,$view['pages']);$i++):?>
<?php if ($i==$view['page']):?><?=$i?> <?else:?><a href="/catalog/cat/<?=$view['cat']?>/<?=$i?>"><?=$i?></a> <?endif;?>
<?php endfor;?>
<?if ($view['page']<$view['pages']-$n):?>
 <?php if ($view['page']<$view['pages']-$n-1):?> ... <?endif;?><a href="/catalog/cat/<?=$view['cat']?>/<?=$view['pages']?>"><?=$view['pages']?></a>
<?endif;?>
</div>