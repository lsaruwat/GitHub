<?php
/**
 * Plugin Name: Latest posts
 * Description: Grabs latest two posts.
 * Version: 1.0
 * Author: Logan Saruwatari
 */

//code copied from documentation
//changes excerpt length from the default 55 to whatever
function custom_excerpt_length( $length ) {
    return 6;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


define( ls_latest_dir, plugin_dir_path( __FILE__ ));
define( ls_latest_url, plugin_dir_url( __FILE__ ));


//beginning of plugin shortcode implementation


    function latest_news($atts)
    {   
        //allows for custom input attribute called amount
        //default value is 2
        extract( shortcode_atts(array('amount' => 2), $atts, 'latest_news' ));

        echo"<div class='large-4 medium-6 columns' data-equalizer-watch='' style='height: 280px;'>
             <div class='box teaser news'>
             <h4>Latest News</h4>";
        $args = array('posts_per_page'=>$amount , 'post_type'=>'post', 'orderby'=>'post_date', 'order'=>'DESC');
        $posts_array = get_posts($args);
         foreach ($posts_array as $post)
         {
            if(!empty($post))
            {
                setup_postdata($post);
                echo "<a class='story clearfix' href='" . get_the_permalink($post) . "'>";
                      if(!empty(get_the_post_thumbnail($post->ID)))  
                           echo get_the_post_thumbnail($post->ID,array(75,75));
                      else echo "<img src='http://placehold.it/75x75' />";
                echo "<p><span class='title'>" . get_the_title($post) . "</span>";
                echo  the_excerpt($post) . "</br></p></a>";
            }
         }
         echo "</div></div>";
    }

    //add shortcode [news] to call pass_function
    function register_shortcode()
    {
        add_shortcode( 'news', 'latest_news');
    }

    // Include Plugin Styles
    function ls_latest_scripts() 
    {
        wp_enqueue_style('ls_style', ls_latest_url . 'ls-latest-posts.css');
    }

    // Register Scripts and Style
    add_action('wp_enqueue_scripts', 'ls_latest_scripts');
    
    //tell wordpress to call function shortcode on init
    add_action( 'init', 'register_shortcode' );

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