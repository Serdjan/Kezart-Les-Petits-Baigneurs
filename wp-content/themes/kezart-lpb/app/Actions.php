<?php

declare(strict_types=1);

namespace RS\Theme\App;

class Actions
{
    public function registerCoursePostType(): void
    {
        register_post_type('course', [
            'label' => __('Course', 'kezart-lpb'),
            'labels' => [
                'name' => _x('Courses', 'Post Type General Name', 'kezart-lpb'),
                'singular_name' => _x('Course', 'Post Type Singular Name', 'kezart-lpb'),
                'menu_name' => __('Courses', 'kezart-lpb'),
                'name_admin_bar' => __('Course', 'kezart-lpb'),
                'archives' => __('Course Archives', 'kezart-lpb'),
                'attributes' => __('Course Attributes', 'kezart-lpb'),
                'parent_item_colon' => __('Parent Course:', 'kezart-lpb'),
                'all_items' => __('All Courses', 'kezart-lpb'),
                'add_new_item' => __('Add New Course', 'kezart-lpb'),
                'add_new' => __('Add New', 'kezart-lpb'),
                'new_item' => __('New Course', 'kezart-lpb'),
                'edit_item' => __('Edit Course', 'kezart-lpb'),
                'update_item' => __('Update Course', 'kezart-lpb'),
                'view_item' => __('View Course', 'kezart-lpb'),
                'view_items' => __('View Courses', 'kezart-lpb'),
                'search_items' => __('Search Course', 'kezart-lpb'),
                'not_found' => __('Not found', 'kezart-lpb'),
                'not_found_in_trash' => __('Not found in Trash', 'kezart-lpb'),
                'featured_image' => __('Featured Image', 'kezart-lpb'),
                'set_featured_image' => __('Set featured image', 'kezart-lpb'),
                'remove_featured_image' => __('Remove featured image', 'kezart-lpb'),
                'use_featured_image' => __('Use as featured image', 'kezart-lpb'),
                'insert_into_item' => __('Insert into course', 'kezart-lpb'),
                'uploaded_to_this_item' => __('Uploaded to this course', 'kezart-lpb'),
                'items_list' => __('Courses list', 'kezart-lpb'),
                'items_list_navigation' => __('Courses list navigation', 'kezart-lpb'),
                'filter_items_list' => __('Filter courses list', 'kezart-lpb'),
            ],
            'supports' => ['title', 'editor', 'thumbnail', 'revisions', 'excerpt',],
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 20,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => false,
            'can_export' => true,
            'has_archive' => false,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'rewrite' => [
                'slug' => 'cours',
                'with_front' => true,
                'pages' => true,
                'feeds' => true,
            ],
            'capability_type' => 'page',
            'show_in_rest' => true,
        ]);
    }

    public function registerPoolPostType(): void
    {
        register_post_type('pool', [
            'label' => __('Pool', 'kezart-lpb'),
            'labels' => [
                'name' => _x('Pools', 'Post Type General Name', 'kezart-lpb'),
                'singular_name' => _x('Pool', 'Post Type Singular Name', 'kezart-lpb'),
                'menu_name' => __('Pools', 'kezart-lpb'),
                'name_admin_bar' => __('Pool', 'kezart-lpb'),
                'archives' => __('Pool Archives', 'kezart-lpb'),
                'attributes' => __('Pool Attributes', 'kezart-lpb'),
                'parent_item_colon' => __('Parent Pool:', 'kezart-lpb'),
                'all_items' => __('All Pools', 'kezart-lpb'),
                'add_new_item' => __('Add New Pool', 'kezart-lpb'),
                'add_new' => __('Add New', 'kezart-lpb'),
                'new_item' => __('New Pool', 'kezart-lpb'),
                'edit_item' => __('Edit v', 'kezart-lpb'),
                'update_item' => __('Update Pool', 'kezart-lpb'),
                'view_item' => __('View Pool', 'kezart-lpb'),
                'view_items' => __('View Pools', 'kezart-lpb'),
                'search_items' => __('Search Pool', 'kezart-lpb'),
                'not_found' => __('Not found', 'kezart-lpb'),
                'not_found_in_trash' => __('Not found in Trash', 'kezart-lpb'),
                'featured_image' => __('Featured Image', 'kezart-lpb'),
                'set_featured_image' => __('Set featured image', 'kezart-lpb'),
                'remove_featured_image' => __('Remove featured image', 'kezart-lpb'),
                'use_featured_image' => __('Use as featured image', 'kezart-lpb'),
                'insert_into_item' => __('Insert into pool', 'kezart-lpb'),
                'uploaded_to_this_item' => __('Uploaded to this pool', 'kezart-lpb'),
                'items_list' => __('Pools list', 'kezart-lpb'),
                'items_list_navigation' => __('Pools list navigation', 'kezart-lpb'),
                'filter_items_list' => __('Filter pools list', 'kezart-lpb'),
            ],
            'supports' => ['title', 'editor', 'thumbnail', 'revisions', 'excerpt',],
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 20,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => false,
            'can_export' => true,
            'has_archive' => false,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'rewrite' => [
                'slug' => 'piscine',
                'with_front' => true,
                'pages' => true,
                'feeds' => true,
            ],
            'capability_type' => 'page',
            'show_in_rest' => true,
        ]);
    }

    public function registerGroupAgeTaxonomy(): void
    {
        register_taxonomy('group_age', ['course'], [
            'labels' => [
                'name' => _x('Age Groups', 'Taxonomy General Name', 'kezart-lpb'),
                'singular_name' => _x('Age Group', 'Taxonomy Singular Name', 'kezart-lpb'),
                'menu_name' => __('Age Group', 'kezart-lpb'),
                'all_items' => __('All Age Groups', 'kezart-lpb'),
                'parent_item' => __('Parent Age Group', 'kezart-lpb'),
                'parent_item_colon' => __('Parent Age Group:', 'kezart-lpb'),
                'new_item_name' => __('New Age Group Name', 'kezart-lpb'),
                'add_new_item' => __('Add New Age Group', 'kezart-lpb'),
                'edit_item' => __('Edit Age Group', 'kezart-lpb'),
                'update_item' => __('Update Age Group', 'kezart-lpb'),
                'view_item' => __('View Age Group', 'kezart-lpb'),
                'separate_items_with_commas' => __('Separate age groups with commas', 'kezart-lpb'),
                'add_or_remove_items' => __('Add or remove age groups', 'kezart-lpb'),
                'choose_from_most_used' => __('Choose from the most used', 'kezart-lpb'),
                'popular_items' => __('Popular Age Groups', 'kezart-lpb'),
                'search_items' => __('Search Age Groups', 'kezart-lpb'),
                'not_found' => __('Not Found', 'kezart-lpb'),
                'no_terms' => __('No groups', 'kezart-lpb'),
                'items_list' => __('Age groups list', 'kezart-lpb'),
                'items_list_navigation' => __('Age groups list navigation', 'kezart-lpb'),
            ],
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => false,
            'show_tagcloud' => false,
            'rewrite' => [
                'slug' => 'groupe-age',
                'with_front' => true,
                'hierarchical' => false,
            ],
            'show_in_rest' => true,
        ]);
    }

    public function registerGroupSizeTaxonomy(): void
    {
        register_taxonomy('group_size', ['course'], [
            'labels' => [
                'name' => _x('Size Groups', 'Taxonomy General Name', 'kezart-lpb'),
                'singular_name' => _x('Size Group', 'Taxonomy Singular Name', 'kezart-lpb'),
                'menu_name' => __('Size Group', 'kezart-lpb'),
                'all_items' => __('All Size Groups', 'kezart-lpb'),
                'parent_item' => __('Parent Size Group', 'kezart-lpb'),
                'parent_item_colon' => __('Parent Size Group:', 'kezart-lpb'),
                'new_item_name' => __('New Size Group Name', 'kezart-lpb'),
                'add_new_item' => __('Add New Size Group', 'kezart-lpb'),
                'edit_item' => __('Edit Size Group', 'kezart-lpb'),
                'update_item' => __('Update Size Group', 'kezart-lpb'),
                'view_item' => __('View Size Group', 'kezart-lpb'),
                'separate_items_with_commas' => __('Separate size groups with commas', 'kezart-lpb'),
                'add_or_remove_items' => __('Add or remove size groups', 'kezart-lpb'),
                'choose_from_most_used' => __('Choose from the most used', 'kezart-lpb'),
                'popular_items' => __('Popular Size Groups', 'kezart-lpb'),
                'search_items' => __('Search Size Groups', 'kezart-lpb'),
                'not_found' => __('Not Found', 'kezart-lpb'),
                'no_terms' => __('No groups', 'kezart-lpb'),
                'items_list' => __('Size groups list', 'kezart-lpb'),
                'items_list_navigation' => __('Size groups list navigation', 'kezart-lpb'),
            ],
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => false,
            'show_tagcloud' => false,
            'rewrite' => [
                'slug' => 'taille-groupe',
                'with_front' => true,
                'hierarchical' => false,
            ],
            'show_in_rest' => true,
        ]);
    }

    public function registerGroupCoachTaxonomy(): void
    {
        register_taxonomy('group_coach', ['course'], [
            'labels' => [
                'name' => _x('Coach Groups', 'Taxonomy General Name', 'kezart-lpb'),
                'singular_name' => _x('Coach Group', 'Taxonomy Singular Name', 'kezart-lpb'),
                'menu_name' => __('Coach Group', 'kezart-lpb'),
                'all_items' => __('All Coach Groups', 'kezart-lpb'),
                'parent_item' => __('Parent Coach Group', 'kezart-lpb'),
                'parent_item_colon' => __('Parent Coach Group:', 'kezart-lpb'),
                'new_item_name' => __('New Coach Group Name', 'kezart-lpb'),
                'add_new_item' => __('Add New Coach Group', 'kezart-lpb'),
                'edit_item' => __('Edit Coach Group', 'kezart-lpb'),
                'update_item' => __('Update Coach Group', 'kezart-lpb'),
                'view_item' => __('View Coach Group', 'kezart-lpb'),
                'separate_items_with_commas' => __('Separate coach groups with commas', 'kezart-lpb'),
                'add_or_remove_items' => __('Add or remove coach groups', 'kezart-lpb'),
                'choose_from_most_used' => __('Choose from the most used', 'kezart-lpb'),
                'popular_items' => __('Popular Coach Groups', 'kezart-lpb'),
                'search_items' => __('Search Coach Groups', 'kezart-lpb'),
                'not_found' => __('Not Found', 'kezart-lpb'),
                'no_terms' => __('No groups', 'kezart-lpb'),
                'items_list' => __('Coach groups list', 'kezart-lpb'),
                'items_list_navigation' => __('Coach groups list navigation', 'kezart-lpb'),
            ],
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => false,
            'show_tagcloud' => false,
            'rewrite' => [
                'slug' => 'coach-groupe',
                'with_front' => true,
                'hierarchical' => false,
            ],
            'show_in_rest' => true,
        ]);
    }
}
