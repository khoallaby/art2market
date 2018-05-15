<?php
namespace Art2Market\Plugin;

class AdminModel extends Admin {


    public function init() {
    }


    /**
     * Saves the questions on the questions submenu page
     */
    public static function savePage() {
        if( isset($_POST[ static::$optionName ]) && isset($_POST[ static::$nonce ]) )
            self::saveAdmin( $_POST[ static::$optionName ] );
    }


    /**
     * Generic function for saving questions
     * @param array $data
     */
    public static function saveAdmin( $data = [] ) {
        if( !$data || empty($data) ) {
            if( isset($_POST[ static::$optionName ]) )
                $data = $_POST[ static::$optionName ];
            else
                return;
        }


        if( !self::canUpdateData() )
            return;

        $data = self::sanitizeData( $data );
        $update = update_option( static::$optionName, $data );

        static::printAdminNotices( $update );

    }







    /**************************************************************************************************************
     * Generic functions for saving/sanitizing custom data
     *************************************************************************************************************/


    /**
     * Checks to see if the user can update the post based on verifying the nonce, and if their capabilities are enough
     * @return bool
     */
    public static function canUpdateData() {
        if( current_user_can( static::$capability) ) {
            if( !isset( $_POST[ static::$nonce ] ) || !wp_verify_nonce( $_POST[ static::$nonce ], static::$nonce ) )
                return false;
            else
                return true;
        }
        return false;
    }


    /**
     * Sanitizes the data (from $_POST)
     * @param $data
     *
     * @return array
     */
    public static function sanitizeData( $data ) {
        $data = sanitize_text_field(stripslashes_deep( $data  ) );
        return $data;
    }


}

add_action( 'init', array( \Art2Market\Plugin\AdminModel::get_instance(), 'init' ));
