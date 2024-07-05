<?php get_header();?>

<div class="wrapper-heading container d-flex justify-content-center align-items-center flex-column mb-5">
    <div class="table-responsive">
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Nama Document</th>
                    <th scope="col">Divisi</th>
                    <th scope="col">Uploaded by</th>
                    <th scope="col">Download</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Informasi koneksi ke database
                // $host = 'localhost'; // Sesuaikan dengan host database Anda
                // $username = 'ashabil1'; // Sesuaikan dengan username database Anda
                // $password = 'taharica2024'; // Sesuaikan dengan password database Anda
                // $database = 'staging_eknowledge_2'; // Sesuaikan dengan nama database Anda



                // // untuk production pakai kode yang dibawah
                // // $host = 'localhost'; // Sesuaikan dengan host database Anda
                // // $username = 't1aharicacoid_eknowlegde'; // Sesuaikan dengan username database Anda
                // // $password = 'shalatku17'; // Sesuaikan dengan password database Anda
                // // $database = 't1aharicacoid_eknowlegde'; // Sesuaikan dengan nama database Anda


                // // Membuat koneksi
                // $koneksi = new mysqli($host, $username, $password, $database);

                // // Memeriksa apakah koneksi berhasil
                // if ($koneksi->connect_error) {
                //     die("Koneksi gagal: " . $koneksi->connect_error);
                // }

                include 'koneksi_manual.php';

                // Query untuk mengambil data dari tabel wp_cuti
                $query = "SELECT * FROM wp_file";

                // Melakukan eksekusi query
                $result = $koneksi->query($query);

                // Memeriksa apakah query mengembalikan hasil
                
                
              
                if ($result->num_rows > 0) {
                    // Inisialisasi counter ID
                    $idCounter = 1;
                    while ($row = $result->fetch_assoc()) {
                        $user_name = $row['id_user'];
                        $query = "SELECT display_name FROM wp_users WHERE ID = $user_name";
                
                        // Asumsikan Anda telah membuat koneksi ke database dan disimpan dalam variabel $conn
                        $displayResult = mysqli_query($koneksi, $query);
                
                        // Mengambil display_name
                        $display_name = '';
                        if ($displayResult && $displayResult->num_rows > 0) {
                            $displayRow = mysqli_fetch_assoc($displayResult);
                            $display_name = $displayRow['display_name'];
                        }
                
                        echo '<tr>';
                        // Menggunakan counter ID
                        echo '<th scope="row">' . $idCounter . '</th>';
                        echo '<td>' . $row['judul_file'] . '</td>';
                        echo '<td>' . $row['divisi'] . '</td>';
                        echo '<td>' . $display_name . '</td>';
                         echo '<td><a href="' . $home_url . '/pdfview?document_id=' . $row['id'] . '" class="btn btn-primary" target="_blank">Open File</a></td>'; // Perbaiki link dengan ID dokumen
                        echo '</tr>';
                
                        // Increment counter ID
                        $idCounter++;
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
