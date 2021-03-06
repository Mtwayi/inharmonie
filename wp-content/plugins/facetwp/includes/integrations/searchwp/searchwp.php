<?php

class FacetWP_Integration_SearchWP
{

    public $search_terms;


    function __construct() {

        // Require SearchWP 2.6+
        if ( version_compare( SEARCHWP_VERSION, '2.6', '<' ) ) {
            return;
        }

        add_filter( 'facetwp_query_args', array( $this, 'search_args' ), 10, 2 );
        add_filter( 'facetwp_filtered_post_ids', array( $this, 'search_page' ), 10, 2 );
        add_filter( 'facetwp_facet_filter_posts', array( $this, 'search_facet' ), 10, 2 );
    }


    /**
     * Prevent the default WP search from running when SearchWP is enabled
     * @since 1.3.2
     */
    function search_args( $args, $class ) {

        if ( $class->is_search ) {
            $this->search_terms = $args['s'];
            unset( $args['s'] );

            $args['suppress_filters'] = true;
            if ( empty( $args['post_type'] ) ) {
                $args['post_type'] = 'any';
            }
        }

        return $args;
    }


    /**
     * Use SWP_Query to retrieve matching post IDs
     * @since 2.1.2
     */
    function search_page( $post_ids, $class ) {

        if ( empty( $this->search_terms ) ) {
            return $post_ids;
        }

        $swp_query = new SWP_Query( array(
            's'                 => $this->search_terms,
            'posts_per_page'    => 200,
            'load_posts'        => false,
            'facetwp'           => true,
        ) );

        $intersected_ids = array();
        foreach ( $swp_query->posts as $post_id ) {
            if ( in_array( $post_id, $post_ids ) ) {
                $intersected_ids[] = $post_id;
            }
        }
        $post_ids = $intersected_ids;

        return empty( $post_ids ) ? array( 0 ) : $post_ids;
    }


    /**
     * Intercept search facets using SearchWP engine
     * @since 2.1.5
     */
    function search_facet( $return, $params ) {
        $facet = $params['facet'];
        $selected_values = $params['selected_values'];
        $selected_values = is_array( $selected_values ) ? $selected_values[0] : $selected_values;

        if ( ! empty( $facet['search_engine'] ) ) {
            if ( empty( $selected_values ) ) {
                return 'continue';
            }

            $swp_query = new SWP_Query( array(
                's'                 => $selected_values,
                'engine'            => $facet['search_engine'],
                'posts_per_page'    => 200,
                'load_posts'        => false,
                'facetwp'           => true,
            ) );

            return $swp_query->posts;
        }

        return $return;
    }
}


if ( is_plugin_active( 'searchwp/searchwp.php' ) ) {
    new FacetWP_Integration_SearchWP();
}
