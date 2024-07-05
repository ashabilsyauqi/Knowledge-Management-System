INI KOMENTAR

<?php
// Jika komentar dinonaktifkan, keluar dari skrip ini
if (!comments_open() && get_comments_number() <= 0) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $comments_number = get_comments_number();
            if ($comments_number === 1) {
                printf(
                    /* translators: 1: title. */
                    esc_html__('One thought on &ldquo;%1$s&rdquo;', 'theme-name'),
                    '<span>' . get_the_title() . '</span>'
                );
            } else {
                printf( // WPCS: XSS OK.
                    /* translators: 1: comment count number, 2: title. */
                    esc_html(_nx('%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comments_number, 'comments title', 'theme-name')),
                    number_format_i18n($comments_number),
                    '<span>' . get_the_title() . '</span>'
                );
            }
            ?>
        </h2><!-- .comments-title -->

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'      => 'ol',
                'short_ping' => true,
                'avatar_size' => 42,
            ));
            ?>
        </ol><!-- .comment-list -->

        <?php the_comments_pagination(); ?>

    <?php endif; // Check for have_comments(). ?>

    <?php
    // Jika komentar dinonaktifkan dan ada komentar, tampilkan pesan
    if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) :
    ?>
        <p class="no-comments"><?php esc_html_e('Comments are closed.', 'theme-name'); ?></p>
    <?php endif; ?>

    <?php comment_form(); ?>

</div><!-- #comments -->
