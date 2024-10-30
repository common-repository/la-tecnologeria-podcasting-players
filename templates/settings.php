<div class="wrap">
    <h2><?php esc_html( 'La Tecnologer&iacute;a Podcasting Plugin Settings', 'ivoox' ); ?></h2>
    <form method="post" action="options.php">
        <?php settings_fields('ivoox_shortcode_group'); ?>

        <?php do_settings_sections('ivoox_shortcode'); ?>

        <?php submit_button(); ?>
    </form>
</div>