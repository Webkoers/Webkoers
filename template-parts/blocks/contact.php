<?php
/**
 * Block: Contact
 * Flexible content layout: contact
 */

$kicker = get_sub_field('kicker');
$title  = get_sub_field('title');
$intro  = get_sub_field('intro');

$name     = get_sub_field('name');
$role     = get_sub_field('role');
$location = get_sub_field('location');
$email    = get_sub_field('email');
$phone    = get_sub_field('phone');

$profile_image = get_sub_field('profile_image');

$form_shortcode = get_sub_field('form_shortcode');
$note           = get_sub_field('cta_note');

$variant = get_sub_field('variant') ?: 'dark';
$is_dark = ($variant === 'dark');

$heading_id = 'contact-title-' . (int) get_row_index();

$section_classes = ['section', 'b-contact'];
if ($is_dark) {
  $section_classes[] = 'section--dark';
}

// Basic guard: if nothing meaningful, don’t render.
$has_any =
  !empty($title) ||
  !empty($intro) ||
  !empty($form_shortcode) ||
  !empty($name) ||
  !empty($email) ||
  !empty($phone) ||
  !empty($profile_image);

if (!$has_any) {
  return;
}

$tel_href = '';
if (!empty($phone)) {
  $tel_href = preg_replace('/[^\d\+]/', '', (string) $phone);
}
?>

<section id="contact" class="<?php echo esc_attr(implode(' ', $section_classes)); ?>" aria-labelledby="<?php echo esc_attr($heading_id); ?>">
  <div class="container b-contact__inner" id="contact">

    <div class="b-contact__content">
      <?php if (!empty($kicker)) : ?>
        <p class="b-contact__kicker"><?php echo esc_html($kicker); ?></p>
      <?php endif; ?>

      <?php if (!empty($title)) : ?>
        <h2 id="<?php echo esc_attr($heading_id); ?>" class="b-contact__title">
          <?php echo esc_html($title); ?>
        </h2>
      <?php else : ?>
        <h2 id="<?php echo esc_attr($heading_id); ?>" class="b-contact__title screen-reader-text">
          <?php echo esc_html__('Contact', 'webkoers'); ?>
        </h2>
      <?php endif; ?>

      <?php if (!empty($intro)) : ?>
        <p class="b-contact__intro"><?php echo esc_html($intro); ?></p>
      <?php endif; ?>

      <?php if (!empty($form_shortcode)) : ?>
        <div class="b-contact__form">
          <?php echo do_shortcode((string) $form_shortcode); ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($note)) : ?>
        <p class="b-contact__note"><?php echo esc_html($note); ?></p>
      <?php endif; ?>
    </div>

    <aside class="b-contact__card" aria-label="<?php echo esc_attr__('Contactgegevens', 'webkoers'); ?>">
      <?php if (!empty($profile_image)) : ?>
        <figure class="b-contact__media">
          <?php
          echo wp_get_attachment_image(
            (int) $profile_image,
            'medium_large',
            false,
            [
              'class'    => 'b-contact__img',
              'loading'  => 'lazy',
              'decoding' => 'async',
            ]
          );
          ?>
        </figure>
      <?php endif; ?>

      <?php if (!empty($name)) : ?>
        <p class="b-contact__name"><?php echo esc_html($name); ?></p>
      <?php endif; ?>

      <?php if (!empty($role)) : ?>
        <p class="b-contact__role"><?php echo esc_html($role); ?></p>
      <?php endif; ?>

      <?php if (!empty($location)) : ?>
        <p class="b-contact__location"><?php echo esc_html($location); ?></p>
      <?php endif; ?>

      <?php if (!empty($email) || (!empty($phone) && !empty($tel_href))) : ?>
        <div class="b-contact__links">
          <?php if (!empty($email)) : ?>
            <a class="b-contact__link" href="mailto:<?php echo esc_attr(antispambot($email)); ?>">
              <span class="b-contact__link-text"><?php echo esc_html($email); ?></span>
              <span class="b-contact__link-icon" aria-hidden="true">↗</span>
            </a>
          <?php endif; ?>

          <?php if (!empty($phone) && !empty($tel_href)) : ?>
            <a class="b-contact__link" href="tel:<?php echo esc_attr($tel_href); ?>">
              <span class="b-contact__link-text"><?php echo esc_html($phone); ?></span>
              <span class="b-contact__link-icon" aria-hidden="true">↗</span>
            </a>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </aside>

  </div>
</section>