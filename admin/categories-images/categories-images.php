<?php
if ( ! class_exists( 'AZTheme_Categories_Images' ) ) {
    class AZTheme_Categories_Images {
        public function __construct() {
            add_action( 'admin_enqueue_scripts', [ $this, 'load_media' ] );
            add_action( 'category_add_form_fields', [ $this, 'add_category_image' ] );
            add_action( 'created_category', [ $this, 'save_category_image' ] );
            add_action( 'category_edit_form_fields', [ $this, 'update_category_image' ] );
            add_action( 'edited_category', [ $this, 'updated_category_image' ] );
            add_action( 'admin_footer', [ $this, 'add_script' ] );
            add_filter( 'manage_edit-category_columns', [$this, 'categoryColumns'] );
            add_filter( 'manage_category_custom_column', [$this, 'categoryColumn'], 10, 3 );
        }

        /**
         * Thumbnail column added to category admin.
         *
         * @access public
         * @param mixed $columns
         * @return void
         */
        function categoryColumns( $columns ) {
            $new_columns = array();
            $new_columns['cb'] = $columns['cb'];
            $new_columns['thumb'] = __('Image', 'aztheme-toolkit');
    
            unset( $columns['cb'] );
    
            return array_merge( $new_columns, $columns );
        }

        /**
         * Thumbnail column value added to category admin.
         *
         * @access public
         * @param mixed $columns
         * @param mixed $column
         * @param mixed $id
         * @return void
         */
        function categoryColumn( $columns, $column, $id ) {
            if ( $column == 'thumb' ) {
                $image_id = get_term_meta ( $id, 'aztheme-category-image-id', true );
                $bg_url = AZTHEME_TOOLKIT_URL . '/admin/categories-images/category-thumbnail-placeholder.png';
                if ( wp_get_attachment_url($image_id) ) {
                    $bg_url = wp_get_attachment_url($image_id);
                }
                $columns = '<span><img style="width: 45px; height: 45px; object-fit: cover; border-radius: 5px;" src="' . esc_url($bg_url) . '" alt="' . __('Thumbnail', 'aztheme-toolkit') . '" class="wp-post-image" /></span>';
            }
            return $columns;
        }

        public function load_media() {
            if( isset( $_GET['taxonomy'] ) && $_GET['taxonomy'] == 'category' ) {
                wp_enqueue_media();
            }
        }

        function add_category_image( $taxonomy ) { ?>
            <div class="form-field term-group aztheme-category-image-field">
                <label for="aztheme-category-image-id"><?php _e('Image', 'aztheme-toolkit'); ?></label>
                <input type="hidden" class="aztheme-category-image-id" name="aztheme-category-image-id" value=""/>
                <div class="category-image-wrapper"></div>
                <p>
                    <input type="button" class="button button-secondary aztheme-category-add-image" id="<?php echo uniqid( 'aztheme-category-add-image-' ); ?>" name="aztheme-category-add-image" value="<?php _e( 'Add Image', 'aztheme-toolkit' ); ?>" />
                    <input type="button" class="button button-secondary aztheme-category-remove-image" name="aztheme-category-remove-image" value="<?php _e( 'Remove Image', 'aztheme-toolkit' ); ?>" />
                </p>
            </div>
            <?php
        }

        public function save_category_image( $term_id ) {
            if( isset( $_POST['aztheme-category-image-id'] ) && '' !== $_POST['aztheme-category-image-id'] ){
                $image_id = absint($_POST['aztheme-category-image-id']);
                add_term_meta( $image_id, 'aztheme-category-image-id', $image, true );
            }
        }

        public function update_category_image( $term ) {
            $image_id = get_term_meta($term->term_id, 'aztheme-category-image-id', true);
            ?>
            <tr class="form-field aztheme-category-image-field">
                <th scope="row">
                    <label for="aztheme-category-image-id"><?php _e( 'Image', 'aztheme-toolkit' ); ?></label>
                </th>
                <td>
                    <input type="hidden" class="aztheme-category-image-id" name="aztheme-category-image-id" value="<?php echo esc_attr($image_id); ?>"/>
                    <div class="category-image-wrapper">
                        <?php
                            if ( $image_id ) {
                                echo wp_get_attachment_image($image_id, 'thumbnail');
                            }
                        ?>
                    </div>
                    <p>
                        <input type="button" class="button button-secondary aztheme-category-add-image" id="<?php echo uniqid( 'aztheme-category-add-image-' ); ?>" name="aztheme-category-add-image" value="<?php _e( 'Add Image', 'aztheme-toolkit' ); ?>" />
                        <input type="button" class="button button-secondary aztheme-category-remove-image" name="aztheme-category-remove-image" value="<?php _e( 'Remove Image', 'aztheme-toolkit' ); ?>" />
                    </p>
                </td>
            </tr>
            <?php
        }

        public function updated_category_image ( $term_id ) {
            if( isset( $_POST['aztheme-category-image-id'] ) && '' !== $_POST['aztheme-category-image-id'] ){
                update_term_meta( $term_id, 'aztheme-category-image-id', absint($_POST['aztheme-category-image-id']) );
            } else {
                delete_term_meta( $term_id, 'aztheme-category-image-id' );
            }
        }

        public function add_script() {
            if( isset( $_GET['taxonomy'] ) && $_GET['taxonomy'] == 'category' ) {
            ?>
            <script>
                jQuery(document).ready( function($) {
                    function aztheme_media_upload(button_class) {
                        var _custom_media = true, _orig_send_attachment = wp.media.editor.send.attachment;
                        $('body').on('click', button_class, function(event) {
                            var button_id = '#' + $(this).attr('id');
                            var button = $(button_id);
                            _custom_media = true;
                            wp.media.editor.send.attachment = function(props, attachment){
                                if ( _custom_media ) {
                                    button.closest('.aztheme-category-image-field').find('.aztheme-category-image-id').val(attachment.id);
                                    button.closest('.aztheme-category-image-field').find('.category-image-wrapper').html('<img class="custom_media_image" src="'+attachment.sizes.thumbnail.url+'" />');
                                } else {
                                    return _orig_send_attachment.apply( button_id, [props, attachment] );
                                }
                            }
                            wp.media.editor.open();
                            return false;
                        });
                    }

                    aztheme_media_upload('.aztheme-category-add-image');

                    $('body').on( 'click', '.aztheme-category-remove-image', function() {
                        $(this).closest('.aztheme-category-image-field').find('.aztheme-category-image-id').val('');
                        $(this).closest('.aztheme-category-image-field').find('.category-image-wrapper').html('');
                    });

                    $(document).ajaxComplete(function(event, xhr, settings) {
                        var queryStringArr = settings.data.split('&');
                        if( $.inArray('action=add-tag', queryStringArr) !== -1 ) {
                            if ( xhr.readyState == '4' ) {
                                $('.category-image-wrapper').html('');
                            }
                        }
                    });
                });
            </script>
            <?php
            }
        }
    }

    $Categories_Images = new AZTheme_Categories_Images();
}
