<?php
get_header(); ?>

<main>
   <!-- <h1><?php bloginfo('name'); ?></h1>
    <p>Welkom Webkoers thema. </p> -->

    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <article>
                <h2><?php the_title(); ?></h2>
                <?php the_content(); ?>
            </article>
        <?php endwhile; ?>
    <?php else : ?>
        <p>Geen content gevonden.</p>
    <?php endif; ?>
</main>

<?php get_footer();
