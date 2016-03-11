<?php

if ( ! class_exists ( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * List table class
 */
class Ziparea_List_Table extends \WP_List_Table {

    function __construct() {
        parent::__construct( array(
            'singular' => 'zip',
            'plural'   => 'zips',
            'ajax'     => false
        ) );
    }

    function get_table_classes() {
        return array( 'widefat', 'fixed', 'striped', $this->_args['plural'] );
    }

    /**
     * Message to show if no designation found
     *
     * @return void
     */
    function no_items() {
        _e( 'No item found!', 'arwir' );
    }

    /**
     * Default column values if no callback found
     *
     * @param  object  $item
     * @param  string  $column_name
     *
     * @return string
     */
    function column_default( $item, $column_name ) {

        switch ( $column_name ) {
            case 'street_name':
                return $item->street_name;

            case 'kecamatan':
                return $item->kecamatan;

            case 'kelurahan':
                return $item->kelurahan;

            case 'zip':
                return $item->zip;

            case 'area_id':
                if ($item->area_id=='1') {
                    $item->area_id='Jakarta Barat';
                } else if ($item->area_id=='2') {
                    $item->area_id='Jakarta Selatan';
                } else if ($item->area_id=='3') {
                    $item->area_id='Jakarta Pusat';
                } else if ($item->area_id=='4') {
                    $item->area_id='Jakarta Utara';
                }
                return $item->area_id;

            default:
                return isset( $item->$column_name ) ? $item->$column_name : '';
        }
    }

    /**
     * Get the column names
     *
     * @return array
     */
    function get_columns() {
        $columns = array(
            'cb'           => '<input type="checkbox" />',
            'street_name'      => __( 'Nama Jalan', 'arwir' ),
            'kecamatan'      => __( 'Kecamatan', 'arwir' ),
            'kelurahan'      => __( 'Kelurahan', 'arwir' ),
            'zip'      => __( 'Kode Pos', 'arwir' ),
            'area_id'      => __( 'Area', 'arwir' ),

        );

        return $columns;
    }

    /**
     * Render the designation name column
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_street_name( $item ) {

        $actions           = array();
        $actions['edit']   = sprintf( '<a href="%s" data-id="%d" title="%s">%s</a>', admin_url( 'admin.php?page=zip-area&action=edit&id=' . $item->id ), $item->id, __( 'Edit this item', 'arwir' ), __( 'Edit', 'arwir' ) );
        $actions['delete'] = sprintf( '<a href="%s" class="submitdelete" data-id="%d" title="%s">%s</a>', admin_url( 'admin.php?page=zip-area&action=delete&id=' . $item->id ), $item->id, __( 'Delete this item', 'arwir' ), __( 'Delete', 'arwir' ) );

        return sprintf( '<a href="%1$s"><strong>%2$s</strong></a> %3$s', admin_url( 'admin.php?page=zip-area&action=view&id=' . $item->id ), $item->street_name, $this->row_actions( $actions ) );
    }

    /**
     * Get sortable columns
     *
     * @return array
     */
    function get_sortable_columns() {
        $sortable_columns = array(
            'name' => array( 'name', true ),
        );

        return $sortable_columns;
    }

    /**
     * Set the bulk actions
     *
     * @return array
     */
    function get_bulk_actions() {
        $actions = array(
            'trash'  => __( 'Move to Trash', 'arwir' ),
        );
        return $actions;
    }

    /**
     * Render the checkbox column
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="zip_id[]" value="%d" />', $item->id
        );
    }

    /**
     * Set the views
     *
     * @return array
     */
    public function get_views_() {
        $status_links   = array();
        $base_link      = admin_url( 'admin.php?page=sample-page' );

        foreach ($this->counts as $key => $value) {
            $class = ( $key == $this->page_status ) ? 'current' : 'status-' . $key;
            $status_links[ $key ] = sprintf( '<a href="%s" class="%s">%s <span class="count">(%s)</span></a>', add_query_arg( array( 'status' => $key ), $base_link ), $class, $value['label'], $value['count'] );
        }

        return $status_links;
    }

    /**
     * Prepare the class items
     *
     * @return void
     */
    function prepare_items() {

        $columns               = $this->get_columns();
        $hidden                = array( );
        $sortable              = $this->get_sortable_columns();
        $this->_column_headers = array( $columns, $hidden, $sortable );

        $per_page              = 20;
        $current_page          = $this->get_pagenum();
        $offset                = ( $current_page -1 ) * $per_page;
        $this->page_status     = isset( $_GET['status'] ) ? sanitize_text_field( $_GET['status'] ) : '2';

        // only ncessary because we have sample data
        $args = array(
            'offset' => $offset,
            'number' => $per_page,
        );

        if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
            $args['orderby'] = $_REQUEST['orderby'];
            $args['order']   = $_REQUEST['order'] ;
        }

        $this->items  = ziparea_get_all_zip( $args );

        $this->set_pagination_args( array(
            'total_items' => ziparea_get_zip_count(),
            'per_page'    => $per_page
        ) );
    }
}