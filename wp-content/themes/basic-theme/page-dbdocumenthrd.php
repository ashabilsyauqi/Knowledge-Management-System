
<?php get_header(); ?>

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
                // Sertakan file koneksi database
                include 'koneksi_manual.php';

                // Query untuk mengambil data dari tabel wp_file dengan divisi "IT"
                $query = "SELECT * FROM wp_file WHERE divisi = 'hrd'";

                // Melakukan eksekusi query
                $result = $koneksi->query($query);

                // Memeriksa apakah query mengembalikan hasil
                if ($result->num_rows > 0) {
                    // Inisialisasi counter ID
                    $idCounter = 1;
                    while ($row = $result->fetch_assoc()) {
                        $user_name = $row['id_user'];
                        $query_user = "SELECT display_name FROM wp_users WHERE ID = $user_name";

                        // Melakukan query untuk mendapatkan display_name dari wp_users
                        $displayResult = mysqli_query($koneksi, $query_user);

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
                        echo '<td><a href="' . get_home_url() . '/pdfview?document_id=' . $row['id  '] . '" class="btn btn-primary" target="_blank">Open File</a></td>';
                        echo '</tr>';

                        // Increment counter ID
                        $idCounter++;
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada data ditemukan.</td></tr>";
                }

                // Menutup koneksi
                $koneksi->close();
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php get_footer(); ?>

<script>
    // Fungsi untuk menutup alert setelah beberapa detik
    setTimeout(function() {
        var userAlert = document.getElementById('data-submited');
        if (userAlert !== null) {
            userAlert.remove();
        }
    }, 3000); // 3000 milidetik = 3 detik
</script>
