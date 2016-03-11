<?php

/**
 * Get all zip
 *
 * @param $args array
 *
 * @return array
 */
function ziparea_get_all_zip( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'number'     => 20,
        'offset'     => 0,
        'orderby'    => 'id',
        'order'      => 'ASC',
    );

    $args      = wp_parse_args( $args, $defaults );
    $cache_key = 'zip-all';
    $items     = wp_cache_get( $cache_key, 'arwir' );

    if ( false === $items ) {
        $items = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'z ORDER BY ' . $args['orderby'] .' ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number'] );

        wp_cache_set( $cache_key, $items, 'arwir' );
    }

    return $items;
}

/**
 * Fetch all zip from database
 *
 * @return array
 */
function ziparea_get_zip_count() {
    global $wpdb;

    return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'z' );
}

/**
 * Fetch a single zip from database
 *
 * @param int   $id
 *
 * @return array
 */
function ziparea_get_zip( $id = 0 ) {
    global $wpdb;

    return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'z WHERE id = %d', $id ) );
}

/**
 * Insert a new zip
 *
 * @param array $args
 */
function ziparea_insert_zip( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'id'         => null,
        'street_name' => '',
        'kecamatan' => '',
        'Kelurahan' => '',
        'zip' => '',
        'area_id' => '',

    );

    $args       = wp_parse_args( $args, $defaults );
    $table_name = $wpdb->prefix . 'z';

    // some basic validation
    if ( empty( $args['street_name'] ) ) {
        return new WP_Error( 'no-street_name', __( 'No Nama Jalan provided.', 'arwir' ) );
    }
    if ( empty( $args['kecamatan'] ) ) {
        return new WP_Error( 'no-kecamatan', __( 'No Kecamatan provided.', 'arwir' ) );
    }
    if ( empty( $args['kelurahan'] ) ) {
        return new WP_Error( 'no-kelurahan', __( 'No Kelurahan provided.', 'arwir' ) );
    }
    if ( empty( $args['zip'] ) ) {
        return new WP_Error( 'no-zip', __( 'No Kode Pos provided.', 'arwir' ) );
    }
    if ( empty( $args['area_id'] ) ) {
        return new WP_Error( 'no-area_id', __( 'No Area provided.', 'arwir' ) );
    }

    // remove row id to determine if new or update
    $row_id = (int) $args['id'];
    unset( $args['id'] );

    if ( ! $row_id ) {

        $args['date'] = current_time( 'mysql' );

        // insert a new
        if ( $wpdb->insert( $table_name, $args ) ) {
            return $wpdb->insert_id;
        }

    } else {

        // do update method here
        if ( $wpdb->update( $table_name, $args, array( 'id' => $row_id ) ) ) {
            return $row_id;
        }
    }

    return false;
}