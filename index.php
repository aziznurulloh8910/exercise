<?php
  include 'koneksidb.php';
  include 'header.php';
?>


  <div class="card">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Silahkan Pilih Menu</h6>
    </div>
    <div class="row p-2 m-2">
      <div class="col-sm-6">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Laporan Bulanan</h5>
            <p class="card-text">Akan menampilkan laporan data penjualan Per Bulan Dalam Tahun</p>
            <a href="/exercise/perbulan.php?tahun=2003" class="btn btn-outline-primary">Lihat</a>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Laporan Mingguan</h5>
            <p class="card-text">Akan menampilkan laporan data penjualan Per Minggu Dalam Bulan</p>
            <a href="/exercise/perminggu.php?tahun=2005&bulan=1" class="btn btn-outline-primary">Lihat</a>
          </div>
        </div>
      </div>
    </div>
    <div class="row p-2 m-2">
      <div class="col-sm-6">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">10 Produk Terlaris</h5>
            <p class="card-text">Akan menampilkan laporan 10 data produk terlaris <strong>Per hari/tanggal</strong></p>
            <a href="/exercise/terlarisPerHari.php?tahun=2003&bulan=11&hari=13" class="btn btn-outline-primary">Lihat</a>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">10 Produk Terlaris</h5>
            <p class="card-text">Akan menampilkan laporan 10 data produk terlaris <strong>Per Bulan</strong></p>
            <a href="/exercise/terlarisPerBulan.php?tahun=2003&bulan=1" class="btn btn-outline-primary">Lihat</a>
          </div>
        </div>
      </div>
    </div>
    <div class="row p-2 m-2">
      <div class="col-sm-6">
          <div class="card shadow-sm">
            <div class="card-body">
              <h5 class="card-title">10 Customer Paling Konsumtif</h5>
              <p class="card-text">Akan menampilkan laporan 10 data customer paling konsumtif <strong>Per Tahun</strong></p>
              <a href="/exercise/customersKonsumtifPerTh.php?tahun=2003" class="btn btn-outline-primary">Lihat</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php include 'footer.php';?>