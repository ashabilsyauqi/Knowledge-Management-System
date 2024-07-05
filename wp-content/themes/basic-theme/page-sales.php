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


<div class="fullscreen taharica-bg">
    <div class="wrapper-heading container d-flex justidy-content-center align-items-start flex-column mb-5">
            <h1>
                <?php echo ucfirst(get_the_title());?>
            </h1>

            <!-- tombol create / upload -->
            <div class="d-flex justify-content-center align-items-center px-3" style="gap:20px;">
                <?php
                        $user = wp_get_current_user();
                        $current_user = wp_get_current_user();
                        $username = $current_user->user_login;
                        $role = $current_user->roles[0];  //untuk mengambil value role pada table user
                        // echo 'Hallo ' . ucfirst($username) . ' From ' . ucfirst($role) . '.';
                        
                        $home_url = home_url();
                        // echo $home_url;
                        
                        // Mendapatkan halaman saat ini
                        $current_page = $_SERVER['REQUEST_URI'];
                        
                        if ($role == "administrator") {
                            // Jika peran pengguna adalah "administrator", tampilkan tombol "Dashboard Administrator" di semua halaman
                            echo "<a href='$home_url/wp-admin/' class='border-white search-btn text-white'>Dashboard Administrator</a>";
                        } elseif ($role == "it" && strpos($current_page, "it") !== false) {
                            // Jika peran pengguna adalah "it" dan halaman yang dibuka adalah "it", tampilkan tautan "Create Post" untuk "it"
                            $page = "it";
                            echo "<a href='$home_url/wp-admin/post-new.php?post_type=$page' class='border-white search-btn text-white'>Create Post</a>";
                        } elseif ($role == "hrd" && strpos($current_page, "hrd") !== false) {
                            // Jika peran pengguna adalah "hrd" dan halaman yang dibuka adalah "hrd", tampilkan tautan "Create Post" untuk "hrd"
                            $page = "hrd";
                            echo "<a href='$home_url/wp-admin/post-new.php?post_type=$page' class='border-white search-btn text-white'>Create Post</a>";
                        } elseif ($role == "engineering" && strpos($current_page, "engineering") !== false) {
                            // Jika peran pengguna adalah "engineering" dan halaman yang dibuka adalah "engineering", tampilkan tautan "Create Post" untuk "engineering"
                            $page = "engineering";
                            echo "<a href='$home_url/wp-admin/post-new.php?post_type=$page' class='border-white search-btn text-white'>Create Post</a>";
                        } elseif ($role == "sales" && strpos($current_page, "sales") !== false) {
                            // Jika peran pengguna adalah "sales" dan halaman yang dibuka adalah "sales", tampilkan tautan "Create Post" untuk "sales"
                            $page = "sales";
                            echo "<a href='$home_url/wp-admin/post-new.php?post_type=$page' class='border-white search-btn text-white'>Create Post</a>";
                        } else {
                            // Tidak ada tautan
                            echo ""; 
                        }
                ?>
                <a href='<?php echo"$home_url/uploadfile"; ?>' class="border-white search-btn text-white">Upload Document</a>
            </div>    

    </div>
            
    <!-- catalog -->
    <section id="katalog" class="page wrapper d-flex justify-content-start align-items-start custom-bg-transparent flex-column" style="height:auto; gap:20px; padding:20px 280px;">
        <div class="d-flex justify-content-center align-items-center flex-row">
        <div class="row mb-4 p-2">
        <div class="col-6">
            <h3 class="mb-3 text-light">Katalog Produk</h3>
        </div>
        <div class="col-6 text-right">
            <a class="btn btn-light mb-3 mr-1" href="#carousel-katalog" role="button" data-slide="prev">
                <i class="fa fa-arrow-left"></i>
            </a>
            <a class="btn btn-light mb-3" href="#carousel-katalog" role="button" data-slide="next">
                <i class="fa fa-arrow-right"></i>
            </a>
            <!-- <a class="btn btn-warning mb-3 ml-1" href="#" target="_blank">More...</a> -->
        </div>

        <div class="col-12">
                    <div id="carousel-katalog" class="carousel slide" data-ride="carousel" data-interval="3000">
                        <div class="carousel-inner">
                            <?php
                            include 'koneksi_manual.php';
                            $query = "SELECT * FROM wp_file";
                            $result = $koneksi->query($query);
                            $idCounter = 1;

                            if ($result->num_rows > 0) {
                                $chunks = array_chunk($result->fetch_all(MYSQLI_ASSOC), 4); // Split data into chunks of 4 items per slide

                                foreach ($chunks as $index => $chunk) {
                                    echo '<div class="carousel-item ' . ($index === 0 ? 'active' : '') . '">';
                                    echo '<div class="row">';

                                    foreach ($chunk as $item) {
                                        $thumbnail = get_template_directory_uri() . '/thumbnail-katalog-sales/' . $item['thumbnail'];
                                        echo '<div class="col-md-3 mb-3">';
                                        echo '<a href="' . get_home_url() . '/pdfview?document_id=' . $item['id'] . '" target="_blank">';
                                        echo '<img style="width:240px; height:300px;" src="' . $thumbnail . '" alt="Card image" class="img-fluid card-img-top">';
                                        echo '</a>';
                                        echo '</div>';
                                    }

                                    echo '</div>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<p>No posts found</p>';
                            }

                            $koneksi->close();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </section>












    <!-- section article -->
    <section class="page mt-5">
                    <div class=" container-fluid text-light container ">
                        <!-- Konten yang dihilangkan hanya ketika bukan halaman login -->
                        <h1 class=" p-0 text-start m-text">Most View</h1>

                        <div class="mostview">
                            <?php
                                // Mendapatkan nama kategori dari halaman yang sedang ditampilkan
                                $current_page_slug = get_query_var('pagename');
                                $category_name = sanitize_title($current_page_slug);
                                $args02 = array(
                                    'post_type' => 'sales', // Replace 'your_custom_post_type' with your actual custom post type slug
                                    'posts_per_page' => 3, // To retrieve all posts, set this to -1
                                );

                                $popular_posts = new WP_Query($args02);
                                $post_count = 0; // Counter untuk menghitung jumlah postingan yang sudah dirender  
                                if ($popular_posts->have_posts()):
                                    while ($popular_posts->have_posts() && $post_count < 4): // Batasi hingga 4 postingan
                                        $popular_posts->the_post();
                                        ?>
                                        
                                            <div class="mostview-card">
                                                <a class="mostviewHome" href="<?php the_permalink(); ?>">
                                                    <?php if (has_post_thumbnail()) : ?>
                                                        <?php the_post_thumbnail('thumbnail', array('class' => 'img-fluid')); ?>
                                                    <?php else : ?>
                                                        <?php 
                                                            $image = get_field('post-image'); // Mengambil nilai gambar dari ACF
                                                            if ($image): // Memeriksa apakah ada gambar yang tersedia
                                                        ?>
                                                            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($image); ?>" class="img-fluid" />
                                                        <?php else: // Jika tidak ada gambar yang tersedia ?>
                                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/programmer.jpeg" alt="img" class="img-fluid" />
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    <p class="mostviewCaption text-center text-light">
                                                        <?php the_title(); ?>
                                                    </p>
                                                </a>
                                            </div>


                                        <?php
                                        $post_count++; // Tambahkan counter setiap kali sebuah postingan dirender
                                    endwhile;
                                endif;
                                wp_reset_postdata();
                                ?>
                        </div>

                        <br><br><br>

                    
                        <div class="container my-5 text-dark d-flex   custom-bg-transparent">
                            <?php
                            // WP_Query arguments
                            $args = array(
                                'post_type' => 'sales', // Replace 'your_custom_post_type' with your actual custom post type slug
                                'posts_per_page' => -1, // To retrieve all posts, set this to -1
                            );

                            // The Query
                            $query = new WP_Query($args);

                            // Initialize an array to store posts based on categories
                            $posts_by_category = array();

                            // The Loop
                            if ($query->have_posts()) {
                                while ($query->have_posts()) {
                                    $query->the_post();
                                    // Get the category for the current post
                                    $kategori = get_field('kategori');
                                    if ($kategori) {
                                        // Check if the category exists in the array, if not, create a new array key for it
                                        if (!isset($posts_by_category[$kategori])) {
                                            $posts_by_category[$kategori] = array();
                                        }
                                        // Store the current post in the array based on its category
                                        $posts_by_category[$kategori][] = $post;
                                    }
                                }

                                // Output posts by category
                                foreach ($posts_by_category as $kategori => $posts) {
                                    echo '<div class="row mb-4 p-2" >';
                                    echo '<div class="col-6">';
                                    echo '<h3 class="mb-3 text-light">' . esc_html($kategori) . '</h3>'; // Output the category as the section title
                                    echo '</div>';
                                    echo '<div class="col-6 text-right">';
                                    echo '<a class="btn btn-light mb-3 mr-1" href="#carousel-' . esc_attr($kategori) . '" role="button" data-slide="prev">';
                                    echo '<i class="fa fa-arrow-left"></i>';
                                    echo '</a>';
                                    echo '<a class="btn btn-light mb-3" href="#carousel-' . esc_attr($kategori) . '" role="button" data-slide="next">';
                                    echo '<i class="fa fa-arrow-right"></i>';
                                    echo '</a>';
                                    echo '<a class="btn btn-warning mb-3 ml-1" href="http://localhost/staging_eknowledge/categories/?kategori=' . esc_attr($kategori) . '" target="_blank" >More...</a>'; // Target URL based on category
                                    echo '</div>';

                                    echo '<div class="col-12">';
                                    echo '<div id="carousel-' . esc_attr($kategori) . '" class="carousel slide" data-ride="carousel">';
                                    echo '<div class="carousel-inner">';

                                    $chunks = array_chunk($posts, 3); // Split posts into chunks of 3
                                    foreach ($chunks as $index => $chunk) {
                                        echo '<div class="carousel-item ' . ($index === 0 ? 'active' : '') . '">';
                                        echo '<div class="row">';
                                        foreach ($chunk as $post) {
                                            setup_postdata($post);
                                            ?>
                                            <div class="col-md-4 mb-3">
                                            <a class="text-dark" href="<?php the_permalink(); ?>">
                                            <div class="card">
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
                                            <a>
                                            
                                            </div>
                                            <?php
                                        }
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<p>No posts found</p>';
                            }
                            /* Restore original Post Data */
                            wp_reset_postdata();
                            ?>
                        </div>




                        





                        <?php
                        if (have_posts()):
                            while (have_posts()):
                                the_post(); ?>
                                <?php //the_content(); ?>
                            <?php endwhile;
                        endif;
                        ?>
                    </div>
    </section>


</div>

    

    <?php get_footer();
} // Tutup blok kondisi 
?>



