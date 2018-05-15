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
            self::$capability,
            $menuSlug,
            [ $this, 'menuPage' ]
        );

        add_action( 'load-' . $hook, [ AdminModel::get_instance(), 'savePage' ] );
    }


    /**
     * Pulls the view for the questions submenu pageg
     */
    public function menuPage() {
        static::getMenuView( 'admin' );
    }





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


}

add_action( 'init', array( \Art2Market\Plugin\Admin::get_instance(), 'init' ));
