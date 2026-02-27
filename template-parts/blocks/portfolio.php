<?php
/**
 * Block: Portfolio
 * Flexible content layout: portfolio
 */

$kicker       = get_sub_field('portfolio_kicker');
$title        = get_sub_field('portfolio_title');
$show_filters = (bool) get_sub_field('portfolio_show_filters');

$items = get_sub_field('portfolio_items');
if (!is_array($items)) {
  $items = [];
}

$block_id   = 'portfolio-' . wp_unique_id();
$heading_id = $block_id . '-title';

/**
 * Bepaal of er überhaupt content is (zodat je niet per ongeluk een compleet leeg blok rendert)
 * -> Header of filters of minimaal 1 toonbare card
 */
$has_header  = (!empty($kicker) || !empty($title));
$has_filters = $show_filters;

$renderable_count = 0;
foreach ($items as $item) {
  $item_title = $item['item_title'] ?? '';
  $image_id   = (int) ($item['item_image'] ?? 0);

  // minimaal: titel OF afbeelding, anders niet toonbaar
  if (empty($item_title) && empty($image_id)) {
    continue;
  }

  $renderable_count++;
  break;
}

if (!$has_header && !$has_filters && $renderable_count === 0) {
  return;
}
?>

<section class="section b-portfolio" aria-labelledby="<?php echo esc_attr($heading_id); ?>" data-portfolio>
  <div class="container b-portfolio__inner" id="portfolio">

    <?php if ($has_header) : ?>
      <header class="b-portfolio__header">
        <?php if (!empty($kicker)) : ?>
          <p class="b-portfolio__kicker"><?php echo esc_html($kicker); ?></p>
        <?php endif; ?>

        <?php if (!empty($title)) : ?>
          <h2 id="<?php echo esc_attr($heading_id); ?>" class="b-portfolio__title">
            <?php echo esc_html($title); ?>
          </h2>
        <?php else : ?>
          <h2 id="<?php echo esc_attr($heading_id); ?>" class="b-portfolio__title">
            <?php echo esc_html__('Portfolio', 'webkoers'); ?>
          </h2>
        <?php endif; ?>
      </header>
    <?php else : ?>
      <h2 id="<?php echo esc_attr($heading_id); ?>" class="b-portfolio__title screen-reader-text">
        <?php echo esc_html__('Portfolio', 'webkoers'); ?>
      </h2>
    <?php endif; ?>

    <?php if ($show_filters) : ?>
      <div class="b-portfolio__filters" role="tablist" aria-label="<?php echo esc_attr__('Portfolio filter', 'webkoers'); ?>">
        <button class="b-portfolio__filter is-active" type="button" role="tab" aria-selected="true" data-filter="all">
          <?php echo esc_html__('Alles', 'webkoers'); ?>
        </button>
        <button class="b-portfolio__filter" type="button" role="tab" aria-selected="false" data-filter="webshop">
          <?php echo esc_html__('Webshop', 'webkoers'); ?>
        </button>
        <button class="b-portfolio__filter" type="button" role="tab" aria-selected="false" data-filter="website">
          <?php echo esc_html__('Website', 'webkoers'); ?>
        </button>
      </div>
    <?php endif; ?>

    <?php
    // Render cards alleen als er items zijn die “toonbaar” zijn
    $printed = 0;
    ?>

    <div class="b-portfolio__grid" data-grid>
      <?php foreach ($items as $item) :
        if ($printed >= 16) {
          break;
        }

        $item_title = $item['item_title'] ?? '';
        $item_type  = $item['item_type'] ?? '';
        $image_id   = (int) ($item['item_image'] ?? 0);
        $link       = is_array($item['item_link'] ?? null) ? ($item['item_link'] ?? []) : [];

        // minimaal: titel OF afbeelding
        if (empty($item_title) && empty($image_id)) {
          continue;
        }

        $type  = in_array($item_type, ['website', 'webshop'], true) ? $item_type : 'website';
        $label = $type === 'webshop' ? __('Webshop', 'webkoers') : __('Website', 'webkoers');

        $url    = !empty($link['url']) ? $link['url'] : '';
        $target = !empty($link['target']) ? $link['target'] : '';

        // Als er geen url is -> geen link, maar wel dezelfde styling
        $tag = $url ? 'a' : 'div';

        $printed++;
      ?>
        <article class="b-portfolio-card" data-type="<?php echo esc_attr($type); ?>">
          <<?php echo $tag; ?>
            class="b-portfolio-card__link"
            <?php if ($url) : ?>
              href="<?php echo esc_url($url); ?>"
              <?php echo $target ? 'target="' . esc_attr($target) . '"' : ''; ?>
              rel="<?php echo $target ? 'noopener noreferrer' : 'nofollow'; ?>"
            <?php endif; ?>
          >
            <?php if ($image_id) : ?>
              <figure class="b-portfolio-card__figure">
                <?php
                echo wp_get_attachment_image(
                  $image_id,
                  'large',
                  false,
                  [
                    'class'    => 'b-portfolio-card__img',
                    'loading'  => 'lazy',
                    'decoding' => 'async',
                  ]
                );
                ?>
              </figure>
            <?php endif; ?>

            <div class="b-portfolio-card__meta">
              <p class="b-portfolio-card__type"><?php echo esc_html($label); ?></p>

              <?php if (!empty($item_title)) : ?>
                <h3 class="b-portfolio-card__title"><?php echo esc_html($item_title); ?></h3>
              <?php endif; ?>
            </div>
          </<?php echo $tag; ?>>
        </article>
      <?php endforeach; ?>
    </div>

    <?php if ($printed === 0) : ?>
      <p class="b-portfolio__empty">
        <?php echo esc_html__('Nog geen portfolio-items toegevoegd.', 'webkoers'); ?>
      </p>
    <?php endif; ?>

  </div>
</section>