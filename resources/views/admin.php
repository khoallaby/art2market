<?php
use Art2Market\Plugin\Admin;

$input = get_option( Admin::$optionName );
?>

<div class="wrap">
    <form name="form1" method="post" action="">
        <h1><?php _e( 'Art2MARKET' ); ?></h1>
        <table class="form-table" width="100%">
            <tbody>
            <tr>
                <th scope="row"><label for="blogname"><?php _e( 'Some Input!'); ?></label></th>
                <td><input name="<?php echo Admin::$optionName; ?>" id="blogname" value="<?php esc_attr_e( $input ); ?>" class="regular-text" type="text"></td>
            </tr>
            </tbody>
        </table>

        <p class="submit">
            <?php wp_nonce_field( Admin::$nonce, Admin::$nonce ); ?>
            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e( __('Save Changes') ) ?>" />
        </p>

    </form>
</div>
