<table class="table table-striped table-hover">
	<tbody>
		<?php foreach ( $kelas->first()->toArray() as $key => $value ): ?>
			<tr>
				<td> <?php echo ucfirst(implode( ' ', explode( '_', $key ) ));  ?></td>
				<td> <?php echo $value ?> </td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>