<?php 
$koneksi = mysqli_connect("localhost","root","","akademik");

// cek koneksi
if(!$koneksi) {
  die("tidak terkoneksi");
}
$nim ="";
$nama="";
$alamat="";
$fakultas="";

$sukses ="";
$gagal = "";

// mengecek apakah ada data yang di ubah
if(isset($_GET["op"])){
  $op = $_GET["op"];
} else{
  $op = "";
}

// apabila tombol ubah di tekan
if($op == "edit") {
  $id = $_GET["id"];
  $query3 = "SELECT * FROM mahasiswa WHERE id ='$id'";
  $select = mysqli_query($koneksi,$query3);
  // menampilkan data yng di select
  $output2 = mysqli_fetch_assoc($select);
  $nim = $output2["nim"];
  $nama = $output2["nama"];
  $alamat = $output2["alamat"];
  $fakultas = $output2["fakultas"];
}
if($nim == "") {
  $gagal = "data tidak di temukan";
}

// apabila tombol submit telah di tekan
// maka ambil element2 yang ada di dalammnya
if(isset($_POST["simpan"])) {
  $nim = $_POST["nim"];
  $nama = $_POST["nama"];
  $alamat = $_POST["alamat"];
  $fakultas = $_POST["fakultas"];

  // dan apabila semua element telah terisi maka masukkan ke dalam database
  if($nim && $nama && $alamat && $fakultas) {
    // jika data sudah di edit dan selanjutnya di lakukan proses simpan data ke database
    if($op == "edit") {
      $query4 = "UPDATE mahasiswa SET nim = '$nim',nama = '$nama',alamat ='$alamat',fakultas ='$fakultas' WHERE id = '$id'";
      $update = mysqli_query($koneksi,$query4);
      // apabila data berhasil di update
      if($update){
        $sukses = "data berhasil di update";
      } else{
        $gagal = "data gagal di update";
      }
    } else {
      // jika op selain edit berarti akan di anggap memasukkan data
      $query1 = "INSERT INTO mahasiswa(nim,nama,alamat,fakultas) values('$nim','$nama','$alamat','$fakultas')";
      $inputdata = mysqli_query($koneksi,$query1);
  
      // cek apakah data sudah di input untuk menampilkan keterangan
      if($inputdata){
        $sukses = "data berhasil di tambahkan";
      } else{
        $gagal = "data gagal di tambahkan";
      }
    }
  } else{
    $gagal = "Silahkan masukkan data anda dengan lengkap";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">

  <style>
  .mx-auto {
    width: 75%;
  }

  .card {
    margin: 2rem 0;
  }
  </style>
</head>

<body>
  <div class="mx-auto">
    <!-- tempat memasukkan data -->
    <div class="card">
      <h5 class="card-header">Buat | Edit data</h5>
      <div class="card-body">
        <!-- apabila terjadi error -->
        <?php 
        if($gagal){
          ?>
        <div class="alert alert-danger">
          <?php 
            echo $gagal
            ?>
        </div>
        <?php
        }

        // apabila data berhasi di tambahkan
        if($sukses){
          ?>
        <div class="alert alert-success">
          <?php 
            echo $sukses
            ?>
        </div>
        <?php
        }
        ?>


        <form action="" method="POST">
          <!-- nim -->
          <div class="mb-3 row">
            <label for="nim" class="col-sm-2 col-form-label">NIM</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $nim ?>">
            </div>
          </div>
          <!-- nama -->
          <div class="mb-3 row">
            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
            </div>
          </div>
          <!-- alamat -->
          <div class="mb-3 row">
            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat ?>">
            </div>
          </div>
          <!-- fakultas -->
          <div class="mb-3 row">
            <label for="fakultas" class="col-sm-2 col-form-label">Fakultas</label>
            <div class="col-sm-10">
              <select name="fakultas" id="fakultas" class="form-control">
                <option value="">- Pilih Fakultas</option>
                <option value="Teknik Informatika" <?php if($fakultas == "Teknik Informatika") echo "Selected" ?>>Teknik
                  Informatika</option>
                <option value="Teknik Mesin" <?php if($fakultas == "Teknik Mesin") echo "Selected" ?>>Teknik Mesin
                </option>
                <option value="Sistem Informasi" <?php if($fakultas == "Sistem Informasi") echo "Selected" ?>>Sistem
                  Informasi</option>
              </select>
            </div>
          </div>

          <div class="col-12">
            <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
          </div>
        </form>
      </div>
    </div>

    <!-- tampilan output -->
    <div class="card">
      <h5 class="card-header text-white bg-secondary">Tampilan</h5>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">NIM</th>
              <th scope="col">Nama</th>
              <th scope="col">Alamat</th>
              <th scope="col">Fakultas</th>
              <th scope="col">Option</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            // menampilkan data yang sudah di input oleh user
            $query2 = "SELECT * FROM mahasiswa ORDER BY id DESC";
            $output = mysqli_query($koneksi,$query2);
            $idx = "";
            while($looping = mysqli_fetch_array($output)){
              $nim = $looping["nim"];
              $nama = $looping["nama"];
              $alamat = $looping["alamat"];
              $fakultas = $looping["fakultas"];
              ?>
            <tr>
              <th scope="row"><?php echo $idx++ ?></th>
              <th scope="row"><?php echo $nim ?></th>
              <th scope="row"><?php echo $nama ?></th>
              <th scope="row"><?php echo $alamat ?></th>
              <th scope="row"><?php echo $fakultas ?></th>
              <th scope="row">
                <a href="index.php?op=edit&id=<?php echo $idx ?>"><button class="btn btn-warning"
                    name="edit">Edit</button></a>
                <button class="btn btn-danger">Hapus</button>
              </th>
            </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>

</html>