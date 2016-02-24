<div class="wrap">
    <h1><?php _e( 'Add New Item', 'arwir' ); ?></h1>

    <form action="" method="post">

        <table class="form-table">
            <tbody>
                <tr class="row-street-name">
                    <th scope="row">
                        <label for="street_name"><?php _e( 'Nama Jalan', 'arwir' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="street_name" id="street_name" class="regular-text" placeholder="<?php echo esc_attr( '', 'arwir' ); ?>" value="" required="required" />
                    </td>
                </tr>
                <tr class="row-district">
                    <th scope="row">
                        <label for="district"><?php _e( 'Kelurahan', 'arwir' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="district" id="district" class="regular-text" placeholder="<?php echo esc_attr( '', 'arwir' ); ?>" value="" required="required" />
                    </td>
                </tr>
                <tr class="row-zip">
                    <th scope="row">
                        <label for="zip"><?php _e( 'Kode Pos', 'arwir' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="zip" id="zip" class="regular-text" placeholder="<?php echo esc_attr( '', 'arwir' ); ?>" value="" required="required" />
                    </td>
                </tr>
                <tr class="row-area-id">
                    <th scope="row">
                        <label for="area_id"><?php _e( 'Area', 'arwir' ); ?></label>
                    </th>
                    <td>
                        <select name="area_id" id="area_id" required="required">
                            <option value="">Select One</option>
                            <option value="1">Jakarta Barat</option>
                            <option value="2">Jakarta Selatan</option>
                            <option value="3">Jakarta Pusat</option>
                            <option value="4">Jakarta Utara</option>
                        </select>
                    </td>
                </tr>
             </tbody>
        </table>

        <input type="hidden" name="field_id" value="0">

        <?php wp_nonce_field( 'zip-new' ); ?>
        <?php submit_button( __( 'Add Item', 'arwir' ), 'primary', 'submit_ziparea' ); ?>

    </form>
</div>