<div class="con-recent container pull right" style="background-color:darkgrey;">
<div class="col-md-2 no-float">

</div>
<h3 class="text-center" style="color:white;">Winkelwagentje</h3>

<div style="color:white;">
	<?php if(empty($cart_id)): ?>
		<p>Je winkelwagentje is leeg</p><hr>
	<?php  else:
	    $cartQ = $db->query("select * from cart where id = '{$cart_id}'");
	    $result = mysqli_fetch_assoc($cartQ);
	    $items = json_decode($result['items'],true);
	    $i =1;
	    $sub_total = 0;
	 ?>
	 <table class="table table-condensed" id="cart_widget">
	 	<tbody>
	 		<?php foreach ($items as $item):
	 		   $productQ = $db->query("select * from products where id = '{$item['id']}'");
	 		   $product = mysqli_fetch_assoc($productQ);
	 		?>
	 		<tr>
	 			<td><?=$item['quantity'];?></td>
	 			<td><?=substr($product['title'],0.15); ?></td>
	 			<td><?=money($item['quantity'] * $product['price']);?></td>
	 		</tr>
     	 	<?php
     	 	     $sub_total += ($item['quantity'] * $product['price']);
      	 	     endforeach; ?>
      	 	<tr>
      	 		<td></td>
      	 		<td>Sub Total</td>
      	 		<td><?=money($sub_total);?></td>
      	 	</tr>
	 	</tbody>
	 </table>
	 <a href="cart.php"  class="btn pull-right" style="background-color:white;color:black">Winkelwagentje</a>
	 <div class="clearfix"></div>
	<?php endif; ?>
</div>

<h3 class="text-center" style="color:white;">Populaire Producten</h3>
<?php
$popQ = $db->query("SELECT * from cart where paid = 1 order by id desc limit 5");
$resul = array();
while ($row = mysqli_fetch_assoc($popQ)) {
	$resul[] = $row;
}
$row_count = $popQ->num_rows;
$used_ids = array();
for ($i=0; $i < $row_count; $i++) {
	$json_items = $resul[$i]['items'];
	$items = json_decode($json_items,true);
	foreach ($items as $item) {
		if (!in_array($item['id'], $used_ids)) {
			$used_ids[] = $item['id'];
		}
	}
}
?>

<div id="recent_widget" style="color:white;">
	<table class="table table-condensed">
		<?php foreach ($used_ids as $id):
           $prodQ = $db->query("SELECT * from products where id = '{$id}'");
           $prod = mysqli_fetch_assoc($prodQ);
		?>
		<tr>
			<td>
				<?=substr($prod['title'], 0.15); ?>
			</td>
			<td>
				<a class="text-primary" onclick="detailsmodal('<?=$id;?>')">Bekijk</a>
			</td>
		</tr>
        <?php endforeach; ?>
	</table>
</div>
</div>
</div>
