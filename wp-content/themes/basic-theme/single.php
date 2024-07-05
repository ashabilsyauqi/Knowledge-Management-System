<?php get_header('secondary'); ?>

<section class="pageSingle bg-white-custom vh-100">
    <div class="p-4 text-dark">

        <h1><?php the_title(); ?></h1>

        <?php get_template_part('includes/section', 'blogcontent'); ?>

        <?php
        // Mengecek apakah ada komentar atau tidak
        if (comments_open() || get_comments_number()) {
            // Memuat template komentar
            comments_template();
        }
        ?>

        <br>
<!-- 
        <section class="border p-4">
          

        </section> -->

    </div>
</section>

<?php get_footer(); ?>
