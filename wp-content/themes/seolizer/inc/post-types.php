<?php

function create_post_type() {
    register_post_type( 'portfolio',
        array(
            'labels' => array(
                'name' => __( 'Портфолио' ),
                'singular_name' => __( 'Портфолио' ),
                'add_new' => 'Добавить',
            ),
            'menu_position' => 5,
            'supports' => array('title', 'editor', 'thumbnail'),
            'public' => true,
            'has_archive' => true,
        )
    );
}
add_action( 'init', 'create_post_type' );
