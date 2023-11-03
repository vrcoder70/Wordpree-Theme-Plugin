<?php

/**
 * This file define all the necessary code for short codes
 * php version 7.4.10
 * 
 * @category Shortcodes
 * @package  Sunset
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com  
 */

namespace SUNSET_THEME\Inc;

use SUNSET_THEME\Inc\Traits\Singleton;
/**
 * Trait-Signleton For instantiate any class only once.
 * 
 * @category Shortcodes
 * @package  Sunset
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com
 */
class Shortcodes
{
    use Singleton;
    /**
     * Constructor of SUNSET_THEME
     * 
     * @return null
     */
    protected function __construct() 
    {
        $this->setupHooks();
    }

    /**
     * Used for after_setuo_theme hook for enabling some features.
     * 
     * @return null
     */
    protected function setupHooks() 
    {

        /**
         * Actions.
         */
        add_shortcode('tooltip', [ $this, 'sunsetTooltip' ]);
        add_shortcode('popover', [ $this, 'sunsetPopover' ]);
        add_shortcode('contact_form', [ $this, 'sunsetContactForm' ]);
    }

    /** 
     * SunsetTooltip define tooltip shortcode
     * [tooltip placement="top" title="This is title."] This is $content [/tooltip]
     *
     * @param $atts    
     * @param $content  
     * 
     * @return void  
     */
    public function sunsetTooltip($atts, $content = null)
    {
        //get the attributes.
        $atts = shortcode_atts( 
            [
                'placement' => 'top',
                'title'     => '',
            ], 
            $atts,
            'tooltip'
        );

        $title = ($atts['title'] == '' ? $content : $atts['title']);

        //return Html 
        return '<span class="sunset-tooltip" data-toggle="tooltip" data-placement="' . $atts['placement'] . '" title="' . $title . '">' . $content . '</span>';
    }

    /** 
     * SunsetPopover define popover shortcode
     * [popover placement="top" title="This is title." trigger="Click" content="This is popover content"] This is $content [/popover]
     *
     * @param $atts    
     * @param $content  
     * 
     * @return void  
     */
    public function sunsetPopover($atts, $content = null)
    {
        //get the attributes.
        $atts = shortcode_atts( 
            [
                'placement' => 'top',
                'title'     => '',
                'trigger'   => 'click',
                'content'   => '',
            ], 
            $atts,
            'popover'
        );

        //return Html 
        return '<span class="sunset-popover" data-toggle="popover" data-placement="'. $atts['placement'] .'" data-content="'. $atts['content'] .'" data-trigger="'. $atts['trigger'] .'" title="'. $atts['title'] .'">' . $content . '</span>';
    }

    /** 
     * SunsetPopover define contact_form shortcode
     * [contact_form]
     *
     * @param $atts    
     * @param $content  
     * 
     * @return void  
     */
    public function sunsetContactForm($atts, $content = null)
    {
        //get the attributes.
        $atts = shortcode_atts( 
            [], 
            $atts,
            'contact_form'
        );

        //return Html
        ob_start();
        get_template_part('inc/template/contact-form');
        return ob_get_clean();
    }

}

