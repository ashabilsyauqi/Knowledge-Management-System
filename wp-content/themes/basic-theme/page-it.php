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
    <div class="wrapper-heading container d-flex justidy-content-center align-items-start flex-column mb-5">
        <h1>
            <?php echo ucfirst(get_the_title());?>
        </h1>

        <?php
            $current_user = wp_get_current_user();
            $username = $current_user->user_login;
            $role = $current_user->roles[0];  //untuk mengambil value role pada table user
            $home_url = home_url();
            $current_page = $_SERVER['REQUEST_URI'];
            
            if ($role == "administrator") {
                echo "<a href='$home_url/wp-admin/' class='border-white search-btn text-white'>Dashboard Administrator</a>";
            } elseif ($role == "it" && strpos($current_page, "it") !== false) {
                $page = "it";
                echo "<a href='$home_url/wp-admin/post-new.php?post_type=$page' class='border-white search-btn text-white'>Create Post</a>";
            } elseif ($role == "hrd" && strpos($current_page, "hrd") !== false) {
                $page = "hrd";
                echo "<div class='d-flex justify-content-center align-items-center' style='gap:20px;'>";
                echo "<a href='$home_url/wp-admin/post-new.php?post_type=$page' class='border-white search-btn text-white' style='width:auto; padding: 20px 30px ;'>Create Post</a>";
                echo "<a href='$home_url/dbcuti' class='border-white search-btn text-white' style='width:auto; padding: 20px 30px ;'>List Pengajuan Cuti</a>";
                echo "</div>";
            } elseif ($role == "engineering" && strpos($current_page, "engineering") !== false) {
                $page = "engineering";
                echo "<a href='$home_url/wp-admin/post-new.php?post_type=$page' class='border-white search-btn text-white'>Create Post</a>";
            } elseif ($role == "sales" && strpos($current_page, "sales") !== false) {
                $page = "sales";
                echo "<a href='$home_url/wp-admin/post-new.php?post_type=$page' class='border-white search-btn text-white'>Create Post</a>";
            } else {
                echo ""; 
            }
        ?>
    </div>
    
    <section class="page">
        <div class="container-fluid text-light container">
            <h1 class="p-0 text-start m-text">Most View</h1>

            <div class="mostview">
                <?php
                $current_page_slug = get_query_var('pagename');
                $category_name = sanitize_title($current_page_slug);
                $args02 = array(
                    'post_type' => $current_page_slug, // Replace with current page slug
                    'posts_per_page' => 3,
                );

                $popular_posts = new WP_Query($args02);
                $post_count = 0;
                if ($popular_posts->have_posts()):
                    while ($popular_posts->have_posts() && $post_count < 4):
                        $popular_posts->the_post();
                        ?>
                        <div class="mostview-card">
                            <a class="mostviewHome" href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('thumbnail', array('class' => 'img-fluid')); ?>
                                <?php else :
                                    $image = get_field('post-image');
                                    if ($image): ?>
                                        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($image); ?>" class="img-fluid" />
                                    <?php else: ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/programmer.jpeg" alt="img" class="img-fluid" />
                                    <?php endif; ?>
                                <?php endif; ?>
                                <p class="mostviewCaption text-center text-light"><?php the_title(); ?></p>
                            </a>
                        </div>
                        <?php
                        $post_count++;
                    endwhile;
                endif;
                wp_reset_postdata();
                ?>
            </div>

            <br><br><br>

            <div class="container my-5 text-dark">
                <?php
                $args = array(
                    'post_type' => $current_page_slug, // Replace with current page slug
                    'posts_per_page' => -1,
                );

                $query = new WP_Query($args);
                $posts_by_category = array();

                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        $kategori = get_field('kategori');
                        if ($kategori) {
                            if (!isset($posts_by_category[$kategori])) {
                                $posts_by_category[$kategori] = array();
                            }
                            $posts_by_category[$kategori][] = $post;
                        }
                    }

                    foreach ($posts_by_category as $kategori => $posts) {
                        echo '<div class="row mb-4 p-2">';
                        echo '<div class="col-6">';
                        echo '<h3 class="mb-3 text-light">' . esc_html($kategori) . '</h3>';
                        echo '</div>';
                        echo '<div class="col-6 text-right">';
                        echo '<a class="btn btn-light mb-3 mr-1" href="#carousel-' . esc_attr($kategori) . '" role="button" data-slide="prev">';
                        echo '<i class="fa fa-arrow-left"></i>';
                        echo '</a>';
                        echo '<a class="btn btn-light mb-3" href="#carousel-' . esc_attr($kategori) . '" role="button" data-slide="next">';
                        echo '<i class="fa fa-arrow-right"></i>';
                        echo '</a>';
                        echo '<a class="btn btn-warning mb-3 ml-1" href="http://localhost/staging_eknowledge/categories/?kategori=' . esc_attr($kategori) . '" target="_blank">More...</a>';
                        echo '</div>';

                        echo '<div class="col-12">';
                        echo '<div id="carousel-' . esc_attr($kategori) . '" class="carousel slide" data-ride="carousel">';
                        echo '<div class="carousel-inner">';

                        $chunks = array_chunk($posts, 3);
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
                                                $image = get_field('post-image');
                                                if ($image): ?>
                                                    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($image); ?>" class="img-fluid card-img-top" />
                                                <?php else: ?>
                                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/programmer.jpeg" alt="img" class="img-fluid card-img-top" />
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <div class="card-body">
                                                <h4 class="card-title">
                                                    <?php
                                                    $title = get_the_title();
                                                    $words = explode(' ', $title);
                                                    $short_title = implode(' ', array_slice($words, 0, 2));
                                                    $has_more_words = count($words) > 2;
                                                    echo esc_html($short_title . ($has_more_words ? '...' : ''));
                                                    ?>
                                                </h4>
                                                <p class="card-text"><?php echo wp_trim_words(get_the_excerpt(), 8, '...'); ?></p>
                                            </div>
                                        </div>
                                    </a>
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

    <?php get_footer();
} // Tutup blok kondisi 
?>
