<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<h2>LAPORAM PEMBAYARAN SPP</h2>

<table>
  <tr>
    <th> Nama Siswa </th>
    <th> Nama Tagihan </th>
    <th> Tahun Ajaran </th>
    <th> Bulan </th>
    <th> Kelas </th>
    <th> Status Transaksi </th>
    <th> Jumlah Tagihan </th>
  </tr>
 <?php foreach ($transaksi as $key => $value):
    $total_tagihan[]= $value['total_tagihan'];
  ?>
   <tr>
      <td> <?php echo $value['nama_lengkap'] ?> </td>
      <td> <?php echo $value['nama_tagihan'] ?> </td>
      <td> <?php echo $value['tahun_ajaran'] ?> </td>
      <td> <?php echo $value['bulan'] ?> </td>
      <td> <?php echo get_kelas($value['kelas_id']) ?> </td>
      <td> <?php echo $value['status_transaksi'] ?> </td>
      <td> <?php echo rupiah($value['total_tagihan']) ?> </td>
    </tr>
 <?php endforeach ?>
 <tfoot>
   <tr>
     <th></th>
     <th></th>
     <th></th>
     <th></th>
     <th></th>
     <th>TOTAL TAGIHAN MASUK</th>
     <th> <?php echo rupiah( array_sum( $total_tagihan ) ) ?> </th>
   </tr>
 </tfoot>
</table>

</body>
</html>
