<?php

/**
 * The file defines custom meta box.
 *
 * @since      1.0.0
 *
 * @package    WP_BOOK
 * @subpackage WP_BOOK/templates/base
 */

/**
 * This file define all the necessary code for defining custom meta box and save it.
 * 
 * @since      1.0.0
 * @package    WP_BOOK
 * @subpackage WP_BOOK/templates/base
 * @author     Vraj Rana vrcoder1998@gmail.com
 */

class CustomMetaboxController{

    /**
	 * Varriable for instantiate custom meta box.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array   $metaboxes  
	 */
    private $metaboxes = array();

    /**
     * Register method called by wp-loader class
     *
     * @return void
     */
    public function register(){
        $this->set_metabox();
        $this->add_metabox();
    }

    /**
     * Method for instantiate metaboxes array.
     *
     * @return void
     */
    public function set_metabox(){
        $this->metaboxes = [
            [
                'id'        => 'book_details',
                'title'     => 'Book Infromation',
                'callback'  => [$this, 'book_details_ui'],
                'screen'    => ['book'],
                'context'   => 'side',
                'priority'  => 'default',
                'args'      => []
            ]
        ];
    }

    /**
     * Adding meta box throug wordpress function
     *
     * @return void
     */
    public function add_metabox(){
        if( empty($this->metaboxes)){
            return;
        }
        foreach( $this->metaboxes as $metabox ){
            add_meta_box( $metabox['id'], $metabox['title'], $metabox['callback'], $metabox['screen'], $metabox['context'], $metabox['priority'], isset($metabox['args']) ? $metabox['args'] : null );
        }
    }

    /**
     * Callback for Metabox UI.
     *
     * @param Object $post
     * @return void
     */
    public function book_details_ui($post){
        wp_nonce_field( 'book_details', 'book_meta_data_nonce' );

        $data = get_post_meta($post->ID,'_book_details_key',true);

        $author        = isset($data['author']) ? $data['author'] : '';
        $price         = isset($data['price']) ? $data['price'] : '';
        $publisher     = isset($data['publisher']) ? $data['publisher'] : '';
        $publish_year  = isset($data['publish_year']) ? $data['publish_year'] : '';
        $edition       = isset($data['edition']) ? $data['edition'] : '';
        $url           = isset($data['url']) ? $data['url'] : '';
        ?>
        <form action="">
            <table>
                <tr>
                    <td align="left"><label for="book_detail_author">Author</label></td>
                    <td align="left"><input id="book_detail_author" name="book_detail_author" type="text" value="<?php echo esc_attr( $author ); ?>"></td>
                </tr>
                    <td align="left"><label for="book_detail_price">Price</label></td>
                    <td align="left"><input id="book_detail_price" name="book_detail_price" type="number" value="<?php echo esc_attr( $price );?>" min="1" max="100000"></td>
                <tr>
                    <td align="left"><label for="book_detail_publisher">Publisher</label></td>
                    <td align="left"><input id="book_detail_publisher" name="book_detail_publisher" type="text" value="<?php echo esc_attr($publisher);?>"></td>
                </tr>
                <tr>
                    <td align="left"><label for="book_detail_year">Publish Year</label></td>
                    <td align="left">
                        <select name="book_detail_year" id="book_detail_year">
                            <?php 
                                $years = range( 1900, strftime( "%Y", time() ) );
                                foreach($years as $key => $year){
                                    if( !empty($publish_year) ){
                                        ?> 
                                            <option selected><?php echo $year;?></option>     
                                        <?php
                                    }else{
                                        ?> <option><?php echo $year;?></option>     <?php
                                    }
                                }

                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="left"><label for="book_detail_edition">Edition</label></td>
                    <td align="left"><input id="book_detail_edition" name="book_detail_edition" type="number" value="<?php echo esc_attr( $edition )?>" max="20" min="1"></td>
                </tr>
                <tr>
                    <td align="left"><label for="book_detail_url">Url</label></td>
                    <td align="left"><input id="book_detail_url" name="book_detail_url" type="url" value="<?php echo esc_url( $url, ['http', 'https'] )?>"/></td>
                </tr>
            </table>            
        </form>
        <?php
    }

    /**
     * Method for saving information of meta box after sanitizing.
     *
     * @param [type] $post_id
     * @return void
     */
    function save_cutsom_meta_box($post_id){
        $nonce = $_POST['book_meta_data_nonce'];
        if( !isset( $_POST["book_meta_data_nonce"] ) || !wp_verify_nonce( $nonce, 'book_details' ) )
            return $post_id;

        if( !current_user_can( 'edit_post', $post_id ))
            return $post_id;

        if( defined("DOING_AUTOSAVE") && DOING_AUTOSAVE )
            return $post_id;
    
        $author = "";
        $url = "";
        $publisher = "";
        $price = 0;
        $publish_year = 0;
        $edition = 0;

        if( isset($_POST["book_detail_author"]) ){
            $author = sanitize_text_field( $_POST["book_detail_author"] );
        }
        //update_post_meta( $post_id, "meta-box-book-author-name", $meta_box_book_author_name);

        if( isset($_POST["book_detail_publisher"]) ){
            $publisher = sanitize_text_field( $_POST["book_detail_publisher"] );
        }
        //update_post_meta( $post_id, "meta-box-book-publisher", $meta_box_book_publisher);

        if( isset($_POST["book_detail_url"]) ){
            $url = sanitize_url( $_POST["book_detail_url"], ['http', 'https'] );
        }
        //update_post_meta( $post_id, "meta-box-book-url", $meta_box_book_url);

        $number = $_POST["book_detail_price"];
        if( isset($_POST["book_detail_price"]) && $number > 0 && $number<=100000 ){
            $price = $_POST["book_detail_price"];
        }
        //update_post_meta( $post_id, "meta-box-book-price", $meta_box_book_price);
        $year = $_POST["book_detail_year"];
        $current_year = strftime( "%Y", time() );
        if( isset($_POST["book_detail_year"]) && $year >= 1900 && $year <= $current_year ){
            $publish_year = $_POST["book_detail_year"];
        }
        //update_post_meta( $post_id, "meta-box-book-publish-year", $meta_box_book_publish_year);
        $edition_no = $_POST["book_detail_edition"];
        if( isset($_POST["book_detail_edition"]) && $edition_no > 0 && $edition_no < 21){
            $edition = $_POST["book_detail_edition"];
        }
        //update_post_meta( $post_id, "meta-box-book-edition", $meta_box_book_edition);

        $data = [
            'author'        => $author,
            'price'         => $price,
            'publisher'     => $publisher,
            'publish_year'  => $publish_year,
            'edition'       => $edition,
            'url'           => $url
        ];

        update_post_meta( $post_id, '_book_details_key', $data );
    }


}