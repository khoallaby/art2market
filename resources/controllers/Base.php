<?php

namespace Art2Market\Plugin;


class Base {
    private static $instance = array();
    public static $capability;

	protected function __construct() {
	}


	public static function get_instance() {
		$c = get_called_class();
		if ( !isset( self::$instance[$c] ) ) {
			self::$instance[$c] = new $c();
			self::$instance[$c]->init();
		}
		return self::$instance[$c];
	}

	public function init() {
        #add_action( '_admin_menu', [ $this, 'admin_init' ], 2 );

        if( is_admin() ) {
            //add_action( 'admin_enqueue_scripts', [ $this, 'adminEnqueueScripts' ] );
        }

    }



	public static function get( $var ) {
		return static::$$var;
	}



    // do stuff on admin
    public function admin_init() {

    }

    public static function getView( $file, $return = false ) {
        $dirPlugin = dirname(__FILE__) . '/../views/';
        $dirtheme = 'views/';
        $fileName = $file . '.php';

        if( $theme_file = locate_template([ $dirtheme . $fileName ]) )
            $template = $theme_file;
        else
            $template = $dirPlugin . $fileName;


        if( $return )
            ob_start();

        include $template;

        if( $return )
            return ob_get_clean();
        else
            return null;

    }


    /**
     * Generic getView() function that runs common functions like checking for capability access
     * @param string $view  File name of the view w/o .php
     */
    public function getMenuView( $view ) {
        if ( !current_user_can( static::$capability ) )
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        static::getView( $view );
    }



}

add_action( 'plugins_loaded', array( \Art2Market\Plugin\Base::get_instance(), 'init' ));