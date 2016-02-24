<?php

/**
 * Handle the form submissions
 *
 * @package Package
 * @subpackage Sub Package
 */
class Form_Handler {

    /**
     * Hook 'em all
     */
    public function __construct() {
        add_action( 'admin_init', array( $this, 'handle_form' ) );
    }

    /**
     * Handle the zip new and edit form
     *
     * @return void
     */
    public function handle_form() {
        if ( ! isset( $_POST['submit_ziparea'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'zip-new' ) ) {
            die( __( 'Are you cheating?', 'arwir' ) );
        }

        if ( ! current_user_can( 'read' ) ) {
            wp_die( __( 'Permission Denied!', 'arwir' ) );
        }

        $errors   = array();
        $page_url = admin_url( 'admin.php?page=zip-area' );
        $field_id = isset( $_POST['field_id'] ) ? intval( $_POST['field_id'] ) : 0;

        $street_name = isset( $_POST['street_name'] ) ? sanitize_text_field( $_POST['street_name'] ) : '';
        $district = isset( $_POST['district'] ) ? sanitize_text_field( $_POST['district'] ) : '';
        $zip = isset( $_POST['zip'] ) ? sanitize_text_field( $_POST['zip'] ) : '';
        $area_id = isset( $_POST['area_id'] ) ? sanitize_text_field( $_POST['area_id'] ) : '';

        // some basic validation
        if ( ! $street_name ) {
            $errors[] = __( 'Error: Nama Jalan is required', 'arwir' );
        }

        if ( ! $district ) {
            $errors[] = __( 'Error: Kelurahan is required', 'arwir' );
        }

        if ( ! $zip ) {
            $errors[] = __( 'Error: Kode Pos is required', 'arwir' );
        }

        if ( ! $area_id ) {
            $errors[] = __( 'Error: Area is required', 'arwir' );
        }

        // bail out if error found
        if ( $errors ) {
            $first_error = reset( $errors );
            $redirect_to = add_query_arg( array( 'error' => $first_error ), $page_url );
            wp_safe_redirect( $redirect_to );
            exit;
        }

        $fields = array(
            'street_name' => $street_name,
            'district' => $district,
            'zip' => $zip,
            'area_id' => $area_id,
        );

        // New or edit?
        if ( ! $field_id ) {

            $insert_id = ziparea_insert_zip( $fields );

        } else {

            $fields['id'] = $field_id;

            $insert_id = ziparea_insert_zip( $fields );
        }

        if ( is_wp_error( $insert_id ) ) {
            $redirect_to = add_query_arg( array( 'message' => 'error' ), $page_url );
        } else {
            $redirect_to = add_query_arg( array( 'message' => 'success' ), $page_url );
        }

        wp_safe_redirect( $redirect_to );
        exit;
    }
}

new Form_Handler();