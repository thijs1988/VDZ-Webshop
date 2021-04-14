<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce website/core/init.php';
if (!is_logged_in()) {
  header('Location: login.php');
  }

   include 'includes/head.php';
   include 'includes/navigation.php';
?>
<!--Orders to fill-->
<?php
   $txnQuery = "SELECT t.id, t.cart_id, t.full_name, t.description, t.txn_date, t.grand_total, c.items, c.paid, c.shipped from transactions t
   left join  cart c on t.cart_id = c.id
   where c.paid = 1 and c.shipped = 0
   order by  t.txn_date";
   $txnResults = $db->query($txnQuery);
?>
<div class="row">
	<div class="col-md-12">
		<h3 class="top-header text-center">Orders To Ship</h3>
		<table class="table table-condensed table-bordered table-striped">
			<thead>
				<th></th><th>Name</th><th>Description</th><th>Total</th><th>Date</th>
			</thead>
			<tbody>
			<?php while($order = mysqli_fetch_assoc($txnResults)): ?>
				<tr>
					<td><a href="orders.php?txn_id=<?=$order['id']; ?>" class="btn btn-xs btn-info">Details</a></td>
					<td><?=$order['full_name']; ?></td>
					<td><?=$order['description']; ?></td>
					<td><?=money($order['grand_total']) ?></td>
					<td><?=pretty_date($order['txn_date']); ?></td>
				</tr>
			<?php endwhile; ?>
			</tbody>
		</table>
	</div>
</div>

<?php
  $lpQuery = "SELECT * FROM laadpalen";
  $lpResults = $db->query($lpQuery);
?>
<div class="row">
	<div class="col-md-12">
		<h3 class="text-center">Laadpaal Orders</h3>
		<table class="table table-condensed table-bordered table-striped">
			<thead>
				<th></th><th>Naam</th><th>adres</th><th>Telefoonnummer</th><th>leverdatum auto</th>
			</thead>
			<tbody>
			<?php while($lpOrder = mysqli_fetch_assoc($lpResults)): ?>
				<tr>
					<td><a href="laadpaal_orders.php?lp_id=<?=$lpOrder['id']; ?>" class="btn btn-xs btn-info">Details</a><a href="laadpaal_orders.php?edit=<?=$lpOrder['id'];?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
            <a href="laadpaal_orders.php?delete=<?=$lpOrder['id'];?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-trash"></span></a></td>
					<td><?=$lpOrder['naam']; ?></td>
					<td><?=$lpOrder['adres'].', '.$lpOrder['postcode'].', '.$lpOrder['plaats']; ?></td>
					<td><?=$lpOrder['telefoon']; ?></td>
					<td><?=$lpOrder['leverdata']; ?></td>
				</tr>
			<?php endwhile; ?>
			</tbody>
		</table>
	</div>
</div>

<div class="row">
<!--Sales By months-->
<?php
   $thisYr = date("Y");
   $lastYr = $thisYr -1;
   $thisYrQ = $db->query("SELECT grand_total, txn_date from transactions where YEAR(txn_date) = '{$thisYr}'");
   $lastYrQ = $db->query("SELECT grand_total, txn_date from transactions where YEAR(txn_date) = '{$lastYr}'");
   $current = array();
   $last = array();
   $currentTotal = 0;
   $lastTotal = 0;
   while ($x = mysqli_fetch_assoc($thisYrQ)) {
   	  $month = date("m",strtotime($x['txn_date']));
   	  if (!array_key_exists($month,$current)) {
   	  	$current[(int)$month] += $x['grand_total'];
   	  }else{
   	  	$current[(int)$month] += $x['grand_total'];
   	  }
   	  $currentTotal += $x['grand_total'];
   }
   while ($y = mysqli_fetch_assoc($lastYrQ)) {
   	  $month = date("m",strtotime($y['txn_date']));
   	  if (!array_key_exists($month, $last)) {//last or current in confusion
   	  	$last[(int)$month] += $y['grand_total'];
   	  }else{
   	  	$last[(int)$month] += $y['grand_total'];
   	  }
   	  $lastTotal += $y['grand_total'];
   }
 ?>
	<div class="col-md-4">
		<h3 class="text-center">Sales By Month</h3><?=date("m-d-Y m:i:s");?>
		<table class="table table-bordered table-striped table-condensed">
			<thead>
				<th></th>
				<th><?=$lastYr; ?></th>
				<th><?=$thisYr; ?></th>
			</thead>
			<tbody>
			<?php for($i = 1; $i <= 12; $i++):
			   $dt = DateTime::createFromFormat('!m',$i);
			   ?>
				<tr>
					<td><?=$dt->format("F"); ?></td>
					<td><?=(array_key_exists($i, $last))?money($last[$i]):money(0); ?></td>
					<td><?=(array_key_exists($i, $current))?money($current[$i]):money(0); ?></td>
				</tr>
			<?php endfor; ?>
			<tr>
				<td>Total</td>
				<td><?=money($lastTotal); ?></td>
				<td><?=money($currentTotal); ?></td>
			</tr>
			</tbody>
		</table>
	</div>
<!--Inventory-->
<?php
   $iQuery = $db->query("SELECT * from Products where deleted = 0");
   $lowItems = array();
   while ($product = mysqli_fetch_assoc($iQuery)) {
   	$item = array();
   	$sizes = sizesToArray($product['sizes']);
   	foreach ($sizes as $size) {
   		if ($size['quantity'] <= $size['threshold']) {
   			$cat = get_category($product['categories']);
   			$item = array(
                'title' => $product['title'],
                'size'  => $size['size'],
                'quantity' => $size['quantity'],
                'threshold' => $size['threshold'],
                'category' => $cat['parent'] . ' ~ '.$cat['child']
   				);
   			$lowItems[] = $item;
   		}
   	}
   }
   ?>
<div class="col-md-8">
	<h3 class="text-center">Low Inventory</h3>
	<table class="table table-condensed table-striped table-bordered">
		<thead>
			<th>Product</th>
			<th>Category</th>
			<th>Size</th>
			<th>Quantity</th>
			<th>Threshold</th>
		</thead>
		<tbody>
		<?php foreach ($lowItems as $item): ?>
			<tr<?=($item['quantity'] == 0)?' class="danger"':''; ?>>
				<td><?=$item['title']; ?></td>
				<td><?=$item['category']; ?></td>
				<td><?=$item['size']; ?></td>
				<td><?=$item['quantity']; ?></td>
				<td><?=$item['threshold']; ?></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
</div>
</div>
<?php
   include 'includes/footer.php';
?>
