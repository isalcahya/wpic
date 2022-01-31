<br/>
<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th colspan="2">
				<h3>Detail Pembayaran</h3>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ( $midtrans as $key => $value ): ?>
			<tr>
				<td> <?php echo ucfirst(implode( ' ', explode( '_', $key ) ));  ?></td>
				<td> <?php echo strtoupper($value) ?> </td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<br/>
<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th colspan="2">
				<h3>Detail Item Tagihan</h3>
			</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ( $tagihan as $key => $value ): ?>
			<tr>
				<td> <?php echo ucfirst(implode( ' ', explode( '_', $key ) ));  ?></td>
				<td> <?php echo $value ?> </td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>