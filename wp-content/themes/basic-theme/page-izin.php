<?php
// Periksa apakah URL saat ini adalah halaman login
if (strpos($_SERVER['REQUEST_URI'], '/login') !== false) {
    get_header('header');
    // Jika URL adalah halaman login, maka hanya menampilkan konten yang sesuai
    if (have_posts()):
        while (have_posts()):
            the_post();
            the_content();
        endwhile;
    else:
        // Jika tidak ada konten yang ditemukan
        echo "No content found.";
    endif;  
} else {
    // Jika URL bukan halaman login, tampilkan konten lengkap
    get_header('secondary');
?>
    <div class="wrapper-heading container d-flex justidy-content-center align-items-center flex-column mb-5">
        <div class="card p-5" style="width:800px;">
        <form class="text-dark" method="POST" enctype="multipart/form-data">
            <!-- <h1><?php echo date("Y-d-m H:i:s");?></h1> -->
                <div class="form-row">
                    <?php 
                        $current_user = wp_get_current_user();
                        $namaKaryawan = $current_user->user_login;
                        $role = $current_user->roles[0];    
                        $user_email = $current_user->user_email;   
                        $sisaCuti =  $current_user->sisaCuti;                
                    ?>
                    <div class="form-group col-md-4">
                        <label for="namaKaryawan">Nama Karyawan</label>
                        <p class='form-control' style='font-weight:500;'><?php echo $namaKaryawan; ?></p>
                        <input type="hidden" name="namaKaryawan" value="<?php echo $namaKaryawan; ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="user_email">Email Karyawan</label>
                        <p class='form-control' style='font-weight:500;'><?php echo $user_email; ?></p>
                        <input type="hidden" name="user_email" value="<?php echo $user_email; ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="divisi">Divisi</label>
                        <p class='form-control' style='font-weight:500;'><?php echo $role; ?></p>
                        <input type="hidden" name="divisi" value="<?php echo $role; ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12">
                        <label class="control-label " for="nomorTelpon">Nomor Telpon</label>
                        <input type="number" name="nomorTelpon" class="form-control mb-2">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="control-label" for="mulaiIzin">Tanggal Mulai</label>
                        <input class="form-control" id="mulaiIzin" name="mulaiIzin" type="date"/>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label" for="akhirIzin">Tanggal Berakhir</label>
                        <input class="form-control" id="akhirIzin" name="akhirIzin" type="date"/>
                    </div>
                </div>

                <p id="selisih-tanggal"></p>
                
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="control-label" for="dokumentasi">Dokumen</label>
                        <input class="form-control" id="dokumentasi" name="dokumentasi" type="file"/>
                    </div>
                </div>     

                <div class="form-row mb-3">
                    <div class="col-md-12">
                        <label class="control-label" for="alasanIzin">Alasan Izin</label>
                        <select name="alasanIzin" class="form-control" id='alasanIzin'>
                            <option value="sakit">Sakit</option>
                            <option value="keluargaMeninggal">Keluarga Meninggal</option>
                            <option value="kecelakaan">Kecelakaan / Cidera</option>
                            <option value="janjiMedis">Janji Medis</option>
                        </select>
                    </div>
                </div>                
                <button type="submit" class="btn btn-primary mt-3" name="submit" id="submitButton">Submit</button>
            </form>
        </div>
    </div>

    <?php
    // Memeriksa apakah form telah disubmit
    if(isset($_POST['submit'])) {
        // Memeriksa apakah nilai-nilai form telah diset
        if(isset($_POST['namaKaryawan'], $_POST['divisi'], $_POST['nomorTelpon'], $_POST['mulaiIzin'], $_POST['akhirIzin'], $_POST['alasanIzin']) && isset($_FILES['dokumentasi'])) {
            // Mengambil nilai dari form
            $namaKaryawan = $_POST['namaKaryawan'];
            $divisi = $_POST['divisi'];
            $nomorTelpon = $_POST['nomorTelpon'];
            $mulaiIzin = $_POST['mulaiIzin'];
            $akhirIzin = $_POST['akhirIzin'];
            $alasanIzin = $_POST['alasanIzin'];
            $dokumentasi = $_FILES['dokumentasi'];

            // Upload gambar
            $namaFile = $_FILES['dokumentasi']['name'];
            $ukuranFile = $_FILES['dokumentasi']['size'];
            $tmpName = $_FILES['dokumentasi']['tmp_name'];
            $error = $_FILES['dokumentasi']['error'];

            // Cek apakah tidak ada gambar yang diupload
            if ($error === 4) {
                echo "<script>alert('Pilih gambar terlebih dahulu!');</script>";
                return false;
            }

            // Cek apakah yang diupload adalah gambar
            $ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'gif'];
            $ekstensiGambar = pathinfo($namaFile, PATHINFO_EXTENSION);
            $ekstensiGambar = strtolower($ekstensiGambar);
            if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
                echo "<script>alert('Yang anda upload bukan gambar!');</script>";
                return false;
            }

            // Cek jika ukurannya terlalu besar
            if ($ukuranFile > 1000000) {
                echo "<script>alert('Ukuran gambar terlalu besar!');</script>";
                return false;
            }

            // Generate nama gambar baru
            $namaFileBaru = uniqid() . '.' . $ekstensiGambar;

            // Sesuaikan path penyimpanan file dengan path yang Anda inginkan
            $path_simpan = 'C:/xampp/htdocs/staging_eknowledge/wp-content/themes/basic-theme/file/' . $namaFileBaru;
            if (!move_uploaded_file($tmpName, $path_simpan)) {
                echo "Gagal menyimpan gambar.";
                exit; // Stop eksekusi script
            }

            // Menghitung jumlah hari izin
            $selisihWaktu = abs(strtotime($akhirIzin) - strtotime($mulaiIzin));
            $selisihHari = ceil($selisihWaktu / (60 * 60 * 24) - 1);
            
            // Lakukan operasi atau penyimpanan data lainnya sesuai kebutuhan Anda di sini
            // Contoh: menyimpan data ke database

            include 'koneksi_manual.php';


            // Query untuk menyimpan data izin ke dalam tabel wp_izin
            $query = "INSERT INTO wp_izin (nama_karyawan, divisi, nomor_telpon, mulai_izin, akhir_izin, alasan_izin, dokumentasi) 
                    VALUES ('$namaKaryawan', '$divisi', '$nomorTelpon', '$mulaiIzin', '$akhirIzin', '$alasanIzin', '$namaFileBaru')";

            // Melakukan eksekusi query
            $result = $koneksi->query($query);

            // Jika query berhasil dieksekusi 
            if($result) {
                echo "<div id='data-submited'>Data berhasil di submit</div>";
            } else {
                echo "Terjadi kesalahan saat menyimpan data izin: " . $koneksi->error;
            }

            // Menutup koneksi
            $koneksi->close();
        } else {
            // Jika nilai form tidak diset, tampilkan pesan kesalahan
            echo "Form isian tidak lengkap.";
        }
    }
    ?>

<script>
    const alasanIzin = document.getElementById('alasanIzin');
    const tanggalMulai = document.getElementById('mulaiIzin');
    const tanggalAkhir = document.getElementById('akhirIzin');
    const selisihTanggalElemen = document.getElementById('selisih-tanggal');

    function hitungSelisihHari() {
        // Ambil nilai tanggal dari elemen input
        const tanggalMulaiValue = new Date(tanggalMulai.value);
        const tanggalAkhirValue = new Date(tanggalAkhir.value);

        // Validasi apakah kedua tanggal telah dipilih
        if (isNaN(tanggalMulaiValue) || isNaN(tanggalAkhirValue)) {
            // Jika salah satu atau kedua tanggal tidak valid, kosongkan elemen <p>
            selisihTanggalElemen.textContent = "";
            return;
        }

        // Hitung selisih waktu dalam milidetik antara dua tanggal
        const selisihWaktu = Math.abs(tanggalAkhirValue - tanggalMulaiValue + 1);

        // Hitung jumlah hari dalam selisih waktu
        const selisihHari = Math.ceil(selisihWaktu / (1000 * 60 * 60 * 24));

        // Tampilkan hasilnya di elemen <p>
        selisihTanggalElemen.textContent = "Lama Izin : " + selisihHari + " Hari";
    }

    // Panggil fungsi hitungSelisihHari() saat nilai input berubah
    tanggalMulai.addEventListener('change', hitungSelisihHari);
    tanggalAkhir.addEventListener('change', hitungSelisihHari);

    // Fungsi untuk menutup alert setelah beberapa detik
    setTimeout(function() {
        var userAlert = document.getElementById('data-submited');
        if (userAlert !== null) {
            userAlert.remove();
        }
    }, 3000); // 3000 milidetik = 3 detik
</script>

<?php
}
?>
