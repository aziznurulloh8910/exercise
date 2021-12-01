<?php
include 'koneksidb.php';
include 'header.php';

if (isset($_GET)) {
  $tahun = $_GET["tahun"];
  $bulan = $_GET["bulan"];
  $hari = $_GET["hari"];
}

$data_terlaris = "SELECT products.productName AS produk, SUM(orderdetails.quantityOrdered * orderdetails.priceEach) AS penjualan
FROM orders
INNER JOIN orderdetails ON orderdetails.orderNumber = orders.orderNumber
INNER JOIN products ON products.productCode = orderdetails.productCode
WHERE YEAR(orders.orderDate) = ".$tahun." AND MONTH(orders.orderDate) = ".$bulan." AND DAY(orders.orderDate) = ".$hari."
GROUP BY orderdetails.productCode
ORDER BY penjualan DESC
LIMIT 10";

$hasilPenjualan = $conn->query($data_terlaris);

$penjualan_label = "";
$penjualan_data = "";
?>

<center>
  <h4>Laporan 10 Produk Terlaris</h4>
</center>
<div class="card">
<form action="" method="get" class="pb-4 px-4 ">
<h5 class="p-2 mt-4">Silahkan Pilih Tahun, Bulan dan Tanggal</h5>
  <div class="row">
    <div class="col">
      <select class="form-select" name="tahun" aria-label="Default select example">
        <option value="2003">2003</option>
        <option value="2004">2004</option>
        <option value="2005">2005</option>
      </select>
    </div>
    <div class="col">
      <select class="form-select" name="bulan" aria-label="Default select example">
        <option value="1">Januari</option>
        <option value="2">Februari</option>
        <option value="3">Maret</option>
        <option value="4">April</option>
        <option value="5">Mei</option>
        <option value="6">Juni</option>
        <option value="7">Juli</option>
        <option value="8">Agustus</option>
        <option value="9">September</option>
        <option value="10">Oktober</option>
        <option value="11">November</option>
        <option value="12">Desember</option>
      </select>
    </div>
    <div class="col">
      <select class="form-select" name="hari" aria-label="Default select example">
        <?php for($i=1; $i<=31; $i++) {?>
        <option value="<?php echo $i ?>"><?php echo $i ?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="mt-2 d-grid gap-2 d-md-flex justify-content-md-end">
    <button class="btn btn-outline-primary btn-sm" type="submit">Submit</button>
  </div>
</form>
</div>

<div class="card shadow-sm p-2 mb-3 mt-4">
  <?php echo "<h5> Tanggal: " . $hari . "/".$bulan."/".$tahun." </h5>" ?>
</div>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">10 Produk Terlaris PerTanggal</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>No.</th>
            <th>Produk</th>
            <th>Penjualan</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($hasilPenjualan->num_rows > 0) { ?>
            <?php
            $no = 1;
            while ($row = $hasilPenjualan->fetch_assoc()) {
              $penjualan_label .= $row['produk']. ",";
              $penjualan_data .= $row['penjualan']. ",";
            ?>
              <tr>
                <td><?php echo $no++?></td>
                <td><?php echo $row['produk']?></td>
                <td><?php echo $row['penjualan'] ?></td>
              </tr>
            <?php } ?>
          <?php } else { ?>
            <tr>
              <td colspan="2">Data Tidak Ada</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Bar Chart -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Bar Chart</h6>
  </div>
  <div class="card-body">
    <div class="chart-bar">
      <canvas id="chart-terlaris-perhari"></canvas>
    </div>
    <hr>
    Styling for the bar chart can be found in the
    <code>/js/demo/chart-bar-demo.js</code> file.
  </div>
</div>

<?php include('../exercise/script.php'); ?>
<script>
  $('.table').DataTable();
  const terlarisPerHari = document.getElementById('chart-terlaris-perhari');
  new Chart(terlarisPerHari, {
    type: 'bar',
    data: {
      labels: ["1","2","3","4","5","6","7","8","9","10"],
      datasets: [{
        label: '# Data Penjualan Terlaris',
        data: [<?php echo rtrim($penjualan_data, ',') ?>],
        backgroundColor: [
          'rgb(30, 144, 255)'
        ],
        borderColor: [
          '	rgb(25, 25, 112)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

</script>





<center><a href="index.php" class="btn btn-outline-primary btn-sm m-4"> << Kembali >> </a></center>

<?php include 'footer.php';