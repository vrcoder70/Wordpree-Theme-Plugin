<?php

/**
 * The file defines Dashboard Widget
 *
 * @since      1.0.0
 *
 * @package    WP_BOOK
 * @subpackage WP_BOOK/templates/base
 */

/**
 * This file define all the necessary code for defining Dashboard Widget and It's callback.
 * 
 * @since      1.0.0
 * @package    WP_BOOK
 * @subpackage WP_BOOK/templates/base
 * @author     Vraj Rana vrcoder1998@gmail.com
 */

require_once WP_BOOK_PLUGIN_PATH . 'templates/callback/dashboard-widget-callback.php';

class DashboardWidget{

    /**
	 * Varriable for instantiate dashboard widget array.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array   $widgets  
	 */
    private $widgets = [];

    /**
	 * Varriable for instantiate callback class.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      Object   $setting_page  Object of AdminSettingPageCallback class.
	 */
    private $callback;

    /**
     *  Constructor method for instantiate $callback and $widgets.
     */
    public function __construct(){
        $this->callback = new DashboardWidgetCallback();
        $this->set_widgets();
    }

    /**
     * Method adding values to $widgets array
     *
     * @return void
     */
    public function set_widgets(){

        $this->widgets = [
            [
                'widget_id'        => 'book_dashboard',
                'widget_name'      => 'Book Categories',
                'callback'         => [$this->callback,'dashboard_ui'],
                'control_callback' => null,
                'callback_args'    => null,
                'context'          => 'side',
                'priority'         => 'high',
            ],
        ];

    }

    /**
     * Method registering dashboard widgets through wordpress function.
     *
     * @return void
     */
    public function register(){

        if(empty($this->widgets))
            return;
        
        foreach($this->widgets as $widget){
            wp_add_dashboard_widget( $widget['widget_id'],
                                     $widget['widget_name'],
                                     $widget['callback'], 
                                     isset($widget['control_callback']) ? $widget['control_callback'] : null,
                                     isset($widget['callback_args']) ? $widget['callback_args'] : null, 
                                     isset($widget['context']) ? $widget['context'] : 'normal',
                                     isset($widget['priority']) ? $widget['priority'] : 'core' );
        }

    }

}