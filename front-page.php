<?php get_header(); ?>

<main class="front-page">

    <?php if ( have_rows('blokken') ) : ?>
        <?php while ( have_rows('blokken') ) : the_row(); ?>

            <?php
            $layout = get_row_layout();
            $template = str_replace('_', '-', $layout); // magic fix
            get_template_part('template-parts/blocks/' . $template);
            ?>

        <?php endwhile; ?>
    <?php endif; ?>

</main>

<?php get_footer(); ?>
