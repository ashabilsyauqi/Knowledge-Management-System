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
    // Set zona waktu yang sesuai dengan zona waktu komputer pengguna
    date_default_timezone_set('Asia/Jakarta');
?>

    <div class="wrapper-heading container d-flex justidy-content-center align-items-center flex-column mb-5">
        <div class="card p-2 d-flex justify-content-center align-items-center" style="width:800px;">
        <?php $image = $_GET['image'];?>
        <img src="<?php echo get_template_directory_uri() . '/file/' . $image; ?>" style= width:100%;">
        </div>
    </div>
<?php
} 
?>
