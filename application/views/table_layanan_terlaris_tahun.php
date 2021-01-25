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
	table{
      border-collapse: collapse;
      font-family: arial;
    }
</style>
<body>
<div class='center'> 
	<img src="http://kouvee.xyz/upload/kop.PNG"  style="width:100%">
	<hr>
	<h1>LAPORAN LAYANAN TERLARIS</h1>
	<div>Tahun : <?php echo $year ?></div>
	<table  style='width: 100%'>
		<thead>
			<tr>
				<th >No</th>
				<th>Bulan</th>
				<th>Nama Layanan</th>
				<th>Jumlah Penjualan</th>
			</tr>
		</thead>
    	<?php $no=1; ?>
	  	<?php foreach($layanan as $list): ?>
		<tr>
			<td  style='text-align:center'><?php echo $no ?></td>
			<td  style='text-align:center' ><?php echo $list['BULAN'] ?></td>
			<td  style='text-align:center'><?php echo $list['NAMA LAYANAN'] ?></td>
			<td  style='text-align:center'><?php echo $list['JUMLAH PENJUALAN'] ?></td>
    	</tr>
    	<?php $no++; ?>
	  	<?php endforeach; ?>
	</table>
	
	<br>
	<hr>
	<div style='display:flex;'>
		<div class='column'>
			Dicetak tanggal <?php echo $tanggal ?>
		</div>
	</div>
	
</div>
</body>
</html>