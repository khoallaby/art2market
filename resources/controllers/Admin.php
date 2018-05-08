<?php
namespace Art2Market\Plugin;

class Admin extends Base {


    public static $nonce        = 'art2market-nonce';   // name of nonce to use
    public static $optionName   = 'art2market_input';   // name of input field
    public static $capability   = 'edit_theme_options'; // capability level for user to view/edit admin page


    public function init() {
        add_action( 'admin_menu', [ $this, 'addmenu' ] );
    }


    /**
     * Adds an admin menu link to the sidebar
     */
    public function addmenu() {
        $menuSlug = 'art2market';
        $hook = add_menu_page(
            __( 'Art2MARKET' ),
            __( 'Art2MARKET' ),
            static::$capability,
            $menuSlug,
            [ $this, 'menuPage' ]
        );

        add_action( 'load-' . $hook, [ $this, 'savePage' ] );
    }


    /**
     * Pulls the view for the questions submenu pageg
     */
    public function menuPage() {
        static::getMenuView( 'admin' );
    }


    /**
     * Saves the questions on the questions submenu page
     */
    public static function savePage() {
        if( isset($_POST[ self::$optionName ]) && isset($_POST[ static::$nonce ]) )
            self::saveAdmin( $_POST[ self::$optionName ] );
    }


    /**
     * Generic function for saving questions
     * @param array $data
     */
    public static function saveAdmin( $data = [] ) {
        if( !$data || empty($data) ) {
            if( isset($_POST[ self::$optionName ]) )
                $data = $_POST[ self::$optionName ];
            else
                return;
        }


        if( !self::canUpdateData() )
            return;

        $data = self::sanitizeData( $data );
        $update = update_option( self::$optionName, $data );

        self::printAdminNotices( $update );

    }







    /**************************************************************************************************************
     * Generic functions for saving/sanitizing custom data
     *************************************************************************************************************/



    /**
     * Prints out admin notices for notifying the user if their $update is successful or not
     * @param $update   true/false
     */
    public static function printAdminNotices( $update ) {
        add_action( 'admin_notices', function() use($update) {
            if( $update ) {
                $message = 'Saved successfully!';
                $messageClass = 'updated fade';
            } else {
                $message = 'Error while updating..';
                $messageClass = 'error';
            }

            echo '<div class="' . $messageClass . '"><p><strong>' . __( $message ) . '</strong></p></div>';
        } );
    }


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

add_action( 'init', array( \Art2Market\Plugin\Admin::get_instance(), 'init' ));
