
	
		<div class="span8 item well well-small thumbnail" style="margin-bottom:10px; margin-left: 0px; ">
			<a href="/catalog/item/<?=$key['id']?>" style="color:#333"> 
				<div class="span2" style="margin-top: 1%; margin-bottom: 1%;">
					<img<?php if ($key['image']==null):?>
					src="/img/image.jpg"
				<?php else:?>
				src="/img/<?=$key['image']?>"
			<?php endif;?>class="img-rounded" style="width:100px">
				</div>
				<div class="row span8"> 
					<div  style="margin-left:10px; margin-top:1%; font-size:20px; font-weight:bold">
						<?=$key['name']?>
					</div>
					<div  style="margin-left:10px">
						Здесь будет описание неустановленной длины. Что-нибудь про изящнейший вкус и прочее прочее прочее. Сгенерирую как нибудь на досуге!
					</div>
				</div>
			</a>
			
			<div class="row span2 buy img-rounded" style="font-size:20px; font-weight:bold; text-align: center; margin-top:1%">
				<div class="row">
					<p><?=$key['price']?></p>
				</div>
				<?php if($buying):?>
				<div class="row">
					<button class="btn btn-small" onclick="addToCartJS(<?=$key['id'] ?>)">В корзину</button>
				</div>
				<?php endif;?>
			</div>
			
			

		</div>
