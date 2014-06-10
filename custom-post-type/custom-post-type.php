<?php
/**
 * Plugin Name: Add Custom Products
 * Description: Creates custom post type called 'Product' that client can use to add products
 * Version: 1.0
 * Author: Logan Saruwatari
 */

define( custom_post_dir, plugin_dir_path( __FILE__ ));
define( custom_post_url, plugin_dir_url( __FILE__ ));

// Register Scripts and Style
add_action('wp_enqueue_scripts', 'custom_post_scripts');
// Include Plugin Styles
    function custom_post_scripts() 
    {
        wp_enqueue_style('style', custom_post_url . 'custom-post-type.css');
    }
    
//tell wordpress to call function shortcode on init
add_action( 'init', 'register_shortcode_custom' );
//add shortcode [product random] to call add_post function
    function register_shortcode_custom()
    {
        add_shortcode( 'product random', 'get_random_products');
    }


//using for debugging. I want to see exactly what I am pulling
function get_random_products($atts)
    {

        $args = array('posts_per_page'=>1 , 'post_type'=>'panther_product', 'orderby'=>'count','hide_empty'=>1, 'current_category'=>1);
        $posts = get_posts($args);
        $taxo = array('price', 'saleprice', 'link', 'description', 'rating');
        $posts2 = get_terms($taxo,$args);
        //echo $posts2[8]->name;
        foreach($posts2 as $post2)
        {
            echo $post2->$post2->name . "</br>";
        }
       // var_dump($posts2);
        //$post = new WP_Query($args);
    }

// not being used at the moment. still debugging with other function
    function get_random_product($atts)
    {
        echo "<div class='large-4 columns' data-equalizer-watch='' style='height: 280px;'>
                <div class='box teaser store'>
                    <h4>Store</h4>
                    <div class='clearfix' id='featured-merch'>";

        $args = array('posts_per_page'=>1 , 'post_type'=>'panther_product');

        $post = get_terms($args);
        //$post = new WP_Query($args);
        if(!empty($post))
            {
                    if(!empty(get_the_post_thumbnail($post->ID)))
                         echo "<img class='left' src='" . get_the_post_thumbnail($post->ID,array(130,130)) . "'/>";
                    else echo "<img class='left' src='http://placehold.it/130x130' />";
                echo   "<p class='price'>$32.00</p>
                        <p class='price discounted'>$40.00</p>
                        <p class='details'>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <span class='star-rating text-right'>
                            <i class='fa-star'></i>
                            <i class='fa-star'></i>
                            <i class='fa-star'></i>
                            <i class='fa-star'></i>
                            <i class='fa-star-half-empty'></i>
                        </span>
                    </div>
                    <p class='text-center'>
                        <a href='http://steelpanther.fanfire.com/cgi-bin/WebObjects/Store.woa/wa/artist?sourceCode=SPNWEBWWUSD&artistName=Steel+Panther' target='_blank' class='black-btn upper'>Visit the  Store</a>
                    </p>               
                </div>
            </div>";
            }
    }


add_action( 'init', 'create_product_taxonomies', 0 );
function create_product_taxonomies() {
    // Add new Taxonomy
    $labels = array(
        'name'              => _x( 'price', 'taxonomy general name' ),
        'singular_name'     => _x( 'price', 'taxonomy singular name' ),
        'search_items'      => __( 'Search prices' ),
        'all_items'         => __( 'All prices' ),
        'parent_item'       => __( 'Parent price' ),
        'parent_item_colon' => __( 'Parent price:' ),
        'edit_item'         => __( 'Edit price' ),
        'update_item'       => __( 'Update price' ),
        'add_new_item'      => __( 'Add New price' ),
        'new_item_name'     => __( 'New price Name' ),
        'menu_name'         => __( 'price' ),
    );

    $args = array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'price' ),
    );

    register_taxonomy( 'price', array( 'panther_product' ), $args );

    $labels = array(
        'name'              => _x( 'saleprice', 'taxonomy general name' ),
        'singular_name'     => _x( 'saleprice', 'taxonomy singular name' ),
        'search_items'      => __( 'Search saleprices' ),
        'all_items'         => __( 'All saleprices' ),
        'parent_item'       => __( 'Parent saleprice' ),
        'parent_item_colon' => __( 'Parent saleprice:' ),
        'edit_item'         => __( 'Edit saleprice' ),
        'update_item'       => __( 'Update saleprice' ),
        'add_new_item'      => __( 'Add New saleprice' ),
        'new_item_name'     => __( 'New saleprice Name' ),
        'menu_name'         => __( 'saleprice' ),
    );

    $args = array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'saleprice' ),
    );

    register_taxonomy( 'saleprice', array( 'panther_product' ), $args );

    $labels = array(
        'name'                       => _x( 'rating', 'taxonomy general name' ),
        'singular_name'              => _x( 'rating', 'taxonomy singular name' ),
        'search_items'               => __( 'Search rating' ),
        'popular_items'              => __( 'Popular rating' ),
        'all_items'                  => __( 'All rating' ),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => __( 'Edit rating' ),
        'update_item'                => __( 'Update rating' ),
        'add_new_item'               => __( 'Add New rating' ),
        'new_item_name'              => __( 'New rating Name' ),
        'separate_items_with_commas' => __( 'Separate rating with commas' ),
        'add_or_remove_items'        => __( 'Add or remove rating' ),
        'choose_from_most_used'      => __( 'Choose from the most used rating' ),
        'not_found'                  => __( 'No rating found.' ),
        'menu_name'                  => __( 'rating' ),
    );

    $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'rating' ),
    );

    register_taxonomy( 'rating', 'panther_product', $args );

    $labels = array(
        'name'              => _x( 'description', 'taxonomy general name' ),
        'singular_name'     => _x( 'description', 'taxonomy singular name' ),
        'search_items'      => __( 'Search descriptions' ),
        'all_items'         => __( 'All descriptions' ),
        'parent_item'       => __( 'Parent description' ),
        'parent_item_colon' => __( 'Parent description:' ),
        'edit_item'         => __( 'Edit description' ),
        'update_item'       => __( 'Update description' ),
        'add_new_item'      => __( 'Add New description' ),
        'new_item_name'     => __( 'New description Name' ),
        'menu_name'         => __( 'description' ),
    );

    $args = array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'description' ),
    );

    register_taxonomy( 'description', array( 'panther_product' ), $args );

    $labels = array(
        'name'              => _x( 'link', 'taxonomy general name' ),
        'singular_name'     => _x( 'link', 'taxonomy singular name' ),
        'search_items'      => __( 'Search links' ),
        'all_items'         => __( 'All links' ),
        'parent_item'       => __( 'Parent link' ),
        'parent_item_colon' => __( 'Parent link:' ),
        'edit_item'         => __( 'Edit link' ),
        'update_item'       => __( 'Update link' ),
        'add_new_item'      => __( 'Add New link' ),
        'new_item_name'     => __( 'New link Name' ),
        'menu_name'         => __( 'link' ),
    );

    $args = array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'link' ),
    );

    register_taxonomy( 'link', array( 'panther_product' ), $args );

}

//tell wordpress to call function create_custom_post on init
add_action( 'init', 'create_custom_post' );
function create_custom_post() 
{
    register_post_type( 'panther_product',array(
            'labels' => array(
                'name' => __( 'Products' ),
                'singular_name' => __( 'Product' ),
                'menu_name'=>__('Panther Products'),
                'add_new_item'=>__('Add New Product'),
                'edit_item'=>__('Edit Product'),
                'view_item'=>__('View Product'),
                'image'=>__('image'),
                'link'=>__('link'),
                ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array( 'slug' => 'product' ),
            'supports'=> array( 'title', 'editor', 'thumbnail')
            )
    );
}

/*  2014  Logan Saruwatari  (email : lsaruwatari@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>