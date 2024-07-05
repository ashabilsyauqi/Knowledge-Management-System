
s
<section class="pageSingle "> 
    <div class="d-flex justify-content-center align-items-start pc-3  flex-wrap " style="height: auto; gap:20px;">
        <?php if (have_posts()): while(have_posts()): the_post(); ?> 
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
                                        <?php      // Mengambil judul post
                                            $title = get_the_title();
                                            
                                            // Memisahkan judul menjadi array berdasarkan spasi
                                            $words = explode(' ', $title);

                                            // Mengambil dua kata pertama
                                            $short_title = implode(' ', array_slice($words, 0, 2));

                                            // Menentukan apakah judul memiliki lebih dari dua kata
                                            $has_more_words = count($words) > 2;
                                        
                                            echo $short_title . ($has_more_words ? '...' : ''); ?>

                            </p>
                        </a>
                    </div>
        <?php endwhile; else: endif;?>
    </div>
</section>
