<?php
// Periksa apakah URL saat ini adalah halaman login
if (strpos($_SERVER['REQUEST_URI'], '/login') !== false) {
    get_header('secondary');
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
    get_header('');

}
?>
<div class="container my-5 text-dark">
    <?php
    // Mengambil nilai kategori dari URL
    $kategori = isset($_GET['kategori']) ? sanitize_text_field($_GET['kategori']) : '';

    if ($kategori) {

        global $post;
        // WP_Query arguments
        $args = array(

            // fetch page slug ke variabel !!!!!!

            'post_type' => array('it', 'engineering', 'hrd', 'sales', 'hadist', 'other'), // Nilai-nilai post_type yang diinginkan
            'posts_per_page' => -1, // To retrieve all posts, set this to -1
            'meta_query' => array(
                array(
                    'key' => 'kategori',
                    'value' => $kategori,
                    'compare' => 'LIKE',
                ),
            ),
        );

        // The Query
        $query = new WP_Query($args);

        // The Loop
        if ($query->have_posts()) {
            echo '<div class="row mb-4 p-2">';
            echo '<div class="col-12">';
            echo '<h3 class="mb-3 text-light">' . esc_html($kategori) . '</h3>'; // Output the category as the section title
            echo '</div>';
            echo '<div class="col-12 d-flex flex-wrap">'; // Flexbox container

            while ($query->have_posts()) {
                $query->the_post();
                ?>
                <div class="col-md-4 mb-3 d-flex"> <!-- Flex item -->
                    <a class="text-dark w-100" href="<?php the_permalink(); ?>"> <!-- Full width link -->
                        <div class="card w-100"> <!-- Full width card -->
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium', array('class' => 'img-fluid card-img-top')); ?>
                            <?php else :
                                $image = get_field('post-image'); // Mengambil nilai gambar dari ACF
                                if ($image): // Memeriksa apakah ada gambar yang tersedia ?>
                                    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($image); ?>" class="img-fluid card-img-top" />
                                <?php else: // Jika tidak ada gambar yang tersedia ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/programmer.jpeg" alt="img" class="img-fluid card-img-top" />
                                <?php endif; ?>
                            <?php endif; ?>
                            <div class="card-body">
                                <h4 class="card-title"><?php
                                    // Mengambil judul post
                                    $title = get_the_title();
                                    
                                    // Memisahkan judul menjadi array berdasarkan spasi
                                    $words = explode(' ', $title);

                                    // Mengambil dua kata pertama
                                    $short_title = implode(' ', array_slice($words, 0, 2));

                                    // Menentukan apakah judul memiliki lebih dari dua kata
                                    $has_more_words = count($words) > 2;
                                
                                    echo esc_html($short_title . ($has_more_words ? '...' : '')); ?>
                                </h4>
                                <p class="card-text"><?php echo wp_trim_words(get_the_excerpt(), 8, '...'); ?></p>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
            }
            echo '</div>'; // Close flex container
            echo '</div>'; // Close row
        } else {
            echo '<p>No posts found</p>';
        }
        /* Restore original Post Data */
        wp_reset_postdata();
    } else {
        echo '<p>Please select a category</p>';
    }
    ?>
</div>





<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>