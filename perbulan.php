<?php
include 'koneksidb.php';
include 'header.php';

if (isset($_GET)) {
  $tahun = $_GET["tahun"];
}

$data_perbulan = "SELECT MONTH(orders.orderDate) AS bulan, SUM(orderdetails.quantityOrdered * orderdetails.priceEach) AS penjualan FROM orders INNER JOIN orderdetails ON orders.orderNumber = orderdetails.orderNumber WHERE YEAR(orders.orderDate)=" . $tahun . " GROUP BY MONTH(orders.orderDate)";

$hasilPenjualan = $conn->query($data_perbulan);

$penjualan_label = "";
$penjualan_data = "";
?>

<center>
  <h4>Laporan Bulanan</h4>
</center>
<div class="card">
<form action="" method="get" class="pb-4 px-4">
<h5 class="p-2 mt-4">Silahkan Pilih Tahun</h5>
  <select class="form-select" name="tahun" aria-label="Default select example">
    <option selected value="2003">2003</option>
    <option value="2004">2004</option>
    <option value="2005">2005</option>
  </select>
  <div class="mt-2 d-grid gap-2 d-md-flex justify-content-md-end">
    <button class="btn btn-outline-primary btn-sm" type="submit">Submit</button>
  </div>
</form>
</div>

<div class="card shadow-sm p-2 mb-3 mt-4">
  <?php echo "<h5> Di bawah ini adalah data Tahun : " . $tahun . "</h5>" ?>
</div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Penjualan Per Bulan dalam Tahun</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>No.</th>
            <th>Bulan</th>
            <th>Penjualan</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($hasilPenjualan->num_rows > 0) { ?>
            <?php
            $no = 1;
            while ($row = $hasilPenjualan->fetch_assoc()) {
              $penjualan_label .= $row['bulan']. ",";
              $penjualan_data .= $row['penjualan']. ",";
            ?>
              <tr>
                <td><?php echo $no++?></td>
                <td><?php echo $row['bulan'] ?></td>
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

<!-- Area Chart -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Area Chart</h6>
  </div>
  <div class="card-body">
    <div class="chart-area">
      <canvas id="chart-pertahun"></canvas>
    </div>
    <hr>
    Styling for the area chart can be found in the
    <code>/js/demo/chart-area-demo.js</code> file.
  </div>
</div>

<?php include('../exercise/script.php'); ?>
<script>
  $('.table').DataTable();
  const Bulanan = document.getElementById('chart-pertahun');
  new Chart(Bulanan, {
    type: 'line',
    data: {
      labels: ["Jan","Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      datasets: [{
        label: '# Data Penjualan',
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