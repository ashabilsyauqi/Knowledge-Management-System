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

}
?>

  
<section id="page" class="ukuran satu">
</section>
  
<section id="page" class="ukuran dua">
</section>
  
<section id="page" class="ukuran tiga">
</section>
  
<section id="page" class="ukuran empat">
</section>
  
<section id="page" class="ukuran lima">
</section>
  
<section id="page" class="ukuran enam">
</section>
  
<section id="page" class="ukuran tujuh">
</section>
  
<section id="page" class="ukuran delapan">
</section>

<section id="page" class="ukuran sembilan">
</section>

<section id="page" class="ukuran sepuluh">
</section>

<section id="page" class="ukuran sebelas">
</section>

<section id="page" class="ukuran duabelas">
</section>

<section id="page" class="ukuran tigabelas">
</section>

<section id="page" class="ukuran empatbelas">
</section>

<section id="page" class="ukuran limabelas">
</section>

<section id="page" class="ukuran enambelas">
</section>

<section id="page" class="ukuran tujuhbelas">
</section>

<section id="page" class="ukuran delapanbelas">
</section>

<section id="page" class="ukuran sembilanbelas">
</section>

<!-- <section id="page" class="ukuran daupuluh">
</section> -->

<!-- page 20 tidak ada ? -->

<section id="page" class="ukuran duasatu">
</section>

<section id="page" class="ukuran duatiga">
</section>

<section id="page" class="ukuran duaempat">
</section>

<section id="page" class="ukuran dualima">
</section>


