<?php

$homepage_id = get_option('page_on_front');

if (!$homepage_id) {
    $home_page = get_page_by_path('home');

    if ($home_page) {
        $homepage_id = $home_page->ID;
    }
}

$header_defaults = array(

    'logo_url' => get_template_directory_uri() . '/images/LOGO1.png',

    'top_home_label' => 'Home',
    'top_home_url' => home_url('/'),

    'top_about_label' => 'About Us',
    'top_about_url' => home_url('/about-us/'),

    'top_news_label' => 'News Centre',
    'top_news_url' => home_url('/news-center/'),

    'top_events_label' => 'Events',
    'top_events_url' => home_url('/events/'),

    'top_careers_label' => 'Careers',
    'top_careers_url' => home_url('/careers/'),

    'top_tenders_label' => 'Tenders',
    'top_tenders_url' => home_url('/tenders/'),

    'facebook' => '#',
    'twitter' => '#',
    'youtube' => '#',
    'linkedin' => '#',
    'whatsapp' => '#',

    'search_url' => '#',

    'branding_promotions_label' => 'Promotions',
    'branding_promotions_url' => home_url('/promotions/'),

    'branding_publications_label' => 'Publications',
    'branding_publications_url' => home_url('/publications/'),

    'branding_projects_label' => 'Projects',
    'branding_projects_url' => home_url('/projects/'),

    'branding_members_label' => 'Member Portals',
    'branding_members_url' => home_url('/members-portal/'),

    'branding_employer_label' => 'Employer Portals',
    'branding_employer_url' => home_url('/employer-portal/')
);

$header = array();

foreach ($header_defaults as $field => $default) {

    $value = '';

    if ($homepage_id) {
        $value = get_post_meta(
            $homepage_id,
            '_kudsic_header_' . $field,
            true
        );
    }

    if ($value === '') {
        $value = $default;
    }

    $header[$field] = $value;
}

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

    <meta charset="<?php bloginfo('charset'); ?>">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<nav class="top-nav">

    <div class="nav-left">

        <a href="<?php echo esc_url($header['top_home_url']); ?>">
            <?php echo esc_html($header['top_home_label']); ?>
        </a>

        <a href="<?php echo esc_url($header['top_about_url']); ?>">
            <?php echo esc_html($header['top_about_label']); ?>
            <i class="fa-solid fa-chevron-down"></i>
        </a>

        <a href="<?php echo esc_url($header['top_news_url']); ?>">
            <?php echo esc_html($header['top_news_label']); ?>
        </a>

        <a href="<?php echo esc_url($header['top_events_url']); ?>">
            <?php echo esc_html($header['top_events_label']); ?>
        </a>

        <a href="<?php echo esc_url($header['top_careers_url']); ?>">
            <?php echo esc_html($header['top_careers_label']); ?>
            <i class="fa-solid fa-chevron-down"></i>
        </a>

        <a href="<?php echo esc_url($header['top_tenders_url']); ?>">
            <?php echo esc_html($header['top_tenders_label']); ?>
        </a>

    </div>

    <div class="nav-right">

        <div class="social-icons">

            <a href="<?php echo esc_url($header['facebook']); ?>">
                <i class="fab fa-facebook-f"></i>
            </a>

            <a href="<?php echo esc_url($header['twitter']); ?>">
                <i class="fab fa-x-twitter"></i>
            </a>

            <a href="<?php echo esc_url($header['youtube']); ?>">
                <i class="fab fa-youtube"></i>
            </a>

            <a href="<?php echo esc_url($header['linkedin']); ?>">
                <i class="fab fa-linkedin-in"></i>
            </a>

            <a href="<?php echo esc_url($header['whatsapp']); ?>">
                <i class="fab fa-whatsapp"></i>
            </a>

        </div>

        <a href="<?php echo esc_url($header['search_url']); ?>"
           class="search-btn">

            <i class="fa-solid fa-magnifying-glass"></i>

        </a>

    </div>

</nav>

<header class="branding-header">

    <div class="logo-area">

        <img src="<?php echo esc_url($header['logo_url']); ?>"
             alt="KUDSIC Logo">

    </div>

    <div class="branding-nav">

        <a href="<?php echo esc_url($header['branding_promotions_url']); ?>">
            <?php echo esc_html($header['branding_promotions_label']); ?>
        </a>

        <a href="<?php echo esc_url($header['branding_publications_url']); ?>">
            <?php echo esc_html($header['branding_publications_label']); ?>
        </a>

        <a href="<?php echo esc_url($header['branding_projects_url']); ?>">
            <?php echo esc_html($header['branding_projects_label']); ?>
        </a>

        <a href="<?php echo esc_url($header['branding_members_url']); ?>">
            <?php echo esc_html($header['branding_members_label']); ?>
        </a>

        <a href="<?php echo esc_url($header['branding_employer_url']); ?>">
            <?php echo esc_html($header['branding_employer_label']); ?>
            <i class="fa-solid fa-chevron-down"></i>
        </a>

    </div>

</header>