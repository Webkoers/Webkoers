<?php
/**
 * Block: Social proof
 * Flexible content layout: social-proof
 *
 * Expects ACF sub fields:
 * - kicker (text)
 * - title (text)
 * - intro (textarea/wysiwyg)
 * - variant (select: light|dark)
 * - rating_value (number)
 * - rating_count (number/text)
 * - rating_source (text)
 * - rating_link (link)
 * - testimonials (repeater)
 *    - quote (wysiwyg)
 *    - name (text)
 *    - role_company (text)
 *    - location (text)
 *    - avatar (image ID)
 *    - link (link)
 * - cta_button_primary (link)
 * - cta_button_secondary (link)
 */

$kicker  = get_sub_field('kicker');
$title   = get_sub_field('title');
$intro   = get_sub_field('intro');

$variant = get_sub_field('variant') ?: 'dark';
$is_dark = ($variant === 'dark');

$rating_value  = get_sub_field('rating_value');
$rating_count  = get_sub_field('rating_count');
$rating_source = get_sub_field('rating_source') ?: '';
$rating_link   = get_sub_field('rating_link');

$items = get_sub_field('testimonials');
$items = is_array($items) ? $items : [];

$btn_primary   = get_sub_field('cta_button_primary');
$btn_secondary = get_sub_field('cta_button_secondary');

$heading_id = 'social-proof-title-' . wp_unique_id();

$section_classes = ['section', 'b-social-proof'];
if ($is_dark) {
  $section_classes[] = 'section--dark';
}

$has_rating = (!empty($rating_value) && !empty($rating_count));
$has_rating_link = (is_array($rating_link) && !empty($rating_link['url']));

$has_primary   = (is_array($btn_primary) && !empty($btn_primary['url']));
$has_secondary = (is_array($btn_secondary) && !empty($btn_secondary['url']));

/**
 * If literally nothing is set, don’t render.
 * (Keeps editor clean when a block is added but not configured yet.)
 */
$has_content =
  !empty($kicker) ||
  !empty($title) ||
  !empty($intro) ||
  $has_rating ||
  !empty($items) ||
  $has_primary ||
  $has_secondary;

if (!$has_content) {
  return;
}
?>

<section class="<?php echo esc_attr(implode(' ', $section_classes)); ?>" aria-labelledby="<?php echo esc_attr($heading_id); ?>">
  <div class="container b-social-proof__inner" id="reviews">

    <header class="b-social-proof__header">
      <?php if (!empty($kicker)) : ?>
        <p class="b-social-proof__kicker"><?php echo esc_html($kicker); ?></p>
      <?php endif; ?>

      <?php if (!empty($title)) : ?>
        <h2 id="<?php echo esc_attr($heading_id); ?>" class="b-social-proof__title">
          <?php echo esc_html($title); ?>
        </h2>
      <?php else : ?>
        <h2 id="<?php echo esc_attr($heading_id); ?>" class="b-social-proof__title screen-reader-text">
          <?php echo esc_html__('Reviews', 'webkoers'); ?>
        </h2>
      <?php endif; ?>

      <?php if (!empty($intro)) : ?>
        <div class="b-social-proof__intro">
          <?php echo wp_kses_post($intro); ?>
        </div>
      <?php endif; ?>

      <?php if ($has_rating) : ?>
        <div class="b-social-proof__rating" aria-label="<?php echo esc_attr__('Beoordeling', 'webkoers'); ?>">
          <?php
          $rating_value_out = number_format((float) $rating_value, 1);
          $rating_count_out = (int) $rating_count;
          ?>

          <?php if ($has_rating_link) : ?>
            <?php
            $target = !empty($rating_link['target']) ? $rating_link['target'] : '';
            $rel    = $target ? 'noopener noreferrer' : 'nofollow';
            ?>
            <a class="b-rating"
               href="<?php echo esc_url($rating_link['url']); ?>"
               <?php echo $target ? 'target="' . esc_attr($target) . '"' : ''; ?>
               rel="<?php echo esc_attr($rel); ?>">
              <span class="b-rating__stars" aria-hidden="true">★★★★★</span>
              <span class="b-rating__value"><?php echo esc_html($rating_value_out); ?></span>
              <span class="b-rating__meta">
                (<?php echo esc_html($rating_count_out); ?>)<?php echo $rating_source ? ' — ' . esc_html($rating_source) : ''; ?>
              </span>
              <span class="b-rating__icon" aria-hidden="true">↗</span>
            </a>
          <?php else : ?>
            <div class="b-rating">
              <span class="b-rating__stars" aria-hidden="true">★★★★★</span>
              <span class="b-rating__value"><?php echo esc_html($rating_value_out); ?></span>
              <span class="b-rating__meta">
                (<?php echo esc_html($rating_count_out); ?>)<?php echo $rating_source ? ' — ' . esc_html($rating_source) : ''; ?>
              </span>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </header>

    <?php if (!empty($items)) : ?>
      <div class="b-social-proof__grid">
        <?php foreach ($items as $t) :
          $quote  = $t['quote'] ?? '';
          $name   = $t['name'] ?? '';
          $role   = $t['role_company'] ?? '';
          $loc    = $t['location'] ?? '';
          $avatar = (int) ($t['avatar'] ?? 0);
          $link   = $t['link'] ?? null;

          // Quote is leading content; skip empty items.
          if (empty($quote)) {
            continue;
          }

          $has_link = (is_array($link) && !empty($link['url']));
          $meta     = trim($role . ($role && $loc ? ' — ' : '') . $loc);

          $target = ($has_link && !empty($link['target'])) ? $link['target'] : '';
          $rel    = $target ? 'noopener noreferrer' : 'nofollow';
        ?>
          <figure class="b-testimonial">
            <blockquote class="b-testimonial__quote">
              <?php
              /**
               * Quote is WYSIWYG -> keep markup, but sanitize.
               * If you ever switch back to textarea: use wpautop() again.
               */
              echo wp_kses_post($quote);
              ?>
            </blockquote>

            <?php if (!empty($avatar) || !empty($name) || !empty($meta)) : ?>
              <figcaption class="b-testimonial__footer">
                <?php if (!empty($avatar)) : ?>
                  <span class="b-testimonial__avatar">
                    <?php
                    echo wp_get_attachment_image(
                      $avatar,
                      'thumbnail',
                      false,
                      [
                        'loading'  => 'lazy',
                        'decoding' => 'async',
                        'class'    => 'b-testimonial__img',
                        'alt'      => $name ? esc_attr($name) : '',
                      ]
                    );
                    ?>
                  </span>
                <?php endif; ?>

                <div class="b-testimonial__who">
                  <?php if (!empty($name)) : ?>
                    <div class="b-testimonial__name">
                      <?php if ($has_link) : ?>
                        <a class="b-testimonial__name-link"
                           href="<?php echo esc_url($link['url']); ?>"
                           <?php echo $target ? 'target="' . esc_attr($target) . '"' : ''; ?>
                           rel="<?php echo esc_attr($rel); ?>">
                          <?php echo esc_html($name); ?>
                        </a>
                      <?php else : ?>
                        <?php echo esc_html($name); ?>
                      <?php endif; ?>
                    </div>
                  <?php endif; ?>

                  <?php if (!empty($meta)) : ?>
                    <div class="b-testimonial__meta"><?php echo esc_html($meta); ?></div>
                  <?php endif; ?>
                </div>
              </figcaption>
            <?php endif; ?>
          </figure>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if ($has_primary || $has_secondary) : ?>
      <div class="b-social-proof__cta">
        <?php if ($has_primary) : ?>
          <?php
          $target = !empty($btn_primary['target']) ? $btn_primary['target'] : '';
          $rel    = $target ? 'noopener noreferrer' : 'nofollow';
          ?>
          <a class="btn btn--primary"
             href="<?php echo esc_url($btn_primary['url']); ?>"
             <?php echo $target ? 'target="' . esc_attr($target) . '"' : ''; ?>
             rel="<?php echo esc_attr($rel); ?>">
            <?php echo esc_html($btn_primary['title'] ?: ''); ?>
          </a>
        <?php endif; ?>

        <?php if ($has_secondary) : ?>
          <?php
          $target = !empty($btn_secondary['target']) ? $btn_secondary['target'] : '';
          $rel    = $target ? 'noopener noreferrer' : 'nofollow';
          ?>
          <a class="btn btn--secondary"
             href="<?php echo esc_url($btn_secondary['url']); ?>"
             <?php echo $target ? 'target="' . esc_attr($target) . '"' : ''; ?>
             rel="<?php echo esc_attr($rel); ?>">
            <?php echo esc_html($btn_secondary['title'] ?: ''); ?>
          </a>
        <?php endif; ?>
      </div>
    <?php endif; ?>

  </div>
</section>