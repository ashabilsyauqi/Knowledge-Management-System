<?php get_header(); ?>

<?php 


include 'koneksi_manual.php';



    // Membuat koneksi
    $koneksi = new mysqli($host, $username, $password, $database);

    // Memeriksa apakah koneksi berhasil
    if ($koneksi->connect_error) {
        die("Koneksi gagal: " . $koneksi->connect_error);
    }


    $id_document = $_GET['document_id'];
    // echo "$id_document";


    $query = "SELECT nama_file FROM wp_file WHERE ID = $id_document";
                
    // Asumsikan Anda telah membuat koneksi ke database dan disimpan dalam variabel $conn
    $displayResult = mysqli_query($koneksi, $query);

    // Mengambil display_name
    $nama_file = '';
    if ($displayResult && $displayResult->num_rows > 0) {
        $displayRow = mysqli_fetch_assoc($displayResult);
        $nama_file = $displayRow['nama_file'];

       
    }

    // echo $nama_file;
    // echo $nama_file;
    // echo $nama_file;
    // echo $nama_file;
    // echo $nama_file;
    // echo $nama_file;
?>


<div class="wrapper-heading container d-flex justify-content-center align-items-center flex-column mb-5">
<iframe src="<?php echo get_template_directory_uri(); ?>/filedoc/<?php echo $nama_file; ?>" width="100%" height="1000px  ">
        This browser does not support PDFs. Please download the PDF to view it: <a href="<?php echo get_template_directory_uri(); ?>/filedoc/testing.pdf">Download PDF</a>
    </iframe>

    <!-- <iframe src="<?php echo get_template_directory_uri(); ?>/filedoc/testing.pdf" width="100%" height="600px">
        This browser does not support PDFs. Please download the PDF to view it: <a href="<?php echo get_template_directory_uri(); ?>/filedoc/testing.pdf">Download PDF</a>
    </iframe> -->
</div>

<?php get_footer(); ?>
