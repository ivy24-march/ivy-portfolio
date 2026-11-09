<?php

$homepage_id = get_option('page_on_front');

if (!$homepage_id) {
    $home_page = get_page_by_path('home');

    if ($home_page) {
        $homepage_id = $home_page->ID;
    }
}

$footer_defaults = array(

    'description' => 'Kenya USA Diaspora Sacco Investment Company, creating sustainable opportunities through investment, housing and urban development.',

    'facebook' => '#',
    'twitter' => '#',
    'linkedin' => '#',
    'instagram' => '#',

    'location' => 'Nairobi, Kenya',

    'phone' => '+254 790 239 753',

    'email' => 'info@kudsic.com',

    'hours' => 'Mon – Fri: 8:00 AM – 5:00 PM',

    'newsletter_label' => 'STAY CONNECTED',

    'newsletter_heading' => 'Get the latest KUDSIC updates.',

    'newsletter_placeholder' => 'Enter your email address',

    'newsletter_button' => 'Subscribe',

    'privacy_url' => '#',

    'terms_url' => '#',

    'copyright' => '© 2026 KUDSIC. All Rights Reserved.'
);


$footer = array();

foreach ($footer_defaults as $field => $default) {

    $value = get_post_meta(
        $homepage_id,
        '_kudsic_footer_' . $field,
        true
    );

    if ($value === '') {
        $value = $default;
    }

    $footer[$field] = $value;
}

?>

<footer class="site-footer">

    <div class="footer-main">

        <div class="footer-brand">

            <img
                src="<?php echo get_template_directory_uri(); ?>/images/LOGO1.png"
                alt="KUDSIC Logo"
            >

            <p>
                <?php echo esc_html($footer['description']); ?>
            </p>

            <div class="footer-socials">

                <a href="<?php echo esc_url($footer['facebook']); ?>">
                    <i class="fab fa-facebook-f"></i>
                </a>

                <a href="<?php echo esc_url($footer['twitter']); ?>">
                    <i class="fab fa-x-twitter"></i>
                </a>

                <a href="<?php echo esc_url($footer['linkedin']); ?>">
                    <i class="fab fa-linkedin-in"></i>
                </a>

                <a href="<?php echo esc_url($footer['instagram']); ?>">
                    <i class="fab fa-instagram"></i>
                </a>

            </div>

        </div>


        <div class="footer-column">

            <h3>Quick Links</h3>

            <a href="<?php echo home_url('/'); ?>">Home</a>

            <a href="<?php echo home_url('/about-us/'); ?>">
                About Us
            </a>

            <a href="<?php echo home_url('/investments/'); ?>">
                Investments
            </a>

            <a href="<?php echo home_url('/projects/'); ?>">
                Projects
            </a>

            <a href="<?php echo home_url('/contact-us/'); ?>">
                Contact Us
            </a>

        </div>


        <div class="footer-column">

            <h3>Resources</h3>

            <a href="<?php echo home_url('/news-center/'); ?>">
                News & Updates
            </a>

            <a href="<?php echo home_url('/tenders/'); ?>">
                Tenders
            </a>

            <a href="<?php echo home_url('/careers/'); ?>">
                Vacancies
            </a>

            <a href="<?php echo home_url('/publications/'); ?>">
                Publications
            </a>

            <a href="<?php echo home_url('/events/'); ?>">
                Events
            </a>

        </div>


        <div class="footer-column footer-contact">

            <h3>Get In Touch</h3>

            <div class="contact-item">

                <i class="fas fa-location-dot"></i>

                <p>
                    <?php echo esc_html($footer['location']); ?>
                </p>

            </div>

            <div class="contact-item">

                <i class="fas fa-phone"></i>

                <p>
                    <?php echo esc_html($footer['phone']); ?>
                </p>

            </div>

            <div class="contact-item">

                <i class="fas fa-envelope"></i>

                <p>
                    <?php echo esc_html($footer['email']); ?>
                </p>

            </div>

            <div class="contact-item">

                <i class="fas fa-clock"></i>

                <p>
                    <?php echo esc_html($footer['hours']); ?>
                </p>

            </div>

        </div>

    </div>


    <div class="footer-newsletter">

        <div>

            <span>
                <?php echo esc_html($footer['newsletter_label']); ?>
            </span>

            <h3>
                <?php echo esc_html($footer['newsletter_heading']); ?>
            </h3>

        </div>

        <form>

            <input
                type="email"
                placeholder="<?php echo esc_attr($footer['newsletter_placeholder']); ?>"
            >

            <button type="submit">

                <?php echo esc_html($footer['newsletter_button']); ?>

                <i class="fas fa-arrow-right"></i>

            </button>

        </form>

    </div>


    <div class="footer-bottom">

        <p id="kudsic">
            <?php echo esc_html($footer['copyright']); ?>
        </p>

        <div>

            <a href="<?php echo esc_url($footer['privacy_url']); ?>">
                Privacy Policy
            </a>

            <a href="<?php echo esc_url($footer['terms_url']); ?>">
                Terms & Conditions
            </a>

        </div>

    </div>

</footer>


<?php wp_footer(); ?>

</body>
</html>

