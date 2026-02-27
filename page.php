<?php get_header(); ?>

<main class="page">

  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>

      <?php if (have_rows('blokken')) : ?>
        <?php while (have_rows('blokken')) : the_row(); ?>

          <?php
            $layout   = get_row_layout();
            $template = str_replace('_', '-', $layout);
            get_template_part('template-parts/blocks/' . $template);
          ?>

        <?php endwhile; ?>
      <?php else : ?>

        <article class="page-content">
          <?php the_content(); ?>
        </article>

      <?php endif; ?>

    <?php endwhile; ?>
  <?php endif; ?>

</main>

<?php get_footer(); ?>
