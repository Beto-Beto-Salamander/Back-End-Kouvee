<html>
<style>
	html {
		width: 100%;
	}
	.center {
		display: block;
		margin-left: auto;
		margin-right: auto;
		width: 100%;
	}

	h1 {
		text-align: center;
	}

	.column {
		flex: 50%;
	}
	table, th, td {
  		border: 1px solid black;
        border-collapse: collapse;
	}
    td.tableyth{
		border-collapse: collapse;
        border: dashed 0px #000;
        padding: 4px;
	}
</style>
<body>
<div class='center'> 
	<img src="http://kouvee.xyz/upload/kop.PNG"  style="width:100%">
	<hr>
	<h1>Nota Lunas</h1>
	<p style='text-align:right'><?php echo $tanggal ?></p>
	<p style='text-align:left'><?php echo $id ?></p>
	<?php foreach($produk as $list): ?>
		<div style='display:flex;'>
		<div class='column' style='text-align:left'>
			<p>Member&ensp;:<?php echo $list->NAMA_PELANGGAN ?></p>
			<p>Phone&ensp;:<?php echo $list->PHONE_PELANGGAN ?></p>
		</div>
		<div class='column' style='text-align:right'>
			<p>CS&ensp;:<?php echo $list->NAMA_CS ?></p>
			<p>Kasir&ensp;:<?php echo $list->NAMA_KASIR ?></p>
		</div>
	</div>
	<?php endforeach; ?>
	<h2 style='text-align:center'><?php echo $type ?></h2>
	<hr>
	<table  style='width: 100%'>
		<thead>
			<tr>
				<th >No</th>
				<th>Nama Produk</th>
				<th>Harga</th>
				<th>Jumlah</th>
				<th>Sub Total</th>
			</tr>
		</thead>
    	<?php $no=1; ?>
	  	<?php foreach($users as $list): ?>
		<tr>
			<td  style='text-align:center'><?php echo $no ?></td>
			<td  style='text-align:center' ><?php echo $list->NAMA_PRODUK ?></td>
			<?php $harga = "Rp " . number_format($list->HARGA_JUAL,2,',','.');?>
			<td  style='text-align:center'><?php echo $harga ?></td>
			<td  style='text-align:center'><?php echo $list->JUMLAH_PRODUK ?></td>
			<?php $sub = "Rp " . number_format($list->SUB_TOTAL_PRODUK,2,',','.');?>
			<td  style='text-align:center'><?php echo $sub ?></td>
    	</tr>
    	<?php $no++; ?>
	  	<?php endforeach; ?>
	</table>
<br>
<div class="center">
	<br>
	<hr>
	<?php foreach($produk as $list): ?>
		<div style='display:flex;'>
		<div class='column' style='text-align:right'>
		<?php $subt = "Rp " . number_format($list->SUBTOTAL_TRANSAKSI_PRODUK,2,',','.');?>
		<?php $disc = "Rp " . number_format($list->DISKON_PRODUK,2,',','.');?>
		<?php $total = "Rp " . number_format($list->TOTAL_TRANSAKSI_PRODUK,2,',','.');?>
		<p>Sub Total&ensp;:<?php echo $subt ?></p>
		<p>Diskon&ensp;:<?php echo $disc ?></p>
		<p>TOTAL&ensp;:<?php echo $total ?></p>
	    </div>
	<?php endforeach; ?>
</div>
</body>
</html>