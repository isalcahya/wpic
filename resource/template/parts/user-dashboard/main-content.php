<!-- Page content -->
<div class="container-fluid pt-3">
  <h3> Selamat Datang !</h3>
  <br/>
  <table class="table table-striped table-hover">
  	<thead>
  		<tr>
  			<th colspan="2" style="text-align: center;"> Informasi Data Siswa </th>
  		</tr>
  	</thead>
  	<tbody>
  		<?php foreach ( $siswa as $key => $value ): ?>
			<tr>
				<td style="text-align: center;"> <?php echo ucfirst(implode( ' ', explode( '_', $key ) ));  ?></td>
				<td style="text-align: center;"> <?php echo $value ?> </td>
			</tr>
		<?php endforeach ?>
  	</tbody>
  </table>
</div>