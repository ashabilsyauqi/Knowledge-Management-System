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
    <div class="wrapper-heading container d-flex justify-content-center align-items-center flex-column mb-5">
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
                    <div class="form-group col-md-12">
                        <label for="namaFile">Nama Document</label>
                        <input type="text" name="namaFIle" class="form-control">
                    </div>
                </div>     

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="form-label" for="thumbnail">Thumbnail</label>
                        <input class="form-control" id="formFileMultiple" name="thumbnail" multiple type="file"/>
                    </div>
                </div>  

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="form-label" for="dokumentasi">Dokumen</label>
                        <input class="form-control" id="formFileMultiple" name="dokumentasi" multiple type="file"/>
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
        if(isset($_FILES['dokumentasi']) && isset($_FILES['thumbnail'])) {
            // Mengambil nilai dari form
            $current_user = wp_get_current_user();
            $user_id = $current_user->ID;  // Menambahkan baris ini untuk mengambil ID pengguna
            
            $dokumentasi = $_FILES['dokumentasi'];
            $thumbnail = $_FILES['thumbnail'];
            $judulFile = $_POST['namaFIle'];
    
            // Upload file dokumentasi
            $namaFile = $_FILES['dokumentasi']['name'];
            $ukuranFile = $_FILES['dokumentasi']['size'];
            $tmpName = $_FILES['dokumentasi']['tmp_name'];
            $error = $_FILES['dokumentasi']['error'];
    
            // Cek apakah tidak ada file yang diupload
            if ($error === 4) {
                echo "<script>alert('Pilih file dokumentasi terlebih dahulu!');</script>";
                return false;
            }
    
            // Cek apakah yang diupload adalah file PDF
            $ekstensiFileValid = ['pdf'];
            $ekstensiFile = pathinfo($namaFile, PATHINFO_EXTENSION);
            $ekstensiFile = strtolower($ekstensiFile);
            if (!in_array($ekstensiFile, $ekstensiFileValid)) {
                echo "<script>alert('Yang anda upload bukan file PDF!');</script>";
                return false;
            }
    
            // Cek jika ukurannya terlalu besar
            if ($ukuranFile > 6000000) {
                echo "<script>alert('Ukuran file dokumentasi terlalu besar!');</script>";
                return false;
            }
    
            // Generate nama file baru
            $namaFileBaru = uniqid() . '.' . $ekstensiFile;
    
            // Sesuaikan path penyimpanan file dengan path yang Anda inginkan
            $path_simpan_dokumentasi = 'C:/xampp/htdocs/staging_eknowledge/wp-content/themes/basic-theme/filedoc/' . $namaFileBaru;
            if (!move_uploaded_file($tmpName, $path_simpan_dokumentasi)) {
                echo "Gagal menyimpan file dokumentasi.";
                exit; // Stop eksekusi script
            }

            // Upload file thumbnail
            $namaFileThumbnail = $_FILES['thumbnail']['name'];
            $ukuranFileThumbnail = $_FILES['thumbnail']['size'];
            $tmpNameThumbnail = $_FILES['thumbnail']['tmp_name'];
            $errorThumbnail = $_FILES['thumbnail']['error'];
    
            // Cek apakah tidak ada file yang diupload
            if ($errorThumbnail === 4) {
                echo "<script>alert('Pilih file thumbnail terlebih dahulu!');</script>";
                return false;
            }
    
            // Cek apakah yang diupload adalah file gambar (jpg)
            $ekstensiFileValidThumbnail = ['jpg', 'jpeg', 'png'];

            $ekstensiFileThumbnail = pathinfo($namaFileThumbnail, PATHINFO_EXTENSION);
            $ekstensiFileThumbnail = strtolower($ekstensiFileThumbnail);
            if (!in_array($ekstensiFileThumbnail, $ekstensiFileValidThumbnail)) {
                echo "<script>alert('Yang anda upload bukan file gambar (jpg)!');</script>";
                return false;
            }
    
            // Cek jika ukurannya terlalu besar
            if ($ukuranFileThumbnail > 6000000) {
                echo "<script>alert('Ukuran file thumbnail terlalu besar!');</script>";
                return false;
            }
    
            // Generate nama file baru
            $namaFileBaruThumbnail = uniqid() . '.' . $ekstensiFileThumbnail;

            // Sesuaikan path penyimpanan file dengan path yang Anda inginkan
            $path_simpan_thumbnail = 'C:/xampp/htdocs/staging_eknowledge/wp-content/themes/basic-theme/thumbnail-katalog-sales/' . $namaFileBaruThumbnail;
            if (!move_uploaded_file($tmpNameThumbnail, $path_simpan_thumbnail)) {
                echo "Gagal menyimpan file thumbnail.";
                exit; // Stop eksekusi script
            }
    
            // Lakukan operasi atau penyimpanan data lainnya sesuai kebutuhan Anda di sini
            // Contoh: menyimpan data ke database
            include 'koneksi_manual.php';
    
            // Query untuk menyimpan data izin ke dalam tabel wp_file
            $query = "INSERT INTO wp_file (nama_file, divisi, judul_file, id_user, thumbnail) 
                VALUES ('$namaFileBaru', '$role', '$judulFile', '$user_id', '$namaFileBaruThumbnail')";
    
            // Melakukan eksekusi query
            $result = $koneksi->query($query);
    
            // Jika query berhasil dieksekusi 
            if($result) {
                echo "<script>alert('Data berhasil disimpan!');</script>";
            } else {
                echo "Terjadi kesalahan saat menyimpan data document: " . $koneksi->error;
            }
    
            // Menutup koneksi
            $koneksi->close();
        } else {
            // Jika nilai form tidak diset, tampilkan pesan kesalahan
            echo "Form isian tidak lengkap.";
        }
    }
    ?>
<?php
}
?>
