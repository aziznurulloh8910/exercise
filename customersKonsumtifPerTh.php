<?php
include 'koneksidb.php';
include 'header.php';

if (isset($_GET)) {
  $tahun = $_GET["tahun"];
}

$data_konsumsi = "SELECT customers.customerName AS nama, SUM(orderdetails.quantityOrdered * orderdetails.priceEach) AS penjualan
FROM orderdetails
INNER JOIN orders ON orders.orderNumber = orderdetails.orderNumber
INNER JOIN customers ON customers.customerNumber = orders.customerNumber
WHERE YEAR(orders.orderDate) = ".$tahun."
GROUP BY customers.customerName
ORDER BY penjualan DESC
LIMIT 10";

$hasilPenjualan = $conn->query($data_konsumsi);

$penjualan_label = "";
$penjualan_data = "";
?>

<center>
  <h4>Peringkat 10 Customer paling Konsumtif of the YEAR</h4>
</center>

<div class="card">
<form action="" method="get" class="pb-4 px-4 ">
<h5 class="p-2 mt-4">Silahkan Pilih Tahun dan Bulan</h5>
  <select class="form-select" name="tahun" aria-label="Default select example">
    <option value="2003">2003</option>
    <option value="2004">2004</option>
    <option value="2005">2005</option>
  </select>
  <div class="mt-2 d-grid gap-2 d-md-flex justify-content-md-end">
    <button class="btn btn-outline-primary btn-sm" type="submit">Submit</button>
  </div>
</form>
</div>

<div class="card shadow-sm p-2 mb-3 mt-4">
  <?php echo "<h5>Di bawah ini adalah data Tahun : ".$tahun." </h5>" ?>
</div>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">10 Customer Paling Konsumtif PerTahun</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>No.</th>
            <th>Nama Customer</th>
            <th>Total Pembelian</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($hasilPenjualan->num_rows > 0) { ?>
            <?php
            $no = 1;
            while ($row = $hasilPenjualan->fetch_assoc()) {
              $penjualan_label .= $row['nama']. ",";
              $penjualan_data .= $row['penjualan']. ",";
            ?>
              <tr>
                <td><?php echo $no++?></td>
                <td><?php echo $row['nama']?></td>
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
      <canvas id="chart-konsumtif-perBulan"></canvas>
    </div>
    <hr>
    Styling for the bar chart can be found in the
    <code>/js/demo/chart-bar-demo.js</code> file.
  </div>
</div>

<?php include('../exercise/script.php'); ?>
<script>
  $('.table').DataTable();
  const konsumtifPerBulan = document.getElementById('chart-konsumtif-perBulan');
  new Chart(konsumtifPerBulan, {
    type: 'bar',
    data: {
      labels: ["1","2","3","4","5","6","7","8","9","10"],
      datasets: [{
        label: '# Data Penjualan konsumtif',
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