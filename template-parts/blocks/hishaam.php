<?php
/**
 * Block: Hishaam
 * Flexible content layout: hishaam
 */

$variant   = get_sub_field('variant') ?: 'dark';
$kicker    = get_sub_field('kicker');
$title     = get_sub_field('title');
$text      = get_sub_field('text');

$image_id  = (int) (get_sub_field('image') ?: 0);
$image_alt = get_sub_field('image_alt');

$highlights = get_sub_field('highlights');
$cta_primary = get_sub_field('cta_primary');
$cta_secondary = get_sub_field('cta_secondary');

if (empty($title)) {
  return;
}

$section_id = 'hishaam-' . (int) get_row_index();

$classes = ['section', 'b-hishaam'];
if ($variant === 'dark') {
  $classes[] = 'section--dark';
}
?>

<section class="<?php echo esc_attr(implode(' ', $classes)); ?>" aria-labelledby="<?php echo esc_attr($section_id); ?>">
  <div class="container b-hishaam__inner" id="over-mij">

    <div class="b-hishaam__content">
      <?php if (!empty($kicker)) : ?>
        <p class="b-hishaam__kicker"><?php echo esc_html($kicker); ?></p>
      <?php endif; ?>

      <h2 id="<?php echo esc_attr($section_id); ?>" class="b-hishaam__title">
        <?php echo esc_html($title); ?>
      </h2>

      <?php if (!empty($text)) : ?>
  <div class="b-hishaam__text">
    <?php echo wp_kses_post(wpautop($text)); ?>
  </div>
<?php endif; ?>

      <?php if (!empty($highlights) && is_array($highlights)) : ?>
        <dl class="b-hishaam__highlights">
          <?php foreach ($highlights as $h) :
            $label = $h['label'] ?? '';
            $value = $h['value'] ?? '';
            if (!$label || !$value) continue;
          ?>
            <div class="b-hishaam__highlight">
              <dt class="b-hishaam__label"><?php echo esc_html($label); ?></dt>
              <dd class="b-hishaam__value"><?php echo esc_html($value); ?></dd>
            </div>
          <?php endforeach; ?>
        </dl>
      <?php endif; ?>

      <?php
      $has_primary = is_array($cta_primary) && !empty($cta_primary['url']);
      $has_secondary = is_array($cta_secondary) && !empty($cta_secondary['url']);
      ?>

      <?php if ($has_primary || $has_secondary) : ?>
        <div class="b-hishaam__actions">
          <?php if ($has_primary) : ?>
            <a class="btn btn--primary"
               href="<?php echo esc_url($cta_primary['url']); ?>"
               <?php echo !empty($cta_primary['target']) ? 'target="' . esc_attr($cta_primary['target']) . '" rel="noopener noreferrer"' : ''; ?>>
              <?php echo esc_html($cta_primary['title'] ?: 'Meer info'); ?>
            </a>
          <?php endif; ?>

          <?php if ($has_secondary) : ?>
            <a class="btn btn--secondary"
               href="<?php echo esc_url($cta_secondary['url']); ?>"
               <?php echo !empty($cta_secondary['target']) ? 'target="' . esc_attr($cta_secondary['target']) . '" rel="noopener noreferrer"' : ''; ?>>
              <?php echo esc_html($cta_secondary['title'] ?: 'Contact'); ?>
            </a>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>

    <div class="b-hishaam__media">
      <?php if ($image_id) : ?>
        <figure class="b-hishaam__figure">
          <?php
            $alt = $image_alt ? $image_alt : get_post_meta($image_id, '_wp_attachment_image_alt', true);
            echo wp_get_attachment_image(
              $image_id,
              'large',
              false,
              [
                'class' => 'b-hishaam__img',
                'loading' => 'lazy',
                'decoding' => 'async',
                'alt' => $alt ? $alt : '',
              ]
            );
          ?>
        </figure>
      <?php endif; ?>
    </div>

  </div>
</section>