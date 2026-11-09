<?php

function kudsic_theme_setup() {

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');

    register_nav_menus(array(
        'primary' => 'Primary Menu'
    ));
}

add_action('after_setup_theme', 'kudsic_theme_setup');


function kudsic_enqueue_styles() {

    wp_enqueue_style(
        'kudsic-style',
        get_stylesheet_uri()
    );
}

add_action('wp_enqueue_scripts', 'kudsic_enqueue_styles');


function kudsic_homepage_admin_assets($hook) {

    if ($hook !== 'post.php' && $hook !== 'post-new.php') {
        return;
    }

    $screen = get_current_screen();

    if (!$screen || $screen->post_type !== 'page') {
        return;
    }

    wp_enqueue_media();
}

add_action('admin_enqueue_scripts', 'kudsic_homepage_admin_assets');


function kudsic_add_homepage_meta_box($post) {

    if (!$post || $post->post_type !== 'page') {
        return;
    }

    $homepage_id = get_option('page_on_front');

    if (
        ($homepage_id && $post->ID == $homepage_id) ||
        $post->post_name === 'home'
    ) {

        add_meta_box(
            'kudsic_homepage_hero',
            'KUDSIC Homepage Hero',
            'kudsic_homepage_hero_meta_box',
            'page',
            'normal',
            'high'
        );
    }
}

add_action('add_meta_boxes_page', 'kudsic_add_homepage_meta_box');


function kudsic_homepage_hero_meta_box($post) {

    wp_nonce_field(
        'kudsic_save_homepage_hero',
        'kudsic_homepage_hero_nonce'
    );

    $theme_uri = get_template_directory_uri();

    $defaults = array(

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

    echo '<p>These fields control the three slides displayed on the KUDSIC homepage.</p>';

    for ($i = 1; $i <= 3; $i++) {

        echo '<div style="border:1px solid #ddd;padding:20px;margin:20px 0;background:#fafafa;">';

        echo '<h2 style="margin-top:0;">Hero Slide ' . $i . '</h2>';

        $fields = array(
            'number' => 'Card Number',
            'title' => 'Hero Heading',
            'description' => 'Hero Description',
            'button_text' => 'Hero Button Text',
            'button_url' => 'Hero Button URL',
            'card_title' => 'Card Heading',
            'card_description' => 'Card Description',
            'card_url' => 'Card Link URL',
            'image' => 'Hero Background Image'
        );

        foreach ($fields as $field => $label) {

            $meta_key = '_kudsic_hero_' . $i . '_' . $field;

            $value = get_post_meta(
                $post->ID,
                $meta_key,
                true
            );

            if ($value === '') {
                $value = $defaults[$i][$field];
            }

            echo '<p>';

            echo '<label for="kudsic_hero_' . $i . '_' . $field . '">';
            echo '<strong>' . esc_html($label) . '</strong>';
            echo '</label><br>';

            if (
                $field === 'title' ||
                $field === 'description' ||
                $field === 'card_description'
            ) {

                echo '<textarea
                    name="kudsic_hero_' . $i . '_' . $field . '"
                    id="kudsic_hero_' . $i . '_' . $field . '"
                    rows="4"
                    style="width:100%;max-width:800px;"
                >' . esc_textarea($value) . '</textarea>';

            } elseif ($field === 'image') {

                echo '<input
                    type="text"
                    name="kudsic_hero_' . $i . '_image"
                    id="kudsic_hero_' . $i . '_image"
                    value="' . esc_attr($value) . '"
                    style="width:80%;"
                >';

                echo ' <button
                    type="button"
                    class="button kudsic-upload-image"
                    data-target="kudsic_hero_' . $i . '_image"
                    data-preview="kudsic_preview_' . $i . '"
                >Select Image</button>';

                echo '<div style="margin-top:10px;">';

                echo '<img
                    id="kudsic_preview_' . $i . '"
                    src="' . esc_url($value) . '"
                    style="max-width:300px;height:auto;display:block;"
                >';

                echo '</div>';

            } else {

                echo '<input
                    type="text"
                    name="kudsic_hero_' . $i . '_' . $field . '"
                    id="kudsic_hero_' . $i . '_' . $field . '"
                    value="' . esc_attr($value) . '"
                    style="width:100%;max-width:800px;"
                >';
            }

            echo '</p>';
        }

        echo '</div>';
    }

    ?>

    <script>
    jQuery(document).ready(function($) {

        $('.kudsic-upload-image').on('click', function(e) {

            e.preventDefault();

            const button = $(this);
            const target = $('#' + button.data('target'));
            const preview = $('#' + button.data('preview'));

            const frame = wp.media({
                title: 'Select Hero Background Image',
                button: {
                    text: 'Use This Image'
                },
                multiple: false
            });

            frame.on('select', function() {

                const attachment = frame
                    .state()
                    .get('selection')
                    .first()
                    .toJSON();

                target.val(attachment.url);

                preview.attr('src', attachment.url);
            });

            frame.open();
        });

    });
    </script>

    <?php
}


function kudsic_save_homepage_hero($post_id) {

    if (
        !isset($_POST['kudsic_homepage_hero_nonce']) ||
        !wp_verify_nonce(
            $_POST['kudsic_homepage_hero_nonce'],
            'kudsic_save_homepage_hero'
        )
    ) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (
        isset($_POST['post_type']) &&
        $_POST['post_type'] === 'page' &&
        !current_user_can('edit_page', $post_id)
    ) {
        return;
    }

    $post = get_post($post_id);

    if (!$post || $post->post_type !== 'page') {
        return;
    }

    $homepage_id = get_option('page_on_front');

    if (
        !(
            ($homepage_id && $post_id == $homepage_id) ||
            $post->post_name === 'home'
        )
    ) {
        return;
    }

    for ($i = 1; $i <= 3; $i++) {

        $fields = array(
            'number',
            'title',
            'description',
            'button_text',
            'button_url',
            'card_title',
            'card_description',
            'card_url',
            'image'
        );

        foreach ($fields as $field) {

            $input_name = 'kudsic_hero_' . $i . '_' . $field;
            $meta_key = '_kudsic_hero_' . $i . '_' . $field;

            if (!isset($_POST[$input_name])) {
                continue;
            }

            $value = wp_unslash($_POST[$input_name]);

            if (
                $field === 'button_url' ||
                $field === 'card_url' ||
                $field === 'image'
            ) {

                $value = esc_url_raw($value);

            } elseif (
                $field === 'title' ||
                $field === 'description' ||
                $field === 'card_description'
            ) {

                $value = sanitize_textarea_field($value);

            } else {

                $value = sanitize_text_field($value);
            }

            update_post_meta(
                $post_id,
                $meta_key,
                $value
            );
        }
    }
}

add_action('save_post_page', 'kudsic_save_homepage_hero');
function kudsic_add_homepage_about_meta_box($post) {

    $homepage_id = get_option('page_on_front');

    if (
        !(
            ($homepage_id && $post->ID == $homepage_id) ||
            $post->post_name === 'home'
        )
    ) {
        return;
    }

    add_meta_box(
        'kudsic_homepage_about',
        'KUDSIC Homepage - About Section',
        'kudsic_homepage_about_meta_box',
        'page',
        'normal',
        'high'
    );
}

add_action('add_meta_boxes_page', 'kudsic_add_homepage_about_meta_box');


function kudsic_homepage_about_meta_box($post) {

    wp_nonce_field(
        'kudsic_save_homepage_about',
        'kudsic_homepage_about_nonce'
    );

    $fields = array(

        'label' => array(
            'label' => 'Section Label',
            'default' => 'ABOUT KUDSIC',
            'type' => 'text'
        ),

        'heading' => array(
            'label' => 'Main Heading',
            'default' => "Transforming Urban Development\nAcross Kenya",
            'type' => 'textarea'
        ),

        'intro' => array(
            'label' => 'Introduction',
            'default' => 'KUDSIC is committed to supporting sustainable urban development, improving communities and creating better opportunities for people across Kenya.',
            'type' => 'textarea'
        ),

        'button_text' => array(
            'label' => 'Button Text',
            'default' => 'Read More',
            'type' => 'text'
        ),

        'button_url' => array(
            'label' => 'Button URL',
            'default' => home_url('/about-us/'),
            'type' => 'text'
        ),

        'vision_title' => array(
            'label' => 'Vision Title',
            'default' => 'Our Vision',
            'type' => 'text'
        ),

        'vision_text' => array(
            'label' => 'Vision Description',
            'default' => 'A transformed and sustainable urban environment that improves the quality of life for all.',
            'type' => 'textarea'
        ),

        'mission_title' => array(
            'label' => 'Mission Title',
            'default' => 'Our Mission',
            'type' => 'text'
        ),

        'mission_text' => array(
            'label' => 'Mission Description',
            'default' => 'To facilitate sustainable urban development through effective planning, investment and partnerships.',
            'type' => 'textarea'
        ),

        'values_title' => array(
            'label' => 'Values Title',
            'default' => 'Our Values',
            'type' => 'text'
        ),

        'values_text' => array(
            'label' => 'Values Description',
            'default' => 'Integrity, professionalism, accountability, innovation, inclusivity and excellence.',
            'type' => 'textarea'
        ),

        'stat_1_number' => array(
            'label' => 'Statistic 1 Number',
            'default' => '10+',
            'type' => 'text'
        ),

        'stat_1_label' => array(
            'label' => 'Statistic 1 Label',
            'default' => 'Years of Impact',
            'type' => 'text'
        ),

        'stat_2_number' => array(
            'label' => 'Statistic 2 Number',
            'default' => '20+',
            'type' => 'text'
        ),

        'stat_2_label' => array(
            'label' => 'Statistic 2 Label',
            'default' => 'Projects',
            'type' => 'text'
        ),

        'stat_3_number' => array(
            'label' => 'Statistic 3 Number',
            'default' => '47',
            'type' => 'text'
        ),

        'stat_3_label' => array(
            'label' => 'Statistic 3 Label',
            'default' => 'Counties',
            'type' => 'text'
        ),

        'stat_4_number' => array(
            'label' => 'Statistic 4 Number',
            'default' => '100+',
            'type' => 'text'
        ),

        'stat_4_label' => array(
            'label' => 'Statistic 4 Label',
            'default' => 'Communities Reached',
            'type' => 'text'
        )
    );

    echo '<p>Edit the About section and statistics displayed on the KUDSIC homepage.</p>';

    foreach ($fields as $field => $settings) {

        $meta_key = '_kudsic_about_' . $field;

        $value = get_post_meta(
            $post->ID,
            $meta_key,
            true
        );

        if ($value === '') {
            $value = $settings['default'];
        }

        echo '<p>';

        echo '<label>';
        echo '<strong>' . esc_html($settings['label']) . '</strong>';
        echo '</label><br>';

        if ($settings['type'] === 'textarea') {

            echo '<textarea
                name="kudsic_about_' . esc_attr($field) . '"
                rows="4"
                style="width:100%;max-width:800px;"
            >' . esc_textarea($value) . '</textarea>';

        } else {

            echo '<input
                type="text"
                name="kudsic_about_' . esc_attr($field) . '"
                value="' . esc_attr($value) . '"
                style="width:100%;max-width:800px;"
            >';
        }

        echo '</p>';
    }
}


function kudsic_save_homepage_about($post_id) {

    if (
        !isset($_POST['kudsic_homepage_about_nonce']) ||
        !wp_verify_nonce(
            $_POST['kudsic_homepage_about_nonce'],
            'kudsic_save_homepage_about'
        )
    ) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    $post = get_post($post_id);

    if (!$post || $post->post_type !== 'page') {
        return;
    }

    $homepage_id = get_option('page_on_front');

    if (
        !(
            ($homepage_id && $post_id == $homepage_id) ||
            $post->post_name === 'home'
        )
    ) {
        return;
    }

    $fields = array(
        'label',
        'heading',
        'intro',
        'button_text',
        'button_url',
        'vision_title',
        'vision_text',
        'mission_title',
        'mission_text',
        'values_title',
        'values_text',
        'stat_1_number',
        'stat_1_label',
        'stat_2_number',
        'stat_2_label',
        'stat_3_number',
        'stat_3_label',
        'stat_4_number',
        'stat_4_label'
    );

    foreach ($fields as $field) {

        $input_name = 'kudsic_about_' . $field;
        $meta_key = '_kudsic_about_' . $field;

        if (!isset($_POST[$input_name])) {
            continue;
        }

        $value = wp_unslash($_POST[$input_name]);

        if ($field === 'button_url') {

            $value = esc_url_raw($value);

        } elseif (
            strpos($field, 'text') !== false ||
            $field === 'heading' ||
            $field === 'intro'
        ) {

            $value = sanitize_textarea_field($value);

        } else {

            $value = sanitize_text_field($value);
        }

        update_post_meta(
            $post_id,
            $meta_key,
            $value
        );
    }
}

add_action('save_post_page', 'kudsic_save_homepage_about');
function kudsic_add_homepage_investment_meta_box($post) {

    if (!$post || $post->post_type !== 'page') {
        return;
    }

    add_meta_box(
        'kudsic_homepage_investments',
        'KUDSIC Homepage - Investment Opportunities',
        'kudsic_homepage_investment_meta_box',
        'page',
        'normal',
        'high'
    );
}

add_action('add_meta_boxes_page', 'kudsic_add_homepage_investment_meta_box');


function kudsic_homepage_investment_meta_box($post) {

    wp_nonce_field(
        'kudsic_save_homepage_investments',
        'kudsic_homepage_investments_nonce'
    );

    $fields = array(

        'heading' => array(
            'label' => 'Section Heading',
            'default' => 'Investment Opportunities',
            'type' => 'text'
        ),

        'intro' => array(
            'label' => 'Section Introduction',
            'default' => 'Explore strategic investment opportunities designed to create long-term value and wealth for KUDSIC members.',
            'type' => 'textarea'
        )
    );

    echo '<p>Edit the Investment Opportunities section displayed on the homepage.</p>';

    foreach ($fields as $field => $settings) {

        $meta_key = '_kudsic_investment_' . $field;

        $value = get_post_meta(
            $post->ID,
            $meta_key,
            true
        );

        if ($value === '') {
            $value = $settings['default'];
        }

        echo '<p>';

        echo '<label>';
        echo '<strong>' . esc_html($settings['label']) . '</strong>';
        echo '</label><br>';

        if ($settings['type'] === 'textarea') {

            echo '<textarea
                name="kudsic_investment_' . esc_attr($field) . '"
                rows="4"
                style="width:100%;max-width:800px;"
            >' . esc_textarea($value) . '</textarea>';

        } else {

            echo '<input
                type="text"
                name="kudsic_investment_' . esc_attr($field) . '"
                value="' . esc_attr($value) . '"
                style="width:100%;max-width:800px;"
            >';
        }

        echo '</p>';
    }


    $defaults = array(

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


    for ($i = 1; $i <= 3; $i++) {

        echo '<div style="border:1px solid #ddd;padding:20px;margin:20px 0;background:#fafafa;">';

        echo '<h2 style="margin-top:0;">Investment Card ' . $i . '</h2>';

        $card_fields = array(
            'icon' => 'Font Awesome Icon',
            'title' => 'Card Title',
            'description' => 'Card Description',
            'item_1' => 'Bullet Point 1',
            'item_2' => 'Bullet Point 2',
            'item_3' => 'Bullet Point 3',
            'item_4' => 'Bullet Point 4'
        );

        foreach ($card_fields as $field => $label) {

            $meta_key = '_kudsic_investment_' . $i . '_' . $field;

            $value = get_post_meta(
                $post->ID,
                $meta_key,
                true
            );

            if ($value === '') {
                $value = $defaults[$i][$field];
            }

            echo '<p>';

            echo '<label>';
            echo '<strong>' . esc_html($label) . '</strong>';
            echo '</label><br>';

            if ($field === 'description') {

                echo '<textarea
                    name="kudsic_investment_' . $i . '_' . $field . '"
                    rows="4"
                    style="width:100%;max-width:800px;"
                >' . esc_textarea($value) . '</textarea>';

            } else {

                echo '<input
                    type="text"
                    name="kudsic_investment_' . $i . '_' . $field . '"
                    value="' . esc_attr($value) . '"
                    style="width:100%;max-width:800px;"
                >';
            }

            echo '</p>';
        }

        echo '</div>';
    }
}


function kudsic_save_homepage_investments($post_id) {

    if (
        !isset($_POST['kudsic_homepage_investments_nonce']) ||
        !wp_verify_nonce(
            $_POST['kudsic_homepage_investments_nonce'],
            'kudsic_save_homepage_investments'
        )
    ) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    $post = get_post($post_id);

    if (!$post || $post->post_type !== 'page') {
        return;
    }

    $fields = array(
        'heading',
        'intro'
    );

    foreach ($fields as $field) {

        $input_name = 'kudsic_investment_' . $field;
        $meta_key = '_kudsic_investment_' . $field;

        if (!isset($_POST[$input_name])) {
            continue;
        }

        $value = wp_unslash($_POST[$input_name]);

        if ($field === 'intro') {
            $value = sanitize_textarea_field($value);
        } else {
            $value = sanitize_text_field($value);
        }

        update_post_meta(
            $post_id,
            $meta_key,
            $value
        );
    }


    for ($i = 1; $i <= 3; $i++) {

        $card_fields = array(
            'icon',
            'title',
            'description',
            'item_1',
            'item_2',
            'item_3',
            'item_4'
        );

        foreach ($card_fields as $field) {

            $input_name = 'kudsic_investment_' . $i . '_' . $field;
            $meta_key = '_kudsic_investment_' . $i . '_' . $field;

            if (!isset($_POST[$input_name])) {
                continue;
            }

            $value = wp_unslash($_POST[$input_name]);

            if ($field === 'description') {
                $value = sanitize_textarea_field($value);
            } else {
                $value = sanitize_text_field($value);
            }

            update_post_meta(
                $post_id,
                $meta_key,
                $value
            );
        }
    }
}

add_action('save_post_page', 'kudsic_save_homepage_investments');


function kudsic_add_homepage_projects_meta_box($post) {

    if (!$post || $post->post_type !== 'page') {
        return;
    }

    add_meta_box(
        'kudsic_homepage_projects',
        'KUDSIC Homepage - Projects',
        'kudsic_homepage_projects_meta_box',
        'page',
        'normal',
        'high'
    );
}

add_action('add_meta_boxes_page', 'kudsic_add_homepage_projects_meta_box');


function kudsic_homepage_projects_meta_box($post) {

    wp_nonce_field(
        'kudsic_save_homepage_projects',
        'kudsic_homepage_projects_nonce'
    );


    $defaults = array(

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


    echo '<p>Edit the Projects section displayed on the homepage.</p>';


    for ($i = 1; $i <= 6; $i++) {

        echo '<div style="border:1px solid #ddd;padding:20px;margin:20px 0;background:#fafafa;">';

        echo '<h2 style="margin-top:0;">Project ' . $i . '</h2>';


        $fields = array(

            'category' => 'Project Category',

            'title' => 'Project Title',

            'description' => 'Project Description',

            'link' => 'Project Link'

        );


        foreach ($fields as $field => $label) {

            $meta_key = '_kudsic_project_' . $i . '_' . $field;

            $value = get_post_meta(
                $post->ID,
                $meta_key,
                true
            );


            if ($value === '') {

                $value = $defaults[$i][$field];

            }


            echo '<p>';

            echo '<label>';

            echo '<strong>' . esc_html($label) . '</strong>';

            echo '</label><br>';


            if ($field === 'description') {

                echo '<textarea
                    name="kudsic_project_' . $i . '_' . $field . '"
                    rows="4"
                    style="width:100%;max-width:800px;"
                >' . esc_textarea($value) . '</textarea>';

            } else {

                echo '<input
                    type="text"
                    name="kudsic_project_' . $i . '_' . $field . '"
                    value="' . esc_attr($value) . '"
                    style="width:100%;max-width:800px;"
                >';

            }


            echo '</p>';

        }


        $image_meta_key = '_kudsic_project_' . $i . '_image_url';

        $image_value = get_post_meta(
            $post->ID,
            $image_meta_key,
            true
        );


        if ($image_value === '') {

            $image_value = $defaults[$i]['image_url'];

        }


        echo '<p>';

        echo '<label>';

        echo '<strong>Project Image</strong>';

        echo '</label><br><br>';


        echo '<input
            type="text"
            id="kudsic_project_' . $i . '_image_url"
            name="kudsic_project_' . $i . '_image_url"
            value="' . esc_attr($image_value) . '"
            style="width:70%;max-width:600px;"
        >';


        echo ' ';


        echo '<button
            type="button"
            class="button kudsic-project-image-button"
            data-target="kudsic_project_' . $i . '_image_url"
        >
            Select Image
        </button>';


        echo '<br><br>';


        echo '<img
            id="kudsic_project_' . $i . '_image_url_preview"
            src="' . esc_url($image_value) . '"
            style="max-width:250px;height:auto;display:block;border:1px solid #ddd;padding:5px;"
        >';


        echo '</p>';


        echo '</div>';

    }

}

function kudsic_projects_media_library() {

    wp_enqueue_media();

    wp_enqueue_script('jquery');

}
add_action(
    'admin_enqueue_scripts',
    'kudsic_projects_media_library'
);


function kudsic_projects_media_library_script() {
    ?>
    <script>
    jQuery(document).ready(function($) {

        $(document).on('click', '.kudsic-project-image-button', function(e) {

            e.preventDefault();

            var button = $(this);

            var targetId = button.data('target');

            var target = $('#' + targetId);

            var preview = $('#' + targetId + '_preview');

            var mediaUploader = wp.media({

                title: 'Select Project Image',

                button: {
                    text: 'Use This Image'
                },

                multiple: false

            });

            mediaUploader.on('select', function() {

                var attachment = mediaUploader
                    .state()
                    .get('selection')
                    .first()
                    .toJSON();

                target.val(attachment.url);

                target.trigger('change');

                preview
                    .attr('src', attachment.url)
                    .show();

            });

            mediaUploader.open();

        });

    });
    </script>
    <?php
}

add_action(
    'admin_footer',
    'kudsic_projects_media_library_script'
);

function kudsic_save_homepage_projects($post_id) {

    if (
        !isset($_POST['kudsic_homepage_projects_nonce']) ||
        !wp_verify_nonce(
            $_POST['kudsic_homepage_projects_nonce'],
            'kudsic_save_homepage_projects'
        )
    ) {
        return;
    }


    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }


    if (!current_user_can('edit_page', $post_id)) {
        return;
    }


    $post = get_post($post_id);


    if (!$post || $post->post_type !== 'page') {
        return;
    }


    for ($i = 1; $i <= 6; $i++) {

        $fields = array(
            'category',
            'title',
            'description',
            'image_url',
            'link'
        );


        foreach ($fields as $field) {

            $input_name = 'kudsic_project_' . $i . '_' . $field;

            $meta_key = '_kudsic_project_' . $i . '_' . $field;


            if (!isset($_POST[$input_name])) {
                continue;
            }


            $value = wp_unslash($_POST[$input_name]);


            if ($field === 'description') {

                $value = sanitize_textarea_field($value);

            } elseif ($field === 'link') {

                $value = esc_url_raw($value);

            } elseif ($field === 'image_url') {

                $value = esc_url_raw($value);

            } else {

                $value = sanitize_text_field($value);

            }


            update_post_meta(
                $post_id,
                $meta_key,
                $value
            );

        }

    }

}


add_action(
    'save_post_page',
    'kudsic_save_homepage_projects'
);


function kudsic_add_footer_meta_box($post) {

    if (!$post || $post->post_type !== 'page') {
        return;
    }

    $homepage_id = get_option('page_on_front');

    if (
        !(
            ($homepage_id && $post->ID == $homepage_id) ||
            $post->post_name === 'home'
        )
    ) {
        return;
    }

    add_meta_box(
        'kudsic_footer_cms',
        'KUDSIC Footer Settings',
        'kudsic_footer_meta_box',
        'page',
        'normal',
        'high'
    );
}

add_action(
    'add_meta_boxes_page',
    'kudsic_add_footer_meta_box'
);


function kudsic_footer_meta_box($post) {

    wp_nonce_field(
        'kudsic_save_footer',
        'kudsic_footer_nonce'
    );

    $fields = array(

        'description' => array(
            'label' => 'Footer Description',
            'default' => 'Kenya USA Diaspora Sacco Investment Company, creating sustainable opportunities through investment, housing and urban development.',
            'type' => 'textarea'
        ),

        'facebook' => array(
            'label' => 'Facebook URL',
            'default' => '#',
            'type' => 'text'
        ),

        'twitter' => array(
            'label' => 'X / Twitter URL',
            'default' => '#',
            'type' => 'text'
        ),

        'linkedin' => array(
            'label' => 'LinkedIn URL',
            'default' => '#',
            'type' => 'text'
        ),

        'instagram' => array(
            'label' => 'Instagram URL',
            'default' => '#',
            'type' => 'text'
        ),

        'location' => array(
            'label' => 'Location',
            'default' => 'Nairobi, Kenya',
            'type' => 'text'
        ),

        'phone' => array(
            'label' => 'Phone Number',
            'default' => '+254 790 239 753',
            'type' => 'text'
        ),

        'email' => array(
            'label' => 'Email Address',
            'default' => 'info@kudsic.com',
            'type' => 'text'
        ),

        'hours' => array(
            'label' => 'Business Hours',
            'default' => 'Mon – Fri: 8:00 AM – 5:00 PM',
            'type' => 'text'
        ),

        'newsletter_label' => array(
            'label' => 'Newsletter Label',
            'default' => 'STAY CONNECTED',
            'type' => 'text'
        ),

        'newsletter_heading' => array(
            'label' => 'Newsletter Heading',
            'default' => 'Get the latest KUDSIC updates.',
            'type' => 'text'
        ),

        'newsletter_placeholder' => array(
            'label' => 'Newsletter Placeholder',
            'default' => 'Enter your email address',
            'type' => 'text'
        ),

        'newsletter_button' => array(
            'label' => 'Newsletter Button Text',
            'default' => 'Subscribe',
            'type' => 'text'
        ),

        'privacy_url' => array(
            'label' => 'Privacy Policy URL',
            'default' => '#',
            'type' => 'text'
        ),

        'terms_url' => array(
            'label' => 'Terms & Conditions URL',
            'default' => '#',
            'type' => 'text'
        ),

        'copyright' => array(
            'label' => 'Copyright Text',
            'default' => '© 2026 KUDSIC. All Rights Reserved.',
            'type' => 'text'
        )
    );

    echo '<p>Edit the footer content displayed across the KUDSIC website.</p>';

    foreach ($fields as $field => $settings) {

        $meta_key = '_kudsic_footer_' . $field;

        $value = get_post_meta(
            $post->ID,
            $meta_key,
            true
        );

        if ($value === '') {
            $value = $settings['default'];
        }

        echo '<p>';

        echo '<label>';
        echo '<strong>' . esc_html($settings['label']) . '</strong>';
        echo '</label><br>';

        if ($settings['type'] === 'textarea') {

            echo '<textarea
                name="kudsic_footer_' . esc_attr($field) . '"
                rows="4"
                style="width:100%;max-width:800px;"
            >' . esc_textarea($value) . '</textarea>';

        } else {

            echo '<input
                type="text"
                name="kudsic_footer_' . esc_attr($field) . '"
                value="' . esc_attr($value) . '"
                style="width:100%;max-width:800px;"
            >';
        }

        echo '</p>';
    }
}


function kudsic_save_footer($post_id) {

    if (
        !isset($_POST['kudsic_footer_nonce']) ||
        !wp_verify_nonce(
            $_POST['kudsic_footer_nonce'],
            'kudsic_save_footer'
        )
    ) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    $post = get_post($post_id);

    if (!$post || $post->post_type !== 'page') {
        return;
    }

    $homepage_id = get_option('page_on_front');

    if (
        !(
            ($homepage_id && $post_id == $homepage_id) ||
            $post->post_name === 'home'
        )
    ) {
        return;
    }

    $fields = array(
        'description',
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'location',
        'phone',
        'email',
        'hours',
        'newsletter_label',
        'newsletter_heading',
        'newsletter_placeholder',
        'newsletter_button',
        'privacy_url',
        'terms_url',
        'copyright'
    );

    foreach ($fields as $field) {

        $input_name = 'kudsic_footer_' . $field;

        $meta_key = '_kudsic_footer_' . $field;

        if (!isset($_POST[$input_name])) {
            continue;
        }

        $value = wp_unslash($_POST[$input_name]);

        if (
            $field === 'facebook' ||
            $field === 'twitter' ||
            $field === 'linkedin' ||
            $field === 'instagram' ||
            $field === 'privacy_url' ||
            $field === 'terms_url'
        ) {

            $value = esc_url_raw($value);

        } elseif ($field === 'description') {

            $value = sanitize_textarea_field($value);

        } else {

            $value = sanitize_text_field($value);
        }

        update_post_meta(
            $post_id,
            $meta_key,
            $value
        );
    }
}

add_action(
    'save_post_page',
    'kudsic_save_footer'
);

function kudsic_add_header_meta_box($post) {

    if (!$post || $post->post_type !== 'page') {
        return;
    }

    $homepage_id = get_option('page_on_front');

    if (
        !(
            ($homepage_id && $post->ID == $homepage_id) ||
            $post->post_name === 'home'
        )
    ) {
        return;
    }

    add_meta_box(
        'kudsic_header_cms',
        'KUDSIC Header Settings',
        'kudsic_header_meta_box',
        'page',
        'normal',
        'high'
    );
}

add_action(
    'add_meta_boxes_page',
    'kudsic_add_header_meta_box'
);


function kudsic_header_meta_box($post) {

    wp_nonce_field(
        'kudsic_save_header',
        'kudsic_header_nonce'
    );

    $fields = array(

        'logo_url' => array(
            'label' => 'Logo URL',
            'default' => get_template_directory_uri() . '/images/LOGO1.png'
        ),

        'top_home_label' => array(
            'label' => 'Top Menu 1 Label',
            'default' => 'Home'
        ),

        'top_home_url' => array(
            'label' => 'Top Menu 1 URL',
            'default' => home_url('/')
        ),

        'top_about_label' => array(
            'label' => 'Top Menu 2 Label',
            'default' => 'About Us'
        ),

        'top_about_url' => array(
            'label' => 'Top Menu 2 URL',
            'default' => home_url('/about-us/')
        ),

        'top_news_label' => array(
            'label' => 'Top Menu 3 Label',
            'default' => 'News Centre'
        ),

        'top_news_url' => array(
            'label' => 'Top Menu 3 URL',
            'default' => home_url('/news-center/')
        ),

        'top_events_label' => array(
            'label' => 'Top Menu 4 Label',
            'default' => 'Events'
        ),

        'top_events_url' => array(
            'label' => 'Top Menu 4 URL',
            'default' => home_url('/events/')
        ),

        'top_careers_label' => array(
            'label' => 'Top Menu 5 Label',
            'default' => 'Careers'
        ),

        'top_careers_url' => array(
            'label' => 'Top Menu 5 URL',
            'default' => home_url('/careers/')
        ),

        'top_tenders_label' => array(
            'label' => 'Top Menu 6 Label',
            'default' => 'Tenders'
        ),

        'top_tenders_url' => array(
            'label' => 'Top Menu 6 URL',
            'default' => home_url('/tenders/')
        ),

        'facebook' => array(
            'label' => 'Facebook URL',
            'default' => '#'
        ),

        'twitter' => array(
            'label' => 'X / Twitter URL',
            'default' => '#'
        ),

        'youtube' => array(
            'label' => 'YouTube URL',
            'default' => '#'
        ),

        'linkedin' => array(
            'label' => 'LinkedIn URL',
            'default' => '#'
        ),

        'whatsapp' => array(
            'label' => 'WhatsApp URL',
            'default' => '#'
        ),

        'search_url' => array(
            'label' => 'Search URL',
            'default' => '#'
        ),

        'branding_promotions_label' => array(
            'label' => 'Branding Menu 1 Label',
            'default' => 'Promotions'
        ),

        'branding_promotions_url' => array(
            'label' => 'Branding Menu 1 URL',
            'default' => home_url('/promotions/')
        ),

        'branding_publications_label' => array(
            'label' => 'Branding Menu 2 Label',
            'default' => 'Publications'
        ),

        'branding_publications_url' => array(
            'label' => 'Branding Menu 2 URL',
            'default' => home_url('/publications/')
        ),

        'branding_projects_label' => array(
            'label' => 'Branding Menu 3 Label',
            'default' => 'Projects'
        ),

        'branding_projects_url' => array(
            'label' => 'Branding Menu 3 URL',
            'default' => home_url('/projects/')
        ),

        'branding_members_label' => array(
            'label' => 'Branding Menu 4 Label',
            'default' => 'Member Portals'
        ),

        'branding_members_url' => array(
            'label' => 'Branding Menu 4 URL',
            'default' => home_url('/members-portal/')
        ),

        'branding_employer_label' => array(
            'label' => 'Branding Menu 5 Label',
            'default' => 'Employer Portals'
        ),

        'branding_employer_url' => array(
            'label' => 'Branding Menu 5 URL',
            'default' => home_url('/employer-portal/')
        )
    );

    echo '<p>Edit the KUDSIC header content displayed across the website.</p>';

    foreach ($fields as $field => $settings) {

        $meta_key = '_kudsic_header_' . $field;

        $value = get_post_meta(
            $post->ID,
            $meta_key,
            true
        );

        if ($value === '') {
            $value = $settings['default'];
        }

        echo '<p>';

        echo '<label>';
        echo '<strong>' . esc_html($settings['label']) . '</strong>';
        echo '</label><br>';

        echo '<input
            type="text"
            name="kudsic_header_' . esc_attr($field) . '"
            value="' . esc_attr($value) . '"
            style="width:100%;max-width:800px;"
        >';

        echo '</p>';
    }
}


function kudsic_save_header($post_id) {

    if (
        !isset($_POST['kudsic_header_nonce']) ||
        !wp_verify_nonce(
            $_POST['kudsic_header_nonce'],
            'kudsic_save_header'
        )
    ) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    $post = get_post($post_id);

    if (!$post || $post->post_type !== 'page') {
        return;
    }

    $homepage_id = get_option('page_on_front');

    if (
        !(
            ($homepage_id && $post_id == $homepage_id) ||
            $post->post_name === 'home'
        )
    ) {
        return;
    }

    $fields = array(

        'logo_url',

        'top_home_label',
        'top_home_url',

        'top_about_label',
        'top_about_url',

        'top_news_label',
        'top_news_url',

        'top_events_label',
        'top_events_url',

        'top_careers_label',
        'top_careers_url',

        'top_tenders_label',
        'top_tenders_url',

        'facebook',
        'twitter',
        'youtube',
        'linkedin',
        'whatsapp',
        'search_url',

        'branding_promotions_label',
        'branding_promotions_url',

        'branding_publications_label',
        'branding_publications_url',

        'branding_projects_label',
        'branding_projects_url',

        'branding_members_label',
        'branding_members_url',

        'branding_employer_label',
        'branding_employer_url'
    );

    foreach ($fields as $field) {

        $input_name = 'kudsic_header_' . $field;

        $meta_key = '_kudsic_header_' . $field;

        if (!isset($_POST[$input_name])) {
            continue;
        }

        $value = wp_unslash($_POST[$input_name]);

        if (
            strpos($field, '_url') !== false ||
            in_array(
                $field,
                array(
                    'logo_url',
                    'facebook',
                    'twitter',
                    'youtube',
                    'linkedin',
                    'whatsapp'
                ),
                true
            )
        ) {

            $value = esc_url_raw($value);

        } else {

            $value = sanitize_text_field($value);
        }

        update_post_meta(
            $post_id,
            $meta_key,
            $value
        );
    }
}

add_action(
    'save_post_page',
    'kudsic_save_header'
);
