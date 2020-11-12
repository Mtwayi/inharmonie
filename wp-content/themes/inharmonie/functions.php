<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
  'lib/assets.php',    // Scripts and stylesheets
  'lib/extras.php',    // Custom functions
  'lib/setup.php',     // Theme setup
  'lib/titles.php',    // Page titles
  'lib/wrapper.php',   // Theme wrapper class
  'lib/customizer.php', // Theme customizer
  'lib/wp_bootstrap_navwalker.php' // Nav Walker
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);


function searchfilter($query) {

  if ($query->is_search && !is_admin() ) {
    $query->set('post_type',array('leader', 'story', 'event'));
    //$query->set('post_type','blog');
  }

  return $query;
}
add_filter('pre_get_posts','searchfilter');


function gmap() {
  if ( is_page( 'about') ) {
    wp_register_script('googleMap', ('http://maps.google.com/maps/api/js?sensor=false'));
    wp_enqueue_script('googleMap'); 
  }
}
add_action( 'wp_print_scripts', 'gmap');


if( function_exists('acf_add_options_page') ) {

  acf_add_options_page();

}

// Option to show or hide form field labels on gravity forms
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );

add_action( 'wp_default_scripts', function( $scripts ) {
    if ( ! empty( $scripts->registered['jquery'] ) ) {
        $scripts->registered['jquery']->deps = array_diff( $scripts->registered['jquery']->deps, array( 'jquery-migrate' ) );
    }
} );

// GFORM COLUMN Structure
// function gform_column_splits($content, $field, $value, $lead_id, $form_id) {
// if(!is_admin()) { // only perform on the front end
//     if($field['type'] == 'section') {
//         $form = RGFormsModel::get_form_meta($form_id, true);

//         // check for the presence of multi-column form classes
//         $form_class = explode(' ', $form['cssClass']);
//         $form_class_matches = array_intersect($form_class, array('two-column', 'three-column'));

//         // check for the presence of section break column classes
//         $field_class = explode(' ', $field['cssClass']);
//         $field_class_matches = array_intersect($field_class, array('gform_column'));

//         // if field is a column break in a multi-column form, perform the list split
//         if(!empty($form_class_matches) && !empty($field_class_matches)) { // make sure to target only multi-column forms

//             // retrieve the form's field list classes for consistency
//             $form = RGFormsModel::add_default_properties($form);
//             $description_class = rgar($form, 'descriptionPlacement') == 'above' ? 'description_above' : 'description_below';

//             // close current field's li and ul and begin a new list with the same form field list classes
//             return '</li></ul><ul class="gform_fields '.$form['labelPlacement'].' '.$description_class.' '.$field['cssClass'].'"><li class="gfield gsection empty">';

//         }
//     }
// }

// return $content;
// }

// add_filter('gform_field_content', 'gform_column_splits', 100, 5);

// http://www.jordancrown.com/multi-column-gravity-forms/
function gform_column_splits( $content, $field, $value, $lead_id, $form_id ) {
  if( !IS_ADMIN ) { // only perform on the front end

    // target section breaks
    if( $field['type'] == 'section' ) {
      $form = RGFormsModel::get_form_meta( $form_id, true );

      // check for the presence of multi-column form classes
      $form_class = explode( ' ', $form['cssClass'] );
      $form_class_matches = array_intersect( $form_class, array( 'two-column', 'three-column' ) );

      // check for the presence of section break column classes
      $field_class = explode( ' ', $field['cssClass'] );
      $field_class_matches = array_intersect( $field_class, array('gform_column') );

      // if field is a column break in a multi-column form, perform the list split
      if( !empty( $form_class_matches ) && !empty( $field_class_matches ) ) { // make sure to target only multi-column forms

        // retrieve the form's field list classes for consistency
        $form = RGFormsModel::add_default_properties( $form );
        $description_class = rgar( $form, 'descriptionPlacement' ) == 'above' ? 'description_above' : 'description_below';

        // close current field's li and ul and begin a new list with the same form field list classes
        return '</li></ul><ul class="gform_fields '.$form['labelPlacement'].' '.$description_class.' '.$field['cssClass'].'"><li class="gfield gsection empty">';

      }
    }
  }

  return $content;
}
add_filter( 'gform_field_content', 'gform_column_splits', 10, 5 );




// Registering Top Bar widget
add_action( 'widgets_init', 'theme_slug_widgets_init' );
function theme_slug_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Top Bar', 'theme-slug' ),
        'id' => 'top_bar',
        'description' => __( 'Top Bar Section', 'theme-slug' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name' => __( 'Bottom Bar', 'theme-slug' ),
        'id' => 'bottom_bar',
        'description' => __( 'Bottom Bar Section', 'theme-slug' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name' => __( 'Sidebar', 'theme-slug' ),
        'id' => 'sidebar',
        'description' => __( 'Sidebar Section', 'theme-slug' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ) );
}

// Single Template for Category Post Types
add_filter('single_template', 'check_for_category_single_template');
function check_for_category_single_template( $t )
{
  foreach( (array) get_the_category() as $cat )
  {
    if ( file_exists(TEMPLATEPATH . "/single-category-{$cat->slug}.php") ) return TEMPLATEPATH . "/single-category-{$cat->slug}.php";
    if($cat->parent)
    {
      $cat = get_the_category_by_ID( $cat->parent );
      if ( file_exists(TEMPLATEPATH . "/single-category-{$cat->slug}.php") ) return TEMPLATEPATH . "/single-category-{$cat->slug}.php";
    }
  }
  return $t;
}


function my_theme_archive_title( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_author() ) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif ( is_post_type_archive() ) {
        $title = post_type_archive_title( '', false );
    } elseif ( is_tax() ) {
        $title = single_term_title( '', false );
    }

    return $title;
}

add_filter( 'get_the_archive_title', 'my_theme_archive_title' );




/**
 * Add custom taxonomies
 *
 * Additional custom taxonomies can be defined here
 * http://codex.wordpress.org/Function_Reference/register_taxonomy
 */
function add_filter_taxonomies() {
  // Add new "Locations" taxonomy to Posts
  register_taxonomy('filter', 'facilities', array(
    // Hierarchical taxonomy (like categories)
    'hierarchical' => true,
    // This array of options controls the labels displayed in the WordPress Admin UI
    'labels' => array(
      'name' => _x( 'Services', 'taxonomy general name' ),
      'singular_name' => _x( 'Services', 'taxonomy singular name' ),
      'search_items' =>  __( 'Search Services' ),
      'all_items' => __( 'All Services' ),
      'parent_item' => __( 'Parent Services' ),
      'parent_item_colon' => __( 'Parent Services:' ),
      'edit_item' => __( 'Edit Services' ),
      'update_item' => __( 'Update Services' ),
      'add_new_item' => __( 'Add New Services' ),
      'new_item_name' => __( 'New Services Name' ),
      'menu_name' => __( 'Services' ),
    ),
    // Control the slugs used for this taxonomy
    'rewrite' => array(
      'slug' => 'filters', // This controls the base slug that will display before each term
      'with_front' => false, // Don't display the category base before "/filters/"
      'hierarchical' => true // This will allow URL's like "/filters/boston/cambridge/"
    ),
  ));
}
add_action( 'init', 'add_filter_taxonomies', 0 );


function add_stories_filter_taxonomies() {
  // Add new "Locations" taxonomy to Posts
  register_taxonomy('storiesfilter', 'stories', array(
    // Hierarchical taxonomy (like categories)
    'hierarchical' => true,
    // This array of options controls the labels displayed in the WordPress Admin UI
    'labels' => array(
      'name' => _x( 'Story Category', 'taxonomy general name' ),
      'singular_name' => _x( 'Story Category', 'taxonomy singular name' ),
      'search_items' =>  __( 'Search Story Categories' ),
      'all_items' => __( 'All Story Categories' ),
      'parent_item' => __( 'Parent Story Category' ),
      'parent_item_colon' => __( 'Parent Story Category:' ),
      'edit_item' => __( 'Edit Story Category' ),
      'update_item' => __( 'Update Story Category' ),
      'add_new_item' => __( 'Add New Story Category' ),
      'new_item_name' => __( 'New Story Category Name' ),
      'menu_name' => __( 'Story Categories' ),
    ),
    // Control the slugs used for this taxonomy
    'rewrite' => array(
      'slug' => 'stories', // This controls the base slug that will display before each term
      'with_front' => false, // Don't display the category base before "/filters/"
      'hierarchical' => true // This will allow URL's like "/filters/boston/cambridge/"
    ),
  ));
}
add_action( 'init', 'add_stories_filter_taxonomies', 0 );


function add_leaders_filter_taxonomies() {
  // Add new "Locations" taxonomy to Posts
  register_taxonomy('leadersfilter', 'leaders', array(
    // Hierarchical taxonomy (like categories)
    'hierarchical' => true,
    // This array of options controls the labels displayed in the WordPress Admin UI
    'labels' => array(
      'name' => _x( 'Leader Category', 'taxonomy general name' ),
      'singular_name' => _x( 'Leader Category', 'taxonomy singular name' ),
      'search_items' =>  __( 'Search Leader Categories' ),
      'all_items' => __( 'All Leader Categories' ),
      'parent_item' => __( 'Parent Leader Category' ),
      'parent_item_colon' => __( 'Parent Leaders Category:' ),
      'edit_item' => __( 'Edit Leader Category' ),
      'update_item' => __( 'Update Leader Category' ),
      'add_new_item' => __( 'Add New Leader Category' ),
      'new_item_name' => __( 'New Leader Category Name' ),
      'menu_name' => __( 'Leader Categories' ),
    ),
    // Control the slugs used for this taxonomy
    'rewrite' => array(
      'slug' => 'leaders', // This controls the base slug that will display before each term
      'with_front' => false, // Don't display the category base before "/filters/"
      'hierarchical' => true // This will allow URL's like "/filters/boston/cambridge/"
    ),
  ));
}
add_action( 'init', 'add_leaders_filter_taxonomies', 0 );



function add_events_filter_taxonomies() {
  // Add new "Locations" taxonomy to Posts
  register_taxonomy('eventsfilter', 'events', array(
    // Hierarchical taxonomy (like categories)
    'hierarchical' => true,
    // This array of options controls the labels displayed in the WordPress Admin UI
    'labels' => array(
      'name' => _x( 'Events Category', 'taxonomy general name' ),
      'singular_name' => _x( 'Events Category', 'taxonomy singular name' ),
      'search_items' =>  __( 'Search Events Categories' ),
      'all_items' => __( 'All Events Categories' ),
      'parent_item' => __( 'Parent Events Category' ),
      'parent_item_colon' => __( 'Parent Eventss Category:' ),
      'edit_item' => __( 'Edit Events Category' ),
      'update_item' => __( 'Update Events Category' ),
      'add_new_item' => __( 'Add New Events Category' ),
      'new_item_name' => __( 'New Events Category Name' ),
      'menu_name' => __( 'Events Categories' ),
    ),
    // Control the slugs used for this taxonomy
    'rewrite' => array(
      'slug' => 'events', // This controls the base slug that will display before each term
      'with_front' => false, // Don't display the category base before "/filters/"
      'hierarchical' => true // This will allow URL's like "/filters/boston/cambridge/"
    ),
  ));
}
add_action( 'init', 'add_events_filter_taxonomies', 0 );


function add_events_speakers_taxonomies() {
  // Add new "Locations" taxonomy to Posts
  register_taxonomy('speakers', 'events', array(
    // Hierarchical taxonomy (like categories)
    'hierarchical' => true,
    // This array of options controls the labels displayed in the WordPress Admin UI
    'labels' => array(
      'name' => _x( 'Select Speaker(s)', 'taxonomy general name' ),
      'singular_name' => _x( 'Speaker', 'taxonomy singular name' ),
      'search_items' =>  __( 'Search Speaker' ),
      'all_items' => __( 'All Speakers' ),
      'parent_item' => __( 'Parent Speaker' ),
      'parent_item_colon' => __( 'Parent Eventss Category:' ),
      'edit_item' => __( 'Edit Speaker' ),
      'update_item' => __( 'Update Speaker' ),
      'add_new_item' => __( 'Add New Speaker' ),
      'new_item_name' => __( 'New Speaker Name' ),
      'menu_name' => __( 'Speakers' ),
    ),
    // Control the slugs used for this taxonomy
    'rewrite' => array(
      'slug' => 'events', // This controls the base slug that will display before each term
      'with_front' => false, // Don't display the category base before "/filters/"
      'hierarchical' => true // This will allow URL's like "/filters/boston/cambridge/"
    ),
  ));
}
add_action( 'init', 'add_events_speakers_taxonomies', 0 );



/**
 * Get taxonomies terms links.
 *
 * @see get_object_taxonomies()
 */
function wpdocs_custom_taxonomies_terms_links() {
    // Get post by post ID.
    $post = get_post( $post->ID );

    // Get post type by post.
    $post_type = $post->post_type;

    // Get post type taxonomies.
    $taxonomies = get_object_taxonomies( $post_type, 'filter' );

    $out = array();

    foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){

        // Get the terms related to post.
        $terms = get_the_terms( $post->ID, $taxonomy_slug );

        if ( ! empty( $terms ) ) {
            $out[] = "<h2>" . $taxonomy->label . "</h2>\n<ul>";
            foreach ( $terms as $term ) {
                $out[] = sprintf( '<li><a href="%1$s">%2$s</a></li>',
                    esc_url( get_term_link( $term->slug, $taxonomy_slug ) ),
                    esc_html( $term->name )
                );
            }
            $out[] = "\n</ul>\n";
        }
    }
    return implode( '', $out );
}


function wpdocs_custom_taxonomies_terms_links_stories() {
    // Get post by post ID.
    $post = get_post( $post->ID );

    // Get post type by post.
    $post_type = $post->post_type;

    // Get post type taxonomies.
    $taxonomies = get_object_taxonomies( $post_type, 'storiesfilter' );

    $out = array();

    foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){

        // Get the terms related to post.
        $terms = get_the_terms( $post->ID, $taxonomy_slug );

        if ( ! empty( $terms ) ) {
            $out[] = "<h2>" . $taxonomy->label . "</h2>\n<ul>";
            foreach ( $terms as $term ) {
                $out[] = sprintf( '<li><a href="%1$s">%2$s</a></li>',
                    esc_url( get_term_link( $term->slug, $taxonomy_slug ) ),
                    esc_html( $term->name )
                );
            }
            $out[] = "\n</ul>\n";
        }
    }
    return implode( '', $out );
}

function wpdocs_custom_taxonomies_terms_links_leaders() {
    // Get post by post ID.
    $post = get_post( $post->ID );

    // Get post type by post.
    $post_type = $post->post_type;

    // Get post type taxonomies.
    $taxonomies = get_object_taxonomies( $post_type, 'leadersfilter' );

    $out = array();

    foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){

        // Get the terms related to post.
        $terms = get_the_terms( $post->ID, $taxonomy_slug );

        if ( ! empty( $terms ) ) {
            $out[] = "<h2>" . $taxonomy->label . "</h2>\n<ul>";
            foreach ( $terms as $term ) {
                $out[] = sprintf( '<li><a href="%1$s">%2$s</a></li>',
                    esc_url( get_term_link( $term->slug, $taxonomy_slug ) ),
                    esc_html( $term->name )
                );
            }
            $out[] = "\n</ul>\n";
        }
    }
    return implode( '', $out );
}



add_filter( 'kdmfi_featured_images', function( $featured_images ) {

    /* START Case Studies Featured Images*/

    // $case_studies_args_1 = array(
    //     'id' => 'case_studies-featured-image-2',
    //     'desc' => 'Your description here.',
    //     'label_name' => 'Case Studies Featured Image 2',
    //     'label_set' => 'Set featured image 2',
    //     'label_remove' => 'Remove featured image 2',
    //     'label_use' => 'Set featured image 2',
    //     'post_type' => array( 'case-studies', 'post' ),
    // );

    // $case_studies_args_2 = array(
    //     'id' => 'case_studies-featured-image-3',
    //     'desc' => 'Your description here.',
    //     'label_name' => 'Case Studies Featured Image 3',
    //     'label_set' => 'Set featured image 3',
    //     'label_remove' => 'Remove featured image 3',
    //     'label_use' => 'Set featured image 3',
    //     'post_type' => array( 'case-studies', 'post' ),
    // );

    // $featured_images[] = $case_studies_args_1;
    // $featured_images[] = $case_studies_args_2;

    /*
      kdmfi_the_featured_image( 'case_studies-featured-image-2', 'full' );
      kdmfi_the_featured_image( 'case_studies-featured-image-3', 'full' );
    */

    /* END Case Studies Featured Images*/




    /* START Blog Featured Images*/

    // $blog_args_1 = array(
    //     'id' => 'blog-featured-image-2',
    //     'desc' => 'Your description here.',
    //     'label_name' => 'Blog Featured Image 2',
    //     'label_set' => 'Set featured image 2',
    //     'label_remove' => 'Remove featured image 2',
    //     'label_use' => 'Set featured image 2',
    //     'post_type' => array( 'blog', 'post' ),
    // );

    // $blog_args_2 = array(
    //     'id' => 'blog-featured-image-3',
    //     'desc' => 'Your description here.',
    //     'label_name' => 'Blog Featured Image 3',
    //     'label_set' => 'Set featured image 3',
    //     'label_remove' => 'Remove featured image 3',
    //     'label_use' => 'Set featured image 3',
    //     'post_type' => array( 'blog', 'post' ),
    // );
    // $featured_images[] = $blog_args_1;
    // $featured_images[] = $blog_args_2;

    /*
      kdmfi_the_featured_image( 'blog-featured-image-2', 'full' );
      kdmfi_the_featured_image( 'blog-featured-image-3', 'full' );
    */

    /* END Blog Featured Images*/


    /* START Mobile Featured Images*/

    $mobile_args = array(
        'id' => 'mobile-featured-image',
        'desc' => 'Mobile banner image',
        'label_name' => 'Mobile Featured Image',
        'label_set' => 'Set Mobile featured image',
        'label_remove' => 'Remove Mobile featured image',
        'label_use' => 'Set Mobile featured image',
        'post_type' => array( 'page', 'post', 'leader', 'event', 'story', 'facility', 'services' ),
    );
    $featured_images[] = $mobile_args;

    $team_args = array(
        'id' => 'team-featured-image',
        'desc' => 'Team featured image',
        'label_name' => 'Team Featured Image',
        'label_set' => 'Set Team featured image',
        'label_remove' => 'Remove Team featured image',
        'label_use' => 'Set Team featured image',
        'post_type' => 'team',
    );
    $featured_images[] = $team_args;

    $homepage_featured_story_args = array(
        'id' => 'homepage-story-featured-image',
        'desc' => 'featured Story image',
        'label_name' => 'Featured Story Image',
        'label_set' => 'Set featured Story image',
        'label_remove' => 'Remove featured Story image',
        'label_use' => 'Set featured Story image',
        'post_type' => 'story',
    );
    $featured_images[] = $homepage_featured_story_args;

    /*
      kdmfi_the_featured_image( 'homepage-story-featured-image', 'mobile-banner' );
    */

    /* END Mobile Featured Images*/

    return $featured_images;


});


/* Related Articles */
function related_posts_shortcode( $atts ) {
  extract(shortcode_atts(array(
      'limit' => '2',
  ), $atts));

  global $wpdb, $post, $table_prefix;

  if ($post->ID) {
    $retval = '<div class="related-articles"><div class="related">Related Articles</div>';
    // Get tags
    $tags = wp_get_post_tags($post->ID);
    $tagsarray = array();
    foreach ($tags as $tag) {
      $tagsarray[] = $tag->term_id;
    }
    $tagslist = implode(',', $tagsarray);

    // Do the query
    $q = "SELECT p.*, count(tr.object_id) as count
      FROM $wpdb->term_taxonomy AS tt, $wpdb->term_relationships AS tr, $wpdb->posts AS p WHERE tt.taxonomy ='post_tag' AND tt.term_taxonomy_id = tr.term_taxonomy_id AND tr.object_id  = p.ID AND tt.term_id IN ($tagslist) AND p.ID != $post->ID
        AND p.post_status = 'publish'
        AND p.post_date_gmt < NOW()
      GROUP BY tr.object_id
      ORDER BY count DESC, p.post_date_gmt DESC
      LIMIT $limit;";

    $related = $wpdb->get_results($q);
    if ( $related ) {
      foreach($related as $r) {
        $retval .= '<div class="col-sm-12 col-md-6"><div class="row"><a title="'.wptexturize($r->post_title).'" href="'.get_permalink($r->ID).'">'.wptexturize($r->post_title).'</a></div></div>';
      }
    } else {
      $retval .= '
      <div class="col-sm-12 col-md-6"><div class="row">No related articles found</div></div>';
    }
    $retval .= '</div>';
    return $retval;
  }
  return;
}
add_shortcode('related_posts', 'related_posts_shortcode');


/*limit excerpt length using characters*/
function get_excerpt($count){
  $permalink = get_permalink($post->ID);
  $excerpt = get_the_excerpt();
  $excerpt = strip_tags($excerpt);
  $excerpt = substr($excerpt, 0, $count);
  $excerpt = $excerpt.'... <br /><a href="'.$permalink.'" class="read-more">Read More<i class="fa-chevron-right"></i></a>';
  return $excerpt;
}
function get_excerpt_button_green($count){
  $permalink = get_permalink($post->ID);
  $excerpt = get_the_excerpt();
  $excerpt = strip_tags($excerpt);
  $excerpt = substr($excerpt, 0, $count);
  $excerpt = $excerpt.'... <br /><a href="'.$permalink.'" class="btn green">Read More</a>';
  return $excerpt;
}

function get_excerpt_button_green_without_dots($count){
  $permalink = get_permalink($post->ID);
  $excerpt = get_the_excerpt();
  $excerpt = strip_tags($excerpt);
  $excerpt = substr($excerpt, 0, $count);
  $excerpt = $excerpt.'<br /><a href="'.$permalink.'" class="btn green">Read More</a>';
  return $excerpt;
}
function get_excerpt_without_button_dots($count){
  $permalink = get_permalink($post->ID);
  $excerpt = get_the_excerpt();
  $excerpt = strip_tags($excerpt);
  $excerpt = substr($excerpt, 0, $count);
  $excerpt = $excerpt.'';
  return $excerpt;
}
function get_excerpt_with_dots_not_button($count){
  $permalink = get_permalink($post->ID);
  $excerpt = get_the_excerpt();
  $excerpt = strip_tags($excerpt);
  $excerpt = substr($excerpt, 0, $count);
  $excerpt = $excerpt.'...';
  return $excerpt;
}

function get_excerpt_button_green_find_out_more($count){
  $permalink = get_permalink($post->ID);
  $excerpt = get_the_excerpt();
  $excerpt = strip_tags($excerpt);
  $excerpt = substr($excerpt, 0, $count);
  $excerpt = $excerpt.'... <br /><a href="'.$permalink.'" class="btn green">Find Out More</a>';
  return $excerpt;
}

/*limit excerpt length using characters*/
function get_excerpt_without_readmore($count){
  $permalink = get_permalink($post->ID);
  $excerpt = get_the_excerpt();
  $excerpt = strip_tags($excerpt);
  $excerpt = substr($excerpt, 0, $count);
  return $excerpt;
}

function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  } 
  $content = preg_replace('/[.+]/','', $content);
  $content = apply_filters('the_content', $content); 
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}




// function searchfilter($query)
// {
//   if ($query->is_search && !is_admin() )
//   {
//     if(isset($_GET['post_type'])) {
//       $types = (array) $_GET['post_type'];
//       $allowed_types = get_post_types(array('public' => true, 'exclude_from_search' => false));
//       foreach($types as $type)
//       {
//         if( in_array( $type, $allowed_types ) ) { $filter_type[] = $type; }
//       }
//       if(count($filter_type))
//       {
//         $query->set('post_type',$filter_type);
//       }
//     }
//   }
// }
// add_filter('pre_get_posts','searchfilter');



add_action( 'after_setup_theme', 'wpdocs_theme_setup' );
function wpdocs_theme_setup() {

    add_theme_support( 'post-thumbnails' );

    /* Mobile Banners*/
    add_image_size( 'mobile-banner', 800, 350, array( 'right', 'top' ) );

    /*Blog*/
    add_image_size( 'blog-listings', 410, 195, array( 'right', 'top' ) );

    add_image_size( 'blog-ralated', 350, 220, array( 'right', 'top' ) );
    add_image_size( 'blog-article-banner', 850, 373, array( 'right', 'top' ) );

    /*Features Story*/
    add_image_size( 'features-story', 535, 355, array( 'right', 'top' ) );
    add_image_size( 'features-story2', 535, 280, array( 'right', 'top' ) );

    /*Upcoming Events*/
    add_image_size( 'upcoming-events', 519, 240, array( 'right', 'top' ) );

    /*Features Team*/
    add_image_size( 'features-team', 150, 150, array( 'right', 'top' ) );
}


/* Gravity Forms After Submission Goes to Anchor */
//add_filter( 'gform_confirmation_anchor', '__return_true' );
// add_filter( 'gform_confirmation_anchor', function() {
//     return 20;
// } );




/* =======================================
  START FUNCTIONS WITH SHORTCODES
======================================= */

  /* START Featured Story Post */
    function featured_stories_one_post_function( $atts ) {
        $featured_args = array(
          'post_type'      => 'story',
          'posts_per_page' => 1,
          'post_status'    => 'publish',
          'post__not_in'   => array( get_the_ID() ),
        );
        // print_r($featured_args);

        $featured = new WP_Query( $featured_args );

        if( $featured->have_posts() ): ?>
          <div class="featured-story-article">
              <?php while( $featured->have_posts() ): $featured->the_post(); ?>
                <div class="col-sm-12 col-md-6 cols">
                  <div class="thumb">
                    <?php kdmfi_the_featured_image( 'homepage-story-featured-image', 'features-story2' ); ?>
                  </div>
                </div>
                <div class="col-sm-12 col-md-6 cols">
                  <div class="article">
                    <div class="title"><?php the_title(); ?></div>
                    <div class="summary"><?php echo get_excerpt_button_green(500); ?></div>
                  </div>
                </div>
              <?php endwhile; ?>
          </div>
        <?php endif;
        wp_reset_postdata();
    }

    function featured_stories_three_post_function( $atts ) {
        $featured_args = array(
          'post_type'      => 'story',
          'posts_per_page' => 4,
          'post_status'    => 'publish',
          'post__not_in'   => array( get_the_ID() ),
        );
        // print_r($featured_args);

        $featured = new WP_Query( $featured_args );

        if( $featured->have_posts() ): ?>
          <div class="featured-stories-three-article">
              <?php 
                $i=0;
                while( $featured->have_posts() ): $featured->the_post(); 
                ++$i;
                  if($i==1) //skip first post
                  continue;
              ?>
                <div class="col-sm-12 col-md-4 cols">
                  <div class="thumb"><?php the_post_thumbnail( 'features-story2' ); ?></div>
                  <div class="title"><?php the_title(); ?></div>
                  <div class="summary"><?php echo get_excerpt(220); ?></div>
                  <!-- <div class="readMore"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="read-more">Read More</a></div> -->

                </div>
              <?php endwhile; ?>
          </div>
        <?php endif;
        wp_reset_postdata();
    }
  /* END Featured Story Post */



  /* START Featured Team Posts */
    function featured_team_three_post_function( $atts ) {
        $featured_args = array(
          'post_type'      => 'team',
          'posts_per_page' => 2,
          'post_status'    => 'publish',
          'post__not_in'   => array( get_the_ID() ),
        );
        // print_r($featured_args);

        $featured = new WP_Query( $featured_args );

        if( $featured->have_posts() ): ?>
          <div class="featured-team-article">
            <?php while( $featured->have_posts() ): $featured->the_post(); ?>
              <div class="col-sm-12 col-md-6 cols">
                <div class="thumb"><?php kdmfi_the_featured_image( 'team-featured-image', 'mobile-banner' ); ?></div>
                <div class="title"><?php the_title(); ?></div>
                <div class="summary"><?php echo the_excerpt(); ?></div>
                <!-- <div class="readMore"><a href="http://conversionadvantage-staging.com/inharmonie/team/" title="<?php the_title(); ?>" class="btn green-hover-transparent">Read More</a></div> -->
              </div>
            <?php endwhile; ?>
          </div>
        <?php endif;
        wp_reset_postdata();
    }
/* END Featured Team Posts */



/* START Featured Team Posts */
    function featured_team_post_function( $atts ) {
        $featured_args = array(
          'post_type'      => 'team',
          'posts_per_page' => -1,
          'post_status'    => 'publish',
          'post__not_in'   => array( get_the_ID() ),
        );
        // print_r($featured_args);

        $featured = new WP_Query( $featured_args );

        if( $featured->have_posts() ): ?>
          <div class="featured-team-article">
            <?php while( $featured->have_posts() ): $featured->the_post(); ?>
              <div class="col-sm-12 col-md-6 cols">
                <div class="thumb"><?php kdmfi_the_featured_image( 'team-featured-image', 'mobile-banner' ); ?></div>
                <div class="title"><?php the_title(); ?></div>
                <div class="summary"><?php the_content(); ?></div>
              </div>
            <?php endwhile; ?>
          </div>
        <?php endif;
        wp_reset_postdata();
    }
/* END Featured Team Posts */



/* START Featured Events Posts */
    function featured_events_two_post_function( $atts ) {
        $featured_args = array(
          'post_type'      => 'event',
          'posts_per_page' => 2,
          'post_status'    => 'publish',
          'post__not_in'   => array( get_the_ID() ),
        );
        
        $featured = new WP_Query( $featured_args );
        //print_r($featured);


        if( $featured->have_posts() ): ?>
          <div class="featured-events-article">
            <?php while( $featured->have_posts() ): $featured->the_post(); ?>

              <?php
                $start_date_picker = strtotime(get_field('start_date_picker'));
                $d = date_i18n("d", $start_date_picker); // Single Date eg 05 
                $D = date_i18n("D", $start_date_picker); // Day eg Monday
                $M = date_i18n("F", $start_date_picker); // Day eg January
                $Y = date_i18n("Y", $start_date_picker); // Day eg 2017
                $startDate = date_i18n("d F Y", $start_date_picker);
              ?>

              <div class="col-sm-12 col-md-6 cols">
                <div class="thumb"><?php the_post_thumbnail( 'upcoming-events' ); ?></div>
                <div class="date"><?php echo $startDate; ?></div>
                <div class="title"><?php the_title(); ?></div>
                <div class="summary"><?php echo get_excerpt_button_green_find_out_more(200); ?></div>
              </div>
            <?php endwhile; ?>
          </div>
        <?php endif;
        wp_reset_postdata();
    }
/* END Featured Team Posts */


/* START Speakers */
    function team_speakers_function( $atts ) {
      // Get post by post ID.
      $post = get_post( $post->ID );
   
      // Get post type by post.
      $post_type = $post->post_type;
   
      // Get post type taxonomies.
      $taxonomies = get_object_taxonomies( $post_type, 'speaker' );
   
      $out = array();
   
      foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){
   
          // Get the terms related to post.
          $terms = get_the_terms( $post->ID, $taxonomy_slug );
          // print_r($terms);

          if ( ! empty( $terms ) ) {
          ?>
          <div class="speakers">
            <div class="header">Your Speakers</div>
            <div class="slider responsive">
            <?php foreach ( $terms as $term ) { ?>
              <div>
                <div class="summary">
                  <?php echo $term->description ?>
                  <div class="title"><?php echo $term->name; ?></div>
                </div>
              </div>
              <?php } ?> 
            </div>
            <!-- control arrows -->
            <div class="prev">
              <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            </div>
            <div class="next">
              <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            </div>
          </div>
          <?php 
          }
      }
      return;
    }
/* END Speakers */


/* START Featured Event Posts */
    function featured_event_function( $atts ) {

        $featured_args = array(
          'post_type'      => 'event',
          'posts_per_page' => 1,
          'post_status'    => 'publish',
          'post__not_in'   => array( get_the_ID() ),
          'meta_query'     => array(
            array(
              'key' => 'featured', // name of custom field
              'value' => '1', // matches exaclty "123", not just 123. This prevents a match for "1234"
              'compare' => '=='
            )
          )
        );

        $featured = new WP_Query( $featured_args );

        if( $featured->have_posts() ): ?>
          <div class="event_featured">
            <?php while( $featured->have_posts() ): $featured->the_post(); ?>
              <div class="col-md-3 date">
                <?php

                  $event_name = get_field('event_name');
                  $location = get_field('location');
                  $organiser = get_field('organiser');
                  $cost = get_field('cost');

                  $rsvp = strtotime(get_field('rsvp'));
                  $rsvpDate = date_i18n("d F Y", $rsvp);
                  // echo $rsvpDate;

                  $start_date_picker = strtotime(get_field('start_date_picker'));

                  $d = date_i18n("d", $start_date_picker); // Single Date eg 05
                  // echo $d; 
                  $D = date_i18n("D", $start_date_picker); // Day eg Monday
                  // echo $D; 
                  $M = date_i18n("F", $start_date_picker); // Day eg January
                  // echo $M; 
                  $Y = date_i18n("Y", $start_date_picker); // Day eg 2017
                  // echo $Y; 

                ?>
                <span class="day"><?php echo $d; ?></span>
                <span class="month"><?php echo $M;; ?></span>
                <?php

                  /*Start Date*/
                  //$start_date_picker = strtotime(get_field('start_date_picker'));
                  $startDate = date_i18n("Ymd", $start_date_picker);
                  

                  /*Start Time*/
                  $start_time_picker = strtotime(get_field('start_date_picker'));
                  $startTime = date_i18n("Hi00", $start_date_picker);
                  $startTimeFull = date_i18n("H:i a", $start_date_picker);

                  /*Start Output*/
                  $openingDateTime = $startDate."T".$startTime."Z";



                  /*End Date*/  
                  $end_date_picker = strtotime(get_field('end_date_picker'));
                  $endDate = date_i18n("Ymd", $end_date_picker);

                  /*End Time*/
                  $end_time_picker = strtotime(get_field('end_date_picker'));
                  $endTime = date_i18n("Hi00", $end_date_picker);
                  $endTimeFull = date_i18n("H:i a", $end_date_picker);
                  
                  /*End Output*/
                  $ClosingDateTime = $endDate."T".$endTime."Z";


                  $sessionTimes = $startTimeFull." - ".$endTimeFull;

                ?>

                <a href="https://www.google.com/calendar/render?action=TEMPLATE&text=<?php the_title(); ?>&dates=<?php echo $openingDateTime; ?>/<?php echo $ClosingDateTime; ?>&details=<?php echo content(300); ?>&location=<?php echo $location; ?>&sf=true&output=xml" target="_blank" rel="nofollow" class="btn transparent-white-green">Add to Calendar</a>

              </div>

              <div class="col-md-5">
                <strong><?php the_title(); ?></strong>
                <p><?php echo get_excerpt(350); ?></p>
              </div>
              <div class="col-md-4">
                <span class="feat">FEATURED</span>
                <p>Cost: <strong><?php echo $cost; ?> </strong></p>
                <p>Venue: <strong><?php echo $location; ?> </strong></p>
                <p>Time: <strong><?php echo $sessionTimes; ?></strong></p>
              </div>
            <?php endwhile; ?>
          </div>
        <?php endif;
        wp_reset_postdata();
    }
/* END Featured Event Posts */




/* START Featured Post Event */
    function featured_post_events_function( $atts ) {
      
      // Get post by post ID.
      $post = get_post( $post->ID );
   
      // Get post type by post.
      $post_type = $post->post_type;
   
      $args = array(
        'p'         => $post, // ID of a page, post, or custom type
        'post_type' => $post_type
      );
      $my_posts = new WP_Query($args);

      if( $my_posts->have_posts() ):

        $event_name = get_field('event_name');
        $location = get_field('location');
        $organiser = get_field('organiser');
        $cost = get_field('cost');

        $start_date_picker = strtotime(get_field('start_date_picker'));

        $d = date_i18n("d", $start_date_picker); // Single Date eg 05
        //echo $d; 
        $D = date_i18n("D", $start_date_picker); // Day eg Monday
        //echo $D; 
        $M = date_i18n("F", $start_date_picker); // Day eg January
        //echo $M; 
        $Y = date_i18n("Y", $start_date_picker); // Day eg 2017
        //echo $Y; 


        /*Start Date*/
        $start_date_picker_Full = date_i18n("d F Y", $start_date_picker);
        $startDate = date_i18n("Ymd", $start_date_picker);

        $rsvp = strtotime(get_field('rsvp'));
        $rsvpDate = date_i18n("d F Y", $rsvp);
        //echo $rsvpDate;

        /*Start Time*/
        $start_time_picker = strtotime(get_field('start_date_picker'));
        $startTime = date_i18n("Hi00", $start_date_picker);
        $startTimeFull = date_i18n("H:i", $start_date_picker);

        /*Start Output*/
        $openingDateTime = $startDate."T".$startTime."Z";



        /*End Date*/  
        $end_date_picker = strtotime(get_field('end_date_picker'));
        $endDate = date_i18n("Ymd", $end_date_picker);

        /*End Time*/
        $end_time_picker = strtotime(get_field('end_date_picker'));
        $endTime = date_i18n("Hi00", $end_date_picker);
        $endTimeFull = date_i18n("H:i", $end_date_picker);
        
        /*End Output*/
        $ClosingDateTime = $endDate."T".$endTime."Z";


        $sessionTimes = $startTimeFull." - ".$endTimeFull;

      ?>

        <div class="row">
          <div class="col-sm-12 col-md-9 event-details">
            <div class="content">
              <div class="top-level">
                <h3><?php the_title(); ?></h3>
                <span>Date:</span> <?php echo $start_date_picker_Full; ?><br />
                <span>Time:</span> <?php echo $sessionTimes; ?>
              </div>
              <span>RSVP:</span> <?php echo $rsvpDate; ?> | <span>Venue:</span> <?php echo $location; ?><br />
              <span>Organiser:</span> <?php echo $organiser; ?> | <span>Cost:</span> <?php echo $cost; ?>
            </div>
          </div>
          <div class="col-sm-12 col-md-3 interested">
            <div class="content">
              <h4>Interested?</h4>
              <a href="#gform_wrapper_18" class="btn transparent-white-green">Book Now</a>
            </div>
          </div>
        </div>

      <?php
      endif;
      wp_reset_postdata();
    }
/* END Featured Post Event */





/* REGISTER ALL SHORTCODES */

  function register_shortcodes(){
    add_shortcode('featured_stories_one_post', 'featured_stories_one_post_function');
    add_shortcode('featured_stories_three_post', 'featured_stories_three_post_function');
    add_shortcode('featured_team_post', 'featured_team_post_function');
    add_shortcode('featured_team_three_post', 'featured_team_three_post_function');
    add_shortcode('featured_events_two_post', 'featured_events_two_post_function');
    add_shortcode('team_speakers', 'team_speakers_function');
    add_shortcode('featured_event', 'featured_event_function');
    add_shortcode('featured_post_events', 'featured_post_events_function');
  }
  add_action( 'init', 'register_shortcodes');


/* =======================================
  END FUNCTIONS WITH SHORTCODES
======================================= */



/* ==============================================================
  Fix Gravity Form Tabindex Conflicts
  https://gravitywiz.com/fix-gravity-form-tabindex-conflicts/
============================================================== */
add_filter( 'gform_tabindex', 'gform_tabindexer', 10, 2 );
function gform_tabindexer( $tab_index, $form = false ) {
    $starting_index = 1000; // if you need a higher tabindex, update this number
    if( $form )
        add_filter( 'gform_tabindex_' . $form['id'], 'gform_tabindexer' );
    return GFCommon::$tab_index >= $starting_index ? GFCommon::$tab_index : $starting_index;
}
/* ==============================================================
  END
============================================================== */



/* =================================================
  START REMOVE QUERY STRINGS FROM STATIC RESOURCES
================================================= */
function ewp_remove_script_version( $src ){
  return remove_query_arg( 'ver', $src );
}
add_filter( 'script_loader_src', 'ewp_remove_script_version', 10, 2 );
add_filter( 'style_loader_src', 'ewp_remove_script_version', 10, 2 );
/* =================================================
  END REMOVE QUERY STRINGS FROM STATIC RESOURCES
================================================= *