<?php get_header('secondary') ?>
<div class="wrapper-heading container d-flex justify-content-center align-items-center flex-column mb-5">
    <div class="table-responsive">
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Divisi</th>
                    <th scope="col">Mulai Izin</th>
                    <th scope="col">Akhir Izin</th>
                    <!-- <th scope="col">Lama Izin</th> -->
                    <th scope="col">Alasan Cuti</th>
                    <th scope="col">Dokumentasi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                       include 'koneksi_manual.php';



                // Membuat koneksi
                $koneksi = new mysqli($host, $username, $password, $database);

                // Memeriksa apakah koneksi berhasil
                if ($koneksi->connect_error) {
                    die("Koneksi gagal: " . $koneksi->connect_error);
                }

                // Query untuk mengambil data dari tabel wp_cuti
                $query = "SELECT * FROM wp_izin";

                // Melakukan eksekusi query
                $result = $koneksi->query($query);

                // Memeriksa apakah query mengembalikan hasil
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<th scope="row">' . $row['id'] . '</th>';
                        echo '<td>' . $row['nama_karyawan'] . '</td>';
                        echo '<td>' . $row['divisi'] . '</td>';
                        echo '<td>' . date('d-m-Y', strtotime($row['mulai_izin'])) . '</td>';
                        echo '<td>' . date('d-m-Y', strtotime($row['akhir_izin'])) . '</td>';
                        // echo '<td>' . $row['jumlah_hari'] . '  Hari' . '</td>';
                        echo '<td>' . $row['alasan_izin'] . '</td>';
                        // echo '<td>' . $row['dokumentasi'] . '</td>';
                        echo '<td><a href="'.$home_url.'/image?image=' . $row['dokumentasi'] . '" class="btn btn-light"> Documentation </a></td>';
                        // echo '<td><img src="' . get_template_directory_uri() . '/file/' . $row['dokumentasi'] . '" style="height:200px; width:200px;"></td>';
                        echo '</tr>';
                        // echo " <div class='d-flex justify-content-center align-items-center'>
                        //             <div id='data-submited' class='alert alert-success alert-dismissible fade show' style='width:50%;'>Upload Success</div>
                        //         </div>"
                    }
                } else {
                    echo "Tidak ada data ditemukan.";
                }

                // Menutup koneksi
                $koneksi->close();
                ?>

            </tbody>
        </table>

    </div>
</div>

<?php
// Memeriksa apakah ada data baru yang gagal disubmit
// if (isset($_GET['submit']) && $_GET['submit'] === 'failed') {
//     echo "
//    ";
// }
?>

<?php get_footer() ?>

<script>
    // Fungsi untuk menutup alert setelah beberapa detik
    setTimeout(function() {
        var userAlert = document.getElementById('data-submited');
        if (userAlert !== null) {
            userAlert.remove();
        }
    }, 3000); // 3000 milidetik = 3 detik
</script>
