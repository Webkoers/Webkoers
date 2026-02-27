<?php
/**
 * Block: Stack Marquee
 * Flexible content layout: stack-marquee
 */

$is_dark = (bool) get_sub_field('is_dark');
$items   = get_sub_field('items');

if (empty($items) || !is_array($items)) {
  return;
}

$section_classes = ['section', 'b-stack-marquee'];
if ($is_dark) {
  $section_classes[] = 'section--dark';
}

$heading_id = 'stack-marquee-title-' . (int) get_row_index();
?>

<section class="<?php echo esc_attr(implode(' ', $section_classes)); ?>" aria-labelledby="<?php echo esc_attr($heading_id); ?>">
  <div class="container b-stack-marquee__inner">

    <h2 id="<?php echo esc_attr($heading_id); ?>" class="screen-reader-text">
      <?php echo esc_html__('Technologie stack', 'webkoers'); ?>
    </h2>

    <div class="b-stack-marquee__wrap" data-marquee>
      <div class="b-stack-marquee__track" data-marquee-track>
        <?php foreach ($items as $item) :
          $label   = $item['label'] ?? '';
          $logo_id = (int) ($item['logo'] ?? 0);
          $link    = $item['link'] ?? null;

          if (empty($label) || empty($logo_id)) {
            continue;
          }

          $has_link = is_array($link) && !empty($link['url']);
          $target   = $has_link && !empty($link['target']) ? $link['target'] : '';
          $rel      = $target ? 'noopener noreferrer' : 'nofollow';
        ?>
          <div class="b-stack-marquee__item">
            <?php if ($has_link) : ?>
              <a class="b-stack-marquee__link"
                 href="<?php echo esc_url($link['url']); ?>"
                 <?php echo $target ? 'target="' . esc_attr($target) . '"' : ''; ?>
                 rel="<?php echo esc_attr($rel); ?>"
                 aria-label="<?php echo esc_attr($label); ?>">
                <?php
                echo wp_get_attachment_image(
                  $logo_id,
                  'medium',
                  false,
                  [
                    'class'    => 'b-stack-marquee__logo',
                    'loading'  => 'lazy',
                    'decoding' => 'async',
                    'alt'      => $label,
                  ]
                );
                ?>
              </a>
            <?php else : ?>
              <span class="b-stack-marquee__label" aria-label="<?php echo esc_attr($label); ?>">
                <?php
                echo wp_get_attachment_image(
                  $logo_id,
                  'medium',
                  false,
                  [
                    'class'    => 'b-stack-marquee__logo',
                    'loading'  => 'lazy',
                    'decoding' => 'async',
                    'alt'      => $label,
                  ]
                );
                ?>
              </span>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

  </div>
</section>