<?php
/**
 * Block: Over mij
 * Flexible content layout: over-mij
 */

$kicker = get_sub_field('over_mij_kicker');
$title  = get_sub_field('over_mij_title');
$text   = get_sub_field('over_mij_text');

$image_id = get_sub_field('over_mij_image');

$primary   = get_sub_field('over_mij_primary');
$secondary = get_sub_field('over_mij_secondary');

$is_dark = (bool) get_sub_field('over_mij_is_dark');
$pos     = get_sub_field('over_mij_media_position') ?: 'right';
$pos     = in_array($pos, ['left', 'right'], true) ? $pos : 'right';

if (empty($title) && empty($kicker) && empty($sanitized_text) && empty($image_id)) {
  return;
}

$section_classes = [
  'section',
  'b-over-mij',
  'b-over-mij--media-' . $pos,
];

if ($is_dark) {
  $section_classes[] = 'section--dark';
}

$heading_id = 'over-mij-title-' . (int) get_row_index();

/**
 * WYSIWYG hardening:
 * - strip inline styles + legacy color attributes that can break contrast
 */
$allowed = wp_kses_allowed_html('post');

// Remove <font> entirely (common source of color issues)
unset($allowed['font']);

foreach ($allowed as $tag => $attrs) {
  if (!is_array($attrs)) {
    continue;
  }
  unset($allowed[$tag]['style']);
  unset($allowed[$tag]['color']);
  unset($allowed[$tag]['bgcolor']);
  unset($allowed[$tag]['face']);
  unset($allowed[$tag]['size']);
}

$sanitized_text = !empty($text) ? wp_kses($text, $allowed) : '';
?>

<section class="<?php echo esc_attr(implode(' ', $section_classes)); ?>" aria-labelledby="<?php echo esc_attr($heading_id); ?>">
  <div class="container b-over-mij__inner">

    <div class="b-over-mij__content">
      <?php if (!empty($kicker)) : ?>
        <p class="b-over-mij__kicker"><?php echo esc_html($kicker); ?></p>
      <?php endif; ?>

      <h2 id="<?php echo esc_attr($heading_id); ?>" class="b-over-mij__title">
        <?php echo esc_html($title); ?>
      </h2>

      <?php if (!empty($sanitized_text)) : ?>
        <div class="b-over-mij__text">
          <?php echo $sanitized_text; ?>
        </div>
      <?php endif; ?>

      <?php
      $has_primary   = !empty($primary) && !empty($primary['url']) && !empty($primary['title']);
      $has_secondary = !empty($secondary) && !empty($secondary['url']) && !empty($secondary['title']);
      ?>

      <?php if ($has_primary || $has_secondary) : ?>
        <div class="b-over-mij__actions">
          <?php if ($has_primary) : ?>
            <a
              class="btn btn--primary"
              href="<?php echo esc_url($primary['url']); ?>"
              <?php echo !empty($primary['target']) ? 'target="' . esc_attr($primary['target']) . '"' : ''; ?>
              rel="<?php echo !empty($primary['target']) ? 'noopener noreferrer' : 'nofollow'; ?>"
            >
              <?php echo esc_html($primary['title']); ?>
            </a>
          <?php endif; ?>

          <?php if ($has_secondary) : ?>
            <a
              class="btn btn--secondary"
              href="<?php echo esc_url($secondary['url']); ?>"
              <?php echo !empty($secondary['target']) ? 'target="' . esc_attr($secondary['target']) . '"' : ''; ?>
              rel="<?php echo !empty($secondary['target']) ? 'noopener noreferrer' : 'nofollow'; ?>"
            >
              <?php echo esc_html($secondary['title']); ?>
            </a>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>

    <?php if (!empty($image_id)) : ?>
      <div class="b-over-mij__media">
        <figure class="b-over-mij__figure">
          <?php
          echo wp_get_attachment_image(
            (int) $image_id,
            'large',
            false,
            [
              'class'    => 'b-over-mij__img',
              'loading'  => 'lazy',
              'decoding' => 'async',
            ]
          );
          ?>
        </figure>
      </div>
    <?php endif; ?>

  </div>
</section>