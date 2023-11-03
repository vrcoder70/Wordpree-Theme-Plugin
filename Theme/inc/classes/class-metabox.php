<?php

/**
 * This file define all the necessary code for defining custom meta box and save it.
 * php version 7.4.10
 *
 * @category Metabox
 * @package  Sunset
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com  
 */

namespace SUNSET_THEME\Inc;

use SUNSET_THEME\Inc\Traits\Singleton;
/**
 * This file define all the necessary code for defining custom meta box and save it.
 * php version 7.4.10
 *
 * @category Metabox
 * @package  Sunset
 * @author   Vraj Rana <vrcoder1998@gmail.com>
 * @license  GNU General Public License v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link     www.github.com  
 */

class Metabox
{

    use Singleton;
    /**
     * Varriable for instantiate custom meta box.
     *
     * @since  1.0.0
     * @access private
     * @var    array   $metaboxes  :- It is used to save meta box meta information.
     */
    public $metaboxes = array();

    /**
     * Constructor of Metabox class
     * 
     * @return null
     */
    protected function __construct() 
    {
        $this->setMetabox();
        $this->setupHooks();
    }

    /**
     * Setup all the hooks used in this class. 
     * 
     * @return null
     */
    protected function setupHooks()
    {

        /**
         * Actions.
         */
        add_action('add_meta_boxes', [ $this, 'addMetabox' ]);
        add_action('save_post', [ $this, 'saveProject']);
        add_action('save_post', [ $this, 'saveInternship']);
        add_action('save_post', [ $this, 'saveJob']);

        if ($this->isContactFormActivated()) {
            add_action('save_post', [ $this, 'saveEmail']);
        }

    }

    /**
     * Check is Contact form activated.
     * 
     * @return boolean
     */ 
    public function isContactFormActivated()
    {
        $contact = get_option('activate_contact_form');
        if (@$contact == 1) { 
            return true;
        }
        return false;
    }

    /**
     * Method for instantiate metaboxes array.
     *
     * @return void
     */
    public function setMetabox()
    {
        $this->metaboxes = [
            [
                'id'        => 'project',
                'title'     => __('Project', 'vrcoder'),
                'callback'  => [$this, 'projectUi'],
                'screen'    => ['portfolio'],
                'context'   => 'normal',
                'priority'  => 'default',
                'args'      => []
            ],
            [
                'id'        => 'internship',
                'title'     => __('Internship', 'vrcoder'),
                'callback'  => [$this, 'internshipUi'],
                'screen'    => ['portfolio'],
                'context'   => 'normal',
                'priority'  => 'default',
                'args'      => []
            ],
            [
                'id'        => 'job',
                'title'     => __('Job', 'vrcoder'),
                'callback'  => [$this, 'jobUi'],
                'screen'    => ['portfolio'],
                'context'   => 'normal',
                'priority'  => 'default',
                'args'      => []
            ],
        ];

        if ($this->isContactFormActivated()) {
            $email = [
                'id'        => 'email',
                'title'     => __('Email', 'vrcoder'),
                'callback'  => [$this, 'emailUi'],
                'screen'    => ['sunset-contact'],
                'context'   => 'side',
                'priority'  => 'default',
                'args'      => []
            ];
            $this->metaboxes[] = $email;
        }
       
    }

    /**
     * Adding meta box throug wordpress function
     *
     * @return void
     */
    public function addMetabox()
    {
        if (empty($this->metaboxes)) {
            return;
        }

        foreach ($this->metaboxes as $metabox) {
            add_meta_box($metabox['id'], $metabox['title'], $metabox['callback'], $metabox['screen'], $metabox['context'], $metabox['priority'], isset($metabox['args']) ? $metabox['args'] : null);
        }
    }

    /**
     * Callback for Project Metabox Ui.
     *
     * @param $post post_id of post type.
     * 
     * @return null 
     */
    public function projectUi($post)
    {
        wp_nonce_field('project_details', 'project_meta_data_nonce');

        $data = get_post_meta($post->ID, '_project_key', true);
        

        $author  = isset($data['author']) ? $data['author'] : '';
        $project = isset($data['project']) ? $data['project'] : '';
        $info    = isset($data['info']) ? $data['info'] : '';
        $url     = isset($data['url']) ? $data['url'] : '';
        ?>
        
            <table>
                <tr>
                    <td align="left"><label for="project_author">Author Name</label></td>
                    <td align="left"><input id="project_author" name="project_author" type="text" value="<?php echo esc_attr($author); ?>"></td>
                </tr>

                <tr>
                    <td align="left"><label for="project_name">Project Title</label></td>
                    <td align="left"><input id="project_name" name="project_name" type="text" value="<?php echo esc_attr($project); ?> "></td>
                </tr>

                <tr>
                    <td align="left"><label for="project_info">Project Information</label></td>
                    <td align="left"><textarea id="project_info" name="project_info" rows="5" cols="24"><?php echo $info;?></textarea></td>
                </tr>

                <tr>
                    <td align="left"><label for="project_url">Url</label></td>
                    <td align="left"><input id="project_url" name="project_url" type="url" value="<?php echo esc_url($url, ['http', 'https'])?>"/></td>
                </tr>
            </table>            
        
        <?php
    }

    /**
     * Method for saving Project information of meta box after sanitizing.
     *
     * @param $post_id Post Id of that post.
     * 
     * @return null
     */
    function saveProject($post_id)
    {

        if (! isset($_POST["project_meta_data_nonce"]) || ! wp_verify_nonce($_POST['project_meta_data_nonce'], 'project_details') ) {
            return $post_id;
        }

        if (! current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        if (defined("DOING_AUTOSAVE") && DOING_AUTOSAVE ) {
            return $post_id;
        }

        $author = "";
        $project = "";
        $info = "";
        $url = "";

        if (isset($_POST["project_author"]) && !empty($_POST["project_author"])) {
            $author = sanitize_text_field($_POST["project_author"]);
        } else {
            return;
        }

        if (isset($_POST["project_name"]) && !empty($_POST["project_name"])) {
            $project = sanitize_text_field($_POST["project_name"]);
        } else {
            return;
        }
        
        if (isset($_POST["project_info"])) {
            $info = sanitize_textarea_field($_POST["project_info"]);
        } else {
            return;
        }

        if (isset($_POST["project_url"])) {
            $url = sanitize_url($_POST["project_url"], ['http', 'https']);
        } else {
            return;
        }

        $data = [
            'author'   => $author,
            'project'  => $project,
            'info'     => $info,
            'url'      => $url
        ];
        
        update_post_meta($post_id, '_project_key', $data);
    }


    /**
     * Callback for Intership Metabox Ui.
     *
     * @param $post post_id of post type.
     * 
     * @return null 
     */
    public function internshipUi($post)
    {
        wp_nonce_field('internship_details', 'internship_meta_data_nonce');

        $data = get_post_meta($post->ID, '_internship_key', true);

        $name       = isset($data['name']) ? $data['name'] : '';
        $institute  = isset($data['institute']) ? $data['institute'] : '';
        $info       = isset($data['info']) ? $data['info'] : '';
        $start_time = isset($data['start_time']) ? $data['start_time'] : '';
        $end_time   = isset($data['end_time']) ? $data['end_time'] : '';

        ?>
        
            <table>
                <tr>
                    <td align="left"><label for="internship_name">Internship Name</label></td>
                    <td align="left"><input id="internship_name" name="internship_name" type="text" value="<?php echo esc_attr($name); ?>"></td>
                </tr>

                <tr>
                    <td align="left"><label for="internship_institute">Institute</label></td>
                    <td align="left"><input id="internship_institute" name="internship_institute" type="text" value="<?php echo esc_attr($institute); ?>"></td>
                </tr>

                <tr>
                    <td align="left"><label for="internship_info">Internship Information</label></td>
                    <td align="left"><textarea id="internship_info" name="internship_info" rows="5" cols="24"><?php echo $info;?></textarea></td>
                </tr>

                <tr>
                    <td> 
                        <h4>Internship Duration</h4>
                    </td>
                </tr>
                <?php
                    $year  = (substr($start_time, 0, 4));
                    $month = (substr($start_time, 4, 2));
                    $day   = (substr($start_time, 6, 2)); 
                ?>
                <tr>
                    <td align="left"><label for="internship_start_time">Strat Time</label></td>
                    <td align="left"><input id="internship_start_time" name="internship_start_time" type="date" value="<?php echo $year .'-' . $month . '-' . $day; ?>"></td>
                </tr>
                <?php 
                    $year  = (substr($end_time, 0, 4));
                    $month = (substr($end_time, 4, 2));
                    $day   = (substr($end_time, 6, 2));
                ?>
                <tr>
                    <td align="left"><label for="internship_end_time">End Time</label></td>
                    <td align="left"><input id="internship_end_time" name="internship_end_time" type="date" value="<?php echo $year .'-' . $month . '-' . $day; ?>"></td>
                </tr>
            </table>            
        
        <?php
    }

    /**
     * Method for saving Internship information of meta box after sanitizing.
     *
     * @param $post_id Post Id of that post.
     * 
     * @return null
     */
    public function saveInternship($post_id)
    {
        if (! isset($_POST["internship_meta_data_nonce"]) || ! wp_verify_nonce($_POST['internship_meta_data_nonce'], 'internship_details')) {
            return $post_id;
        }

        if (! current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        if (defined("DOING_AUTOSAVE") && DOING_AUTOSAVE) {
            return $post_id;
        }

        $name       =  '';
        $institute  =  '';
        $info       =  '';
        $start_time =  '';
        $end_time   =  '';

        if (isset($_POST["internship_name"])) {
            $name = sanitize_text_field($_POST["internship_name"]);
        }

        if (isset($_POST["internship_institute"])) {
            $institute = sanitize_text_field($_POST["internship_institute"]);
        }

        if (isset($_POST["internship_info"])) {
            $info = sanitize_textarea_field($_POST["internship_info"]);
        }
        
        if (isset($_POST["internship_start_time"])) {
            $start_time = preg_replace("([^0-9/])", "", $_POST["internship_start_time"]);
        }

        if (isset($_POST["internship_end_time"])) {
            $end_time = preg_replace("([^0-9/])", "", $_POST["internship_end_time"]);
        }
        
        $data = [
            'name'       => $name,
            'institute'  => $institute,
            'info'       => $info,
            'start_time' => $start_time,
            'end_time'   => $end_time
        ];

        update_post_meta($post_id, '_internship_key', $data);
    }

    /**
     * Callback for Job Metabox Ui.
     *
     * @param $post post_id of post type.
     * 
     * @return null 
     */
    public function jobUi($post)
    {
        wp_nonce_field('job_details', 'job_meta_data_nonce');

        $data = get_post_meta($post->ID, '_job_key', true);

        $role       = isset($data['role']) ? $data['role'] : '';
        $institute  = isset($data['institute']) ? $data['institute'] : '';
        $info       = isset($data['info']) ? $data['info'] : '';
        $start_time = isset($data['start_time']) ? $data['start_time'] : '';
        $end_time   = isset($data['end_time']) ? $data['end_time'] : '';
        ?>
        
            <table>
                <tr>
                    <td align="left"><label for="job_role">Job Role</label></td>
                    <td align="left"><input id="job_role" name="job_role" type="text" value="<?php echo esc_attr($role); ?>"></td>
                </tr>

                <tr>
                    <td align="left"><label for="job_institute">Institute</label></td>
                    <td align="left"><input id="job_institute" name="job_institute" type="text" value="<?php echo esc_attr($institute); ?>"></td>
                </tr>

                <tr>
                    <td align="left"><label for="job_info">Job Information</label></td>
                    <td align="left"><textarea id="job_info" name="job_info" rows="5" cols="24"><?php echo $info;?></textarea></td>
                </tr>

                <tr>
                    <td> 
                        <h4>Job Duration</h4>
                    </td>
                </tr>
                <?php
                    $year  = (substr($start_time, 0, 4));
                    $month = (substr($start_time, 4, 2));
                    $day   = (substr($start_time, 6, 2)); 
                ?>
                <tr>
                    <td align="left"><label for="job_start_time">Strat Time</label></td>
                    <td align="left"><input id="job_start_time" name="job_start_time" type="date" value="<?php echo $year .'-' . $month . '-' . $day; ?>"></td>
                </tr>
                <?php
                    $year  = (substr($end_time, 0, 4));
                    $month = (substr($end_time, 4, 2));
                    $day   = (substr($end_time, 6, 2)); 
                ?>
                <tr>
                    <td align="left"><label for="job_end_time">End Time</label></td>
                    <td align="left"><input id="job_end_time" name="job_end_time" type="date" value="<?php echo $year .'-' . $month . '-' . $day; ?>"></td>
                </tr>
            </table>            
        
        <?php
    }

    /**
     * Method for saving Job information of meta box after sanitizing.
     *
     * @param $post_id Post Id of that post.
     * 
     * @return null
     */
    public function saveJob($post_id)
    {
        if (! isset($_POST["job_meta_data_nonce"]) || ! wp_verify_nonce($_POST['job_meta_data_nonce'], 'job_details') ) {
            return $post_id;
        }

        if (! current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        if (defined("DOING_AUTOSAVE") && DOING_AUTOSAVE) {
            return $post_id;
        }
        $role       =  '';
        $institute  =  '';
        $info       =  '';
        $start_time =  '';
        $end_time   =  '';

        if (isset($_POST["job_role"]) ) {
            $role = sanitize_text_field($_POST["job_role"]);
        }

        if (isset($_POST["job_institute"])) {
            $institute = sanitize_text_field($_POST["job_institute"]);
        }

        if (isset($_POST["job_info"])) {
            $info = sanitize_textarea_field($_POST["job_info"]);
        }
        
        if (isset($_POST["job_start_time"])) {
            $start_time = preg_replace("([^0-9/])", "", $_POST["job_start_time"]);
        
        }

        if (isset($_POST["job_end_time"])) {
            $end_time = preg_replace("([^0-9/])", "", $_POST["job_end_time"]);
        }
        
        $data = [
            'role'       => $role,
            'institute'  => $institute,
            'info'       => $info,
            'start_time' => $start_time,
            'end_time'   => $end_time
        ];

        update_post_meta($post_id, '_job_key', $data);
    }

    /**
     * Callback for Email Metabox Ui.
     *
     * @param $post post_id of post type.
     * 
     * @return null 
     */
    public function emailUi($post)
    {
        wp_nonce_field('contact_email', 'email_meta_data_nonce');

        $email = get_post_meta($post->ID, '_email_key', true);
        
        ?>
        
            <table>
                <tr>
                    <td align="left"><label for="contact_email">Email:</label></td>
                    <td align="left"><input id="contact_email" name="contact_email" type="email" value="<?php echo esc_attr($email); ?>"></td>
                </tr>
            </table>            
        
        <?php
    }

    /**
     * Method for saving Email information of meta box after sanitizing.
     *
     * @param $post_id Post Id of that post.
     * 
     * @return null
     */
    function saveEmail($post_id)
    {

        if (! isset($_POST["email_meta_data_nonce"])) {
            return $post_id;
        }

        if (! wp_verify_nonce($_POST['email_meta_data_nonce'], 'saveEmail') ) {

        }

        if (! current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        if (defined("DOING_AUTOSAVE") && DOING_AUTOSAVE ) {
            return $post_id;
        }

        $email = "";

        if (isset($_POST["contact_email"]) && !empty($_POST["contact_email"])) {
            $email = sanitize_text_field($_POST["contact_email"]);
        }

        update_post_meta($post_id, '_email_key', $email);
    }

}
