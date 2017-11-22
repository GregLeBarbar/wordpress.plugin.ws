<?php
/*
 * Plugin Name: EPFL Personal Pages (shortcode)
 * Description: Manage personal pages for EPFL (and external) staff
 * Version:     0.1
 * Author:      STI Web Task Force
 * Author URI:  mailto:stiitweb@groupes.epfl.ch
 */
namespace EPFL\Persons;

if (! defined('ABSPATH')) {
    die('Access denied.');
}

function ___($text)
{
    return __($text, "epfl-people");
}

function __x($text, $context)
{
    return _x($text, $context, "epfl-people");
}

class Person
{
    const SLUG = "epfl-person";

    static function hook ()
    {
        $THIS_CLASS = '\EPFL\Persons\Person';
        add_action('admin_init', array($THIS_CLASS, 'admin_init'));
        add_action('init', array($THIS_CLASS, 'register_post_type'));
        add_filter('enter_title_here', array($THIS_CLASS, 'enter_title_here'),
                   10, 2);
    }

    /**
     * Make it so that people pages exist.
     *
     * Under WordPress, almost everything publishable is a post. register_post_type() is
     * invoked to create a particular flavor of posts that describe people.
     */
    static function register_post_type ()
    {
        register_post_type(
            Person::SLUG,
            array(
                'labels'             => array(
                    'name'               => __x( 'People', 'post type general name' ),
                    'singular_name'      => __x( 'Person', 'post type singular name' ),
                    'menu_name'          => __x( 'People', 'admin menu' ),
                    'name_admin_bar'     => __x( 'Person', 'add new on admin bar' ),
                    'add_new'            => __x( 'Add New', 'add new person' ),
                    'add_new_item'       => ___( 'Add New Person' ),
                    'new_item'           => ___( 'New Person' ),
                    'edit_item'          => ___( 'Edit Person' ),
                    'view_item'          => ___( 'View Person' ),
                    'all_items'          => ___( 'All People' ),
                    'search_items'       => ___( 'Search People' ),
                    'parent_item_colon'  => ___( 'Parent People:' ),
                    'not_found'          => ___( 'No persons found.' ),
                    'not_found_in_trash' => ___( 'No persons found in Trash.' )
                ),
                'description'        => ___( 'Noteworthy people' ),
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'rewrite'            => array( 'slug' => Person::SLUG ),
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => false,
                'menu_position'      => null,
                'menu_icon'          => 'dashicons-welcome-learn-more',
                'supports'           => array( 'title', 'editor', 'thumbnail' )
            ));
    }

    static function admin_init ()
    {
        // TODO: not sure if useful
        add_menu_page(
            __x('People', 'admin menu page title'),
            __x('People', 'admin menu title'),
            'read',
            'epfl-people',
            null,                                      // Render callback
            'dashicons-calendar',                      // Icon type
            70                                         // Position
        );
   }

    /**
     * Replace the "Enter title here" prompt for Person-typed posts
     */
    static function enter_title_here ($text, $post)
    {
        if ($post->post_type != Person::SLUG) return $text;
        return __x("Dr Firstname Lastname", "enter_title_here");
    }
}

Person::hook();
