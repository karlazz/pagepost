<?php
/**
 * @package PagePost
 * @author Karla Leibowitz and various
 * @version 1
 */
/*
Plugin Name: PagePost
Plugin URI: http://www.karlakarla.com
Description: This will put posts on a page that has its own text.  It is a shortcode pagepost with num=,cat=,order=,orderby= for arguments
Author: Karla Leibowitz
Version: 1
Author URI: http://karlakarla.com
*/
function get_content_with_formatting ($more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
        global $more; $more=0;
	$content = get_the_content($more_link_text, $stripteaser, $more_file);
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	return $content;
}
function pp_list($atts, $content = null) {
        extract(shortcode_atts(array(
                "num" => '1',
                "cat" => '',
                "cat_name" => '',
                "tag" => '',
                "orderby" => 'post_date',
                "order" => 'DESC'
        ), $atts));
        global $post;
        
        $myposts = get_posts('numberposts='.$num.'&order='.$order.'&orderby='.$orderby.'&category='.$cat.'&category_name='.$cat_name.'&tag='.$tag);
        $retour='<ul class="pageposts pageposts'.$cat.'">';
        foreach($myposts as $post) :
                setup_postdata($post);
             $retour.='<li><a href="'.get_permalink().'">'.the_title("","",false).'</a>'.get_content_with_formatting().'</li>';
        endforeach;
        $retour.='</ul> ';
        return $retour;
}
add_shortcode('pagepost', 'pp_list');
?>