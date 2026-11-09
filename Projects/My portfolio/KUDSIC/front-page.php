<?php get_header(); ?>

<?php

$homepage_id = get_option('page_on_front');

if (!$homepage_id) {
    $home_page = get_page_by_path('home');

    if ($home_page) {
        $homepage_id = $home_page->ID;
    }
}

$theme_uri = get_template_directory_uri();

$hero_defaults = array(

    1 => array(
        'number' => '01',
        'title' => "Investing Together,\nGrowing Together",
        'description' => 'Creating sustainable investment opportunities for Kenyans in the diaspora and at home.',
        'button_text' => 'DISCOVER KUDSIC',
        'button_url' => '#',
        'card_title' => 'Invest in Kenya',
        'card_description' => 'Connect your diaspora investments with meaningful opportunities that contribute to Kenya\'s economic growth.',
        'card_url' => '#',
        'image' => $theme_uri . '/images/image60.jpg'
    ),

    2 => array(
        'number' => '02',
        'title' => "Connecting the Diaspora,\nStrengthening Kenya",
        'description' => 'We create a bridge between Kenyans abroad and investment opportunities back home.',
        'button_text' => 'EXPLORE OPPORTUNITIES',
        'button_url' => '#',
        'card_title' => 'Diaspora Investment',
        'card_description' => 'Discover opportunities designed to help the Kenyan diaspora participate in Kenya\'s economic development.',
        'card_url' => '#',
        'image' => $theme_uri . '/images/image47.jpg'
    ),

    3 => array(
        'number' => '03',
        'title' => "Building Wealth,\nCreating Impact",
        'description' => 'Partner with KUDSIC and be part of a community investing in a stronger and more prosperous Kenya.',
        'button_text' => 'JOIN KUDSIC',
        'button_url' => '#',
        'card_title' => 'Your Future Matters',
        'card_description' => 'Turn your investment goals into meaningful opportunities for you, your family and the communities around you.',
        'card_url' => '#',
        'image' => $theme_uri . '/images/image62.jpg'
    )
);

$hero_slides = array();

for ($i = 1; $i <= 3; $i++) {

    $hero_slides[$i] = array();

    foreach ($hero_defaults[$i] as $field => $default) {

        $value = '';

        if ($homepage_id) {
            $value = get_post_meta(
                $homepage_id,
                '_kudsic_hero_' . $i . '_' . $field,
                true
            );
        }

        $hero_slides[$i][$field] = $value !== ''
            ? $value
            : $default;
    }
}

$display_slides = array(
    $hero_slides[1],
    $hero_slides[2],
    $hero_slides[3],
    $hero_slides[1]
);

?>

<section class="hero">

    <div class="hero-slides">

        <?php foreach ($display_slides as $index => $slide) : ?>

            <?php
            $slide_number = ($index % 3) + 1;
            ?>

            <div
                class="hero-slide slide-<?php echo esc_attr($slide_number); ?>"
                style="<?php echo esc_attr('background-image: url("' . esc_url($slide['image']) . '");'); ?>"
            >

                <div class="hero-overlay"></div>

                <div class="hero-content">

                    <h2>
                        <?php echo nl2br(esc_html($slide['title'])); ?>
                    </h2>

                    <p>
                        <?php echo esc_html($slide['description']); ?>
                    </p>

                    <a
                        href="<?php echo esc_url($slide['button_url']); ?>"
                        class="hero-button"
                    >
                        <?php echo esc_html($slide['button_text']); ?>
                    </a>

                </div>

                <div class="hero-card">

                    <div class="card-number">
                        <?php echo esc_html($slide['number']); ?>
                    </div>

                    <h3>
                        <?php echo esc_html($slide['card_title']); ?>
                    </h3>

                    <p>
                        <?php echo esc_html($slide['card_description']); ?>
                    </p>

                    <a href="<?php echo esc_url($slide['card_url']); ?>">
                        Learn More
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

    <button class="hero-arrow left-arrow">
        <i class="fa-solid fa-chevron-left"></i>
    </button>

    <button class="hero-arrow right-arrow">
        <i class="fa-solid fa-chevron-right"></i>
    </button>

    <div class="slide-indicators">

        <span class="indicator active"></span>
        <span class="indicator"></span>
        <span class="indicator"></span>

    </div>

</section>
<?php

$homepage_id = get_option('page_on_front');

if (!$homepage_id) {
    $home_page = get_page_by_path('home');

    if ($home_page) {
        $homepage_id = $home_page->ID;
    }
}

$about_defaults = array(

    'label' => 'ABOUT KUDSIC',

    'heading' => "Transforming Urban Development\nAcross Kenya",

    'intro' => 'KUDSIC is committed to supporting sustainable urban development, improving communities and creating better opportunities for people across Kenya.',

    'button_text' => 'Read More',

    'button_url' => home_url('/about-us/'),

    'vision_title' => 'Our Vision',

    'vision_text' => 'A transformed and sustainable urban environment that improves the quality of life for all.',

    'mission_title' => 'Our Mission',

    'mission_text' => 'To facilitate sustainable urban development through effective planning, investment and partnerships.',

    'values_title' => 'Our Values',

    'values_text' => 'Integrity, professionalism, accountability, innovation, inclusivity and excellence.',

    'stat_1_number' => '10+',
    'stat_1_label' => 'Years of Impact',

    'stat_2_number' => '20+',
    'stat_2_label' => 'Projects',

    'stat_3_number' => '47',
    'stat_3_label' => 'Counties',

    'stat_4_number' => '100+',
    'stat_4_label' => 'Communities Reached'
);

$about = array();

foreach ($about_defaults as $field => $default) {

    $value = '';

    if ($homepage_id) {
        $value = get_post_meta(
            $homepage_id,
            '_kudsic_about_' . $field,
            true
        );
    }

    $about[$field] = $value !== ''
        ? $value
        : $default;
}

?>

<section class="about-kudsic" id="about">

    <div class="about-container">

        <div class="about-content">

            <span class="section-label">
                <?php echo esc_html($about['label']); ?>
            </span>

            <h2>
                <?php echo nl2br(esc_html($about['heading'])); ?>
            </h2>

            <p class="about-intro">
                <?php echo esc_html($about['intro']); ?>
            </p>

            <a
                href="<?php echo esc_url($about['button_url']); ?>"
                class="about-btn"
            >
                <?php echo esc_html($about['button_text']); ?>
                <span>→</span>
            </a>

        </div>


        <div class="about-info">

            <div class="info-box">

                <div class="info-number">
                    01
                </div>

                <div>

                    <h3>
                        <?php echo esc_html($about['vision_title']); ?>
                    </h3>

                    <p>
                        <?php echo esc_html($about['vision_text']); ?>
                    </p>

                </div>

            </div>


            <div class="info-box">

                <div class="info-number">
                    02
                </div>

                <div>

                    <h3>
                        <?php echo esc_html($about['mission_title']); ?>
                    </h3>

                    <p>
                        <?php echo esc_html($about['mission_text']); ?>
                    </p>

                </div>

            </div>


            <div class="info-box">

                <div class="info-number">
                    03
                </div>

                <div>

                    <h3>
                        <?php echo esc_html($about['values_title']); ?>
                    </h3>

                    <p>
                        <?php echo esc_html($about['values_text']); ?>
                    </p>

                </div>

            </div>

        </div>

    </div>


    <div class="about-stats">

        <div class="stat-item">

            <h3>
                <?php echo esc_html($about['stat_1_number']); ?>
            </h3>

            <p>
                <?php echo esc_html($about['stat_1_label']); ?>
            </p>

        </div>


        <div class="stat-item">

            <h3>
                <?php echo esc_html($about['stat_2_number']); ?>
            </h3>

            <p>
                <?php echo esc_html($about['stat_2_label']); ?>
            </p>

        </div>


        <div class="stat-item">

            <h3>
                <?php echo esc_html($about['stat_3_number']); ?>
            </h3>

            <p>
                <?php echo esc_html($about['stat_3_label']); ?>
            </p>

        </div>


        <div class="stat-item">

            <h3>
                <?php echo esc_html($about['stat_4_number']); ?>
            </h3>

            <p>
                <?php echo esc_html($about['stat_4_label']); ?>
            </p>

        </div>

    </div>

</section>


<?php

$homepage_id = get_option('page_on_front');

if (!$homepage_id) {
    $home_page = get_page_by_path('home');
    if ($home_page) {
        $homepage_id = $home_page->ID;
    }
}

$investment_defaults = array(

    'heading' => 'Investment Opportunities',

    'intro' => 'Explore strategic investment opportunities designed to create long-term value and wealth for KUDSIC members.',

    1 => array(
        'icon' => 'fas fa-house',
        'title' => 'Property & Real Estate',
        'description' => 'Invest in carefully selected property opportunities designed to provide quality housing, ownership opportunities and long-term value.',
        'item_1' => 'Quality property opportunities',
        'item_2' => 'Strategic locations',
        'item_3' => 'Long-term value potential',
        'item_4' => 'Professional project management'
    ),

    2 => array(
        'icon' => 'fas fa-location-dot',
        'title' => 'Land Investment',
        'description' => 'Access strategically located land opportunities in high-growth areas, providing members with opportunities for ownership and future development.',
        'item_1' => 'Prime investment locations',
        'item_2' => 'Residential development potential',
        'item_3' => 'Infrastructure development',
        'item_4' => 'Secure land ownership'
    ),

    3 => array(
        'icon' => 'fas fa-chart-line',
        'title' => 'Strategic Investments',
        'description' => 'KUDSIC explores strategic investment initiatives that diversify opportunities and support wealth creation for members and other clients.',
        'item_1' => 'Diversified investment opportunities',
        'item_2' => 'Professional due diligence',
        'item_3' => 'Strategic partnerships',
        'item_4' => 'Long-term wealth creation'
    )
);


$investment_heading = get_post_meta(
    $homepage_id,
    '_kudsic_investment_heading',
    true
);

if ($investment_heading === '') {
    $investment_heading = $investment_defaults['heading'];
}


$investment_intro = get_post_meta(
    $homepage_id,
    '_kudsic_investment_intro',
    true
);

if ($investment_intro === '') {
    $investment_intro = $investment_defaults['intro'];
}


$investment_cards = array();

for ($i = 1; $i <= 3; $i++) {

    $investment_cards[$i] = array();

    foreach ($investment_defaults[$i] as $field => $default) {

        $value = get_post_meta(
            $homepage_id,
            '_kudsic_investment_' . $i . '_' . $field,
            true
        );

        if ($value === '') {
            $value = $default;
        }

        $investment_cards[$i][$field] = $value;
    }
}

?>


<section class="investment-section">

    <div class="investment-header">

        <h2>
            <?php echo esc_html($investment_heading); ?>
        </h2>

        <div class="investment-line"></div>

        <p>
            <?php echo esc_html($investment_intro); ?>
        </p>

    </div>


    <div class="investment-container">


        <?php for ($i = 1; $i <= 3; $i++) : ?>

            <div class="investment-card">

                <div class="investment-icon">
                    <i class="<?php echo esc_attr($investment_cards[$i]['icon']); ?>"></i>
                </div>

                <h3>
                    <?php echo esc_html($investment_cards[$i]['title']); ?>
                </h3>

                <p>
                    <?php echo esc_html($investment_cards[$i]['description']); ?>
                </p>

                <ul>

                    <li>
                        <?php echo esc_html($investment_cards[$i]['item_1']); ?>
                    </li>

                    <li>
                        <?php echo esc_html($investment_cards[$i]['item_2']); ?>
                    </li>

                    <li>
                        <?php echo esc_html($investment_cards[$i]['item_3']); ?>
                    </li>

                    <li>
                        <?php echo esc_html($investment_cards[$i]['item_4']); ?>
                    </li>

                </ul>

            </div>

        <?php endfor; ?>


    </div>

</section>

<?php

$homepage_id = get_option('page_on_front');

if (!$homepage_id) {
    $home_page = get_page_by_path('home');

    if ($home_page) {
        $homepage_id = $home_page->ID;
    }
}


$project_defaults = array(

    1 => array(
        'category' => 'RESIDENTIAL DEVELOPMENT',
        'title' => 'Fadhili Homes',
        'description' => 'A thoughtfully planned residential development designed for comfortable community living.',
        'image_url' => get_template_directory_uri() . '/images/image54.jpg',
        'link' => home_url('/projects/')
    ),

    2 => array(
        'category' => 'LAND INVESTMENT',
        'title' => 'Kisaju Diaspora Meadows',
        'description' => 'A strategic land investment project in one of the rapidly developing areas of Kajiado County.',
        'image_url' => get_template_directory_uri() . '/images/image53.jpg',
        'link' => home_url('/projects/')
    ),

    3 => array(
        'category' => 'PROPERTY DEVELOPMENT',
        'title' => 'Community Development',
        'description' => 'Creating sustainable spaces that support investment, growth and better living.',
        'image_url' => get_template_directory_uri() . '/images/image52.png',
        'link' => home_url('/projects/')
    ),

    4 => array(
        'category' => 'INVESTMENT',
        'title' => 'Strategic Investments',
        'description' => 'Investment opportunities designed to generate long-term value for members.',
        'image_url' => get_template_directory_uri() . '/images/image50.jpg',
        'link' => home_url('/projects/')
    ),

    5 => array(
        'category' => 'DEVELOPMENT',
        'title' => 'Future Developments',
        'description' => 'Expanding our portfolio through carefully planned development opportunities.',
        'image_url' => get_template_directory_uri() . '/images/image51.webp',
        'link' => home_url('/projects/')
    ),

    6 => array(
        'category' => 'COMMUNITY',
        'title' => 'Community Projects',
        'description' => 'Projects focused on creating sustainable opportunities for communities and investors.',
        'image_url' => get_template_directory_uri() . '/images/img44.jpg',
        'link' => home_url('/projects/')
    )
);


$projects = array();


for ($i = 1; $i <= 6; $i++) {

    $projects[$i] = array();

    foreach ($project_defaults[$i] as $field => $default) {

        $meta_key = '_kudsic_project_' . $i . '_' . $field;

        $value = get_post_meta(
            $homepage_id,
            $meta_key,
            true
        );

        if ($value === '') {
            $value = $default;
        }

        $projects[$i][$field] = $value;
    }
}

?>


<section class="projects-section">

    <div class="projects-header">

        <div>

            <span class="section-tag">
                OUR PROJECTS
            </span>

            <h2>
                Building Opportunities,<br>
                <span>Creating Value.</span>
            </h2>

        </div>

        <p>
            Explore some of the investment and development projects
            delivered by KUDSIC to create meaningful opportunities
            for our members and communities.
        </p>

    </div>


    <div class="projects-slider">

        <div class="projects-track">


            <?php for ($i = 1; $i <= 6; $i++) : ?>

                <div class="project-card">

                    <div class="project-image">

                        <img
                            src="<?php echo esc_url($projects[$i]['image_url']); ?>"
                            alt="<?php echo esc_attr($projects[$i]['title']); ?>"
                        >

                        <span class="project-number">
                            <?php echo sprintf('%02d', $i); ?>
                        </span>

                    </div>


                    <div class="project-content">

                        <span>
                            <?php echo esc_html($projects[$i]['category']); ?>
                        </span>

                        <h3>
                            <?php echo esc_html($projects[$i]['title']); ?>
                        </h3>

                        <p>
                            <?php echo esc_html($projects[$i]['description']); ?>
                        </p>

                        <a href="<?php echo esc_url($projects[$i]['link']); ?>">
                            Explore Project →
                        </a>

                    </div>

                </div>

            <?php endfor; ?>


        </div>

    </div>


    <div class="projects-bottom">

        <span>01 — 06</span>

        <div class="project-line"></div>

        <a href="<?php echo esc_url(home_url('/projects/')); ?>">
            View All Projects →
        </a>

    </div>

</section>

<section class="news-section">

    <div class="news-header">
        <span class="section-tag">LATEST NEWS</span>
        <h2>News & Updates</h2>
        <p>Stay updated with the latest news and developments from KUDSIC.</p>
    </div>

    <div class="news-container">

        <?php
        $news_query = new WP_Query(array(
            'post_type'      => 'post',
            'posts_per_page' => 3,
            'category_name'  => 'news'
        ));

        if ($news_query->have_posts()) :

            while ($news_query->have_posts()) :
                $news_query->the_post();
        ?>

            <article class="news-card">

                <?php if (has_post_thumbnail()) : ?>
                    <div class="news-image">
                        <?php the_post_thumbnail('medium'); ?>
                    </div>
                <?php endif; ?>

                <div class="news-content">

                    <span class="news-date">
                        <?php echo get_the_date(); ?>
                    </span>

                    <h3>
                        <?php the_title(); ?>
                    </h3>

                    <p>
                        <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                    </p>

                    <a href="<?php the_permalink(); ?>">
                        Read More →
                    </a>

                </div>

            </article>

        <?php
            endwhile;

            wp_reset_postdata();

        else :
        ?>

            <p>No news updates available yet.</p>

        <?php endif; ?>

    </div>

</section>
<section class="tenders-section">

    <div class="tenders-header">
        <span class="section-tag">TENDERS</span>

        <h2>Latest Tenders</h2>

        <p>
            View the latest tender opportunities and procurement
            announcements from KUDSIC.
        </p>
    </div>

    <div class="tenders-container">

        <?php
        $tenders_query = new WP_Query(array(
            'post_type'      => 'post',
            'posts_per_page' => 3,
            'category_name'  => 'tenders'
        ));

        if ($tenders_query->have_posts()) :

            while ($tenders_query->have_posts()) :
                $tenders_query->the_post();
        ?>

            <article class="tender-card">

                <?php if (has_post_thumbnail()) : ?>

                    <div class="tender-image">
                        <?php the_post_thumbnail('medium'); ?>
                    </div>

                <?php endif; ?>

                <div class="tender-content">

                    <span class="tender-date">
                        <?php echo get_the_date(); ?>
                    </span>

                    <h3>
                        <?php the_title(); ?>
                    </h3>

                    <p>
                        <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                    </p>

                    <a href="<?php the_permalink(); ?>">
                        View Tender →
                    </a>

                </div>

            </article>

        <?php
            endwhile;

            wp_reset_postdata();

        else :
        ?>

            <p>No tenders available at the moment.</p>

        <?php endif; ?>

    </div>

</section>
<section class="vacancies-section">

    <div class="vacancies-header">
        <span class="section-tag">CAREERS</span>

        <h2>Latest Vacancies</h2>

        <p>
            Explore career opportunities and current vacancies at KUDSIC.
        </p>
    </div>

    <div class="vacancies-container">

        <?php
        $vacancies_query = new WP_Query(array(
            'post_type'      => 'post',
            'posts_per_page' => 3,
            'category_name'  => 'vacancies'
        ));

        if ($vacancies_query->have_posts()) :

            while ($vacancies_query->have_posts()) :
                $vacancies_query->the_post();
        ?>

            <article class="vacancy-card">

                <div class="vacancy-content">

                    <span class="vacancy-date">
                        <?php echo get_the_date(); ?>
                    </span>

                    <h3>
                        <?php the_title(); ?>
                    </h3>

                    <p>
                        <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                    </p>

                    <a href="<?php the_permalink(); ?>">
                        View Vacancy →
                    </a>

                </div>

            </article>

        <?php
            endwhile;

            wp_reset_postdata();

        else :
        ?>

            <p>No vacancies available at the moment.</p>

        <?php endif; ?>

    </div>

</section>
<section class="publications-section">

    <div class="publications-header">
        <span class="section-tag">PUBLICATIONS</span>

        <h2>Latest Publications</h2>

        <p>
            Access the latest reports, documents and publications from KUDSIC.
        </p>
    </div>

    <div class="publications-container">

        <?php
        $publications_query = new WP_Query(array(
            'post_type'      => 'post',
            'posts_per_page' => 3,
            'category_name'  => 'publications'
        ));

        if ($publications_query->have_posts()) :

            while ($publications_query->have_posts()) :
                $publications_query->the_post();
        ?>

            <article class="publication-card">

                <div class="publication-content">

                    <span class="publication-date">
                        <?php echo get_the_date(); ?>
                    </span>

                    <h3>
                        <?php the_title(); ?>
                    </h3>

                    <p>
                        <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                    </p>

                    <a href="<?php the_permalink(); ?>">
                        Read Publication →
                    </a>

                </div>

            </article>

        <?php
            endwhile;

            wp_reset_postdata();

        else :
        ?>

            <p>No publications available at the moment.</p>

        <?php endif; ?>

    </div>

</section>
<section class="events-section">

    <div class="events-header">
        <span class="section-tag">EVENTS</span>

        <h2>Upcoming Events</h2>

        <p>
            Stay informed about upcoming KUDSIC events, meetings and activities.
        </p>
    </div>

    <div class="events-container">

        <?php
        $events_query = new WP_Query(array(
            'post_type'      => 'post',
            'posts_per_page' => 3,
            'category_name'  => 'events'
        ));

        if ($events_query->have_posts()) :

            while ($events_query->have_posts()) :
                $events_query->the_post();
        ?>

            <article class="event-card">
    <?php if (has_post_thumbnail()) : ?>
        <div class="event-image">
            <?php the_post_thumbnail('medium'); ?>
        </div>
    <?php endif; ?>

    <div class="event-content">
        <span class="event-date"><?php echo get_the_date(); ?></span>
        <h3><?php the_title(); ?></h3>
        <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
        <a href="<?php the_permalink(); ?>">View Event →</a>
    </div>
</article>

        <?php
            endwhile;

            wp_reset_postdata();

        else :
        ?>

            <p>No upcoming events available at the moment.</p>

        <?php endif; ?>

    </div>

</section>

<?php get_footer(); ?>
