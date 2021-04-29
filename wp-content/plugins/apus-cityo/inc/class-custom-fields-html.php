<?php

if (!defined('ABSPATH')) {
    die;
}

// main plugin class
class ApusCityo_CustomFieldHTML {
    
    public static $packages;

    public static function init() {
        add_filter('apuscityo_custom_field_text_html', array(__CLASS__, 'field_text_html_callback'), 1, 3);
        add_filter('apuscityo_custom_field_date_html', array(__CLASS__, 'field_date_html_callback'), 1, 3);
        add_filter('apuscityo_custom_field_opts_html', array(__CLASS__, 'field_opts_html_callback'), 1, 3);
        add_filter('apuscityo_custom_field_heading_html', array(__CLASS__, 'field_heading_html_callback'), 1, 3);
        add_filter('apuscityo_custom_field_file_html', array(__CLASS__, 'field_file_html_callback'), 1, 3);

        // available fields
        add_filter('apuscityo_custom_field_available_simple_html', array(__CLASS__, 'field_available_simple_callback'), 1, 3);
        add_filter('apuscityo_custom_field_available_tax_html', array(__CLASS__, 'field_available_tax_callback'), 1, 3);
        add_filter('apuscityo_custom_field_available_file_html', array(__CLASS__, 'field_available_file_callback'), 1, 3);
        add_filter('apuscityo_custom_field_available_files_html', array(__CLASS__, 'field_available_files_callback'), 1, 3);
        add_filter('apuscityo_custom_field_available_job_description_html', array(__CLASS__, 'field_available_job_description_callback'), 1, 3);
        add_filter('apuscityo_custom_field_available_job_products_html', array(__CLASS__, 'field_available_job_products_callback'), 1, 3);
        add_filter('apuscityo_custom_field_available_select_option_html', array(__CLASS__, 'field_available_job_select_option_callback'), 1, 3);
        // actions
        add_filter('apuscityo_custom_field_actions_html', array(__CLASS__, 'field_actions_html_callback'), 1, 4);
    }

    public static function get_packages() {
        if ( empty(self::$packages) ) {
            $query_args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page'   => -1,
                'order'            => 'asc',
                'orderby'          => 'menu_order',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_type',
                        'field'    => 'slug',
                        'terms'    => array('listing_package'),
                    ),
                ),
            );
            $packages = get_posts( $query_args );
            $return = array();
            foreach ($packages as $package) {
                $return[$package->ID] = $package->post_title;
            }
            self::$packages = $return;
        }
        return self::$packages;
    }
    
    public static function field_text_html_callback($type, $field_counter, $field_data) {
        ob_start();
        $rand = $field_counter;

        $label_val = isset($field_data['label']) ? $field_data['label'] : 'Custom Field';
        $key_val = isset($field_data['key']) ? $field_data['key'] : 'custom-'.$type.'-'.$field_counter;
        $placeholder_val = isset($field_data['placeholder']) ? $field_data['placeholder'] : '';
        $description_val = isset($field_data['description']) ? $field_data['description'] : '';

        $required_val = isset($field_data['required']) ? $field_data['required'] : '';
        $show_in_submit_form_val = isset($field_data['show_in_submit_form']) ? $field_data['show_in_submit_form'] : 'yes';
        $show_in_admin_edit_val = isset($field_data['show_in_admin_edit']) ? $field_data['show_in_admin_edit'] : 'yes';
        

        $prefix = 'apuscityo-custom-fields-'.$type;
        ?>
        <div class="apuscityo-custom-field-container apuscityo-custom-field-<?php echo esc_attr($type); ?>-container">
            <?php self::header_html($type, $rand, $label_val); ?>

            <div class="field-data form-group-wrapper" id="<?php echo esc_attr($type); ?>-field-wraper<?php echo esc_html($rand); ?>" style="display:none;">
                <input type="hidden" name="apuscityo-custom-fields-type[]" value="<?php echo esc_attr($type); ?>" />
                <input type="hidden" name="apuscityo-custom-fields-id[]" value="<?php echo esc_html($field_counter); ?>" />

                <?php
                    self::text( $prefix.'[label][]', esc_html__('Label', 'apuscityo-types'), $label_val, '', 'apuscityo-custom-field-label');
                    self::text( $prefix.'[key][]', esc_html__('Key', 'apuscityo-types'), $key_val, '', 'apuscityo-custom-field-key');
                    self::text( $prefix.'[placeholder][]', esc_html__('Placeholder', 'apuscityo-types'), $placeholder_val);
                    self::text( $prefix.'[description][]', esc_html__('Description', 'apuscityo-types'), $description_val);
                    self::checkbox( $prefix.'[required][]', esc_html__('Required', 'apuscityo-types'), $required_val);
                    self::checkbox( $prefix.'[show_in_submit_form][]', esc_html__('Show in submit form', 'apuscityo-types'), $show_in_submit_form_val);
                    self::checkbox( $prefix.'[show_in_admin_edit][]', esc_html__('Show in admin edit page', 'apuscityo-types'), $show_in_admin_edit_val);

                    // packages
                    $packages = self::get_packages();
                    if ( $packages ) {
                        $show_in_package = isset($field_data['show_in_package']) ? $field_data['show_in_package'] : '';
                        $package_display = isset($field_data['package_display']) ? $field_data['package_display'] : '';
                        self::checkbox( $prefix.'[show_in_package][]', esc_html__('Enable package visibility', 'apuscityo-types'), $show_in_package, false, true, 'show_in_package');
                        self::select( $prefix.'[package_display]['.$field_counter.'][]', $packages, esc_html__('Packages', 'apuscityo-types'), $package_display, esc_html__('Choose Packages to show this field insubmit form.', 'apuscityo-types'), true, true, 'show_if_show_in_package');
                    }
                    // hook
                    $hook_display = isset($field_data['hook_display']) ? $field_data['hook_display'] : '';
                    $opts = apuscityo_display_hooks();
                    self::select( $prefix.'[hook_display][]', $opts, esc_html__('Position Display', 'apuscityo-types'), $hook_display, '', false, true);

                    do_action('apuscityo_custom_field_text_html_callback');
                ?>

            </div>
        </div>
        <?php
        $html = ob_get_clean();

        return $html;
    }

    public static function field_date_html_callback($type, $field_counter, $field_data) {
        ob_start();
        $rand = $field_counter;

        $label_val = isset($field_data['label']) ? $field_data['label'] : 'Custom Field';
        $key_val = isset($field_data['key']) ? $field_data['key'] : 'custom-'.$type.'-'.$field_counter;
        $placeholder_val = isset($field_data['placeholder']) ? $field_data['placeholder'] : '';
        $description_val = isset($field_data['description']) ? $field_data['description'] : '';
        $format = isset($field_data['format']) ? $field_data['format'] : '';

        $required_val = isset($field_data['required']) ? $field_data['required'] : '';
        $show_in_submit_form_val = isset($field_data['show_in_submit_form']) ? $field_data['show_in_submit_form'] : 'yes';
        $show_in_admin_edit_val = isset($field_data['show_in_admin_edit']) ? $field_data['show_in_admin_edit'] : 'yes';

        $prefix = 'apuscityo-custom-fields-'.$type;
        ?>
        <div class="apuscityo-custom-field-container apuscityo-custom-field-<?php echo esc_attr($type); ?>-container">
            <?php self::header_html($type, $rand, $label_val); ?>

            <div class="field-data form-group-wrapper" id="<?php echo esc_attr($type); ?>-field-wraper<?php echo esc_html($rand); ?>" style="display:none;">
                <input type="hidden" name="apuscityo-custom-fields-type[]" value="<?php echo esc_attr($type); ?>" />
                <input type="hidden" name="apuscityo-custom-fields-id[]" value="<?php echo esc_html($field_counter); ?>" />

                <?php
                self::text( $prefix.'[label][]', esc_html__('Label', 'apuscityo-types'), $label_val, '', 'apuscityo-custom-field-label');
                self::text( $prefix.'[key][]', esc_html__('Key', 'apuscityo-types'), $key_val, '', 'apuscityo-custom-field-key');
                self::text( $prefix.'[placeholder][]', esc_html__('Placeholder', 'apuscityo-types'), $placeholder_val);
                self::text( $prefix.'[description][]', esc_html__('Description', 'apuscityo-types'), $description_val);

                $opts = array(
                    'date' => esc_html__('Date', 'apuscityo-types'),
                    'datetime' => esc_html__('Datetime', 'apuscityo-types'),
                );
                self::select( $prefix.'[format][]', $opts, esc_html__('Format', 'apuscityo-types'), $format);
                self::checkbox( $prefix.'[required][]', esc_html__('Required', 'apuscityo-types'), $required_val);
                self::checkbox( $prefix.'[show_in_submit_form][]', esc_html__('Show in submit form', 'apuscityo-types'), $show_in_submit_form_val);
                self::checkbox( $prefix.'[show_in_admin_edit][]', esc_html__('Show in admin edit page', 'apuscityo-types'), $show_in_admin_edit_val);

                // packages
                $packages = self::get_packages();
                if ( $packages ) {
                    $show_in_package = isset($field_data['show_in_package']) ? $field_data['show_in_package'] : '';
                    $package_display = isset($field_data['package_display']) ? $field_data['package_display'] : '';
                    self::checkbox( $prefix.'[show_in_package][]', esc_html__('Enable package visibility', 'apuscityo-types'), $show_in_package, false, true, 'show_in_package');
                    self::select( $prefix.'[package_display]['.$field_counter.'][]', $packages, esc_html__('Packages', 'apuscityo-types'), $package_display, esc_html__('Choose Packages to show this field insubmit form.', 'apuscityo-types'), true, true, 'show_if_show_in_package');
                }

                // hook
                $hook_display = isset($field_data['hook_display']) ? $field_data['hook_display'] : '';
                $opts = apuscityo_display_hooks();
                self::select( $prefix.'[hook_display][]', $opts, esc_html__('Position Display', 'apuscityo-types'), $hook_display, '', false, true);

                do_action('apuscityo_custom_field_date_html_callback');
                ?>

            </div>
        </div>
        <?php
        $html = ob_get_clean();

        return $html;
    }

    public static function field_opts_html_callback($type, $field_counter, $field_data) {
        ob_start();
        $rand = $field_counter;

        $label_val = isset($field_data['label']) ? $field_data['label'] : 'Custom Field';
        $key_val = isset($field_data['key']) ? $field_data['key'] : 'custom-'.$type.'-'.$field_counter;
        $placeholder_val = isset($field_data['placeholder']) ? $field_data['placeholder'] : '';
        $description_val = isset($field_data['description']) ? $field_data['description'] : '';
        $text_field_options = isset($field_data['options']) ? $field_data['options'] : '';

        $required_val = isset($field_data['required']) ? $field_data['required'] : '';
        $show_in_submit_form_val = isset($field_data['show_in_submit_form']) ? $field_data['show_in_submit_form'] : 'yes';
        $show_in_admin_edit_val = isset($field_data['show_in_admin_edit']) ? $field_data['show_in_admin_edit'] : 'yes';

        $prefix = 'apuscityo-custom-fields-'.$type;
        ?>
        <div class="apuscityo-custom-field-container apuscityo-custom-field-<?php echo esc_attr($type); ?>-container">
            <?php self::header_html($type, $rand, $label_val); ?>

            <div class="field-data form-group-wrapper" id="<?php echo esc_attr($type); ?>-field-wraper<?php echo esc_html($rand); ?>" style="display:none;">
                <input type="hidden" name="apuscityo-custom-fields-type[]" value="<?php echo esc_attr($type); ?>" />
                <input type="hidden" name="apuscityo-custom-fields-id[]" value="<?php echo esc_html($field_counter); ?>" />

                <?php
                self::text( $prefix.'[label][]', esc_html__('Label', 'apuscityo-types'), $label_val, '', 'apuscityo-custom-field-label');
                self::text( $prefix.'[key][]', esc_html__('Key', 'apuscityo-types'), $key_val, '', 'apuscityo-custom-field-key');
                self::text( $prefix.'[placeholder][]', esc_html__('Placeholder', 'apuscityo-types'), $placeholder_val);
                self::text( $prefix.'[description][]', esc_html__('Description', 'apuscityo-types'), $description_val);
                self::textarea( $prefix.'[options][]', esc_html__('Options', 'apuscityo-types'), $text_field_options, esc_html__('Add each option in a new line.', 'apuscityo-types'));
                self::checkbox( $prefix.'[required][]', esc_html__('Required', 'apuscityo-types'), $required_val);
                self::checkbox( $prefix.'[show_in_submit_form][]', esc_html__('Show in submit form', 'apuscityo-types'), $show_in_submit_form_val);
                self::checkbox( $prefix.'[show_in_admin_edit][]', esc_html__('Show in admin edit page', 'apuscityo-types'), $show_in_admin_edit_val);

                // packages
                $packages = self::get_packages();
                if ( $packages ) {
                    $show_in_package = isset($field_data['show_in_package']) ? $field_data['show_in_package'] : '';
                    $package_display = isset($field_data['package_display']) ? $field_data['package_display'] : '';
                    self::checkbox( $prefix.'[show_in_package][]', esc_html__('Enable package visibility', 'apuscityo-types'), $show_in_package, false, true, 'show_in_package');
                    self::select( $prefix.'[package_display]['.$field_counter.'][]', $packages, esc_html__('Packages', 'apuscityo-types'), $package_display, esc_html__('Choose Packages to show this field insubmit form.', 'apuscityo-types'), true, true, 'show_if_show_in_package');
                }

                // hook
                $hook_display = isset($field_data['hook_display']) ? $field_data['hook_display'] : '';
                $opts = apuscityo_display_hooks();
                self::select( $prefix.'[hook_display][]', $opts, esc_html__('Position Display', 'apuscityo-types'), $hook_display, '', false, true);

                do_action('apuscityo_custom_field_opts_html_callback');
                ?>

            </div>
        </div>
        <?php
        $html = ob_get_clean();

        return $html;
    }

    public static function field_heading_html_callback($type, $field_counter, $field_data) {
        ob_start();
        $rand = $field_counter;

        $label_val = isset($field_data['label']) ? $field_data['label'] : 'Custom Field';
        $key_val = isset($field_data['key']) ? $field_data['key'] : 'custom-'.$type.'-'.$field_counter;

        $heading_field_label = isset($field_data['label']) ? $field_data['label'] : '';
        $text_field_icon = isset($field_data['icon']) ? $field_data['icon'] : '';

        $prefix = 'apuscityo-custom-fields-'.$type;
        ?>
        <div class="apuscityo-custom-field-container apuscityo-custom-field-heading-container">
            <?php self::header_html($type, $rand, $label_val); ?>
            
            <div class="field-data form-group-wrapper" id="heading-field-wraper<?php echo esc_html($rand); ?>" style="display:none;">
                <input type="hidden" name="apuscityo-custom-fields-type[]" value="heading" />
                <input type="hidden" name="apuscityo-custom-fields-id[]" value="<?php echo esc_html($field_counter); ?>" />
                
                <?php
                self::text( $prefix.'[label][]', esc_html__('Label', 'apuscityo-types'), $label_val, '', 'apuscityo-custom-field-label');
                self::text( $prefix.'[key][]', esc_html__('Key', 'apuscityo-types'), $key_val, '', 'apuscityo-custom-field-key');
                ?>

                <div class="form-group">
                    <label>
                        <?php echo esc_html__('Icon', 'apuscityo-types'); ?>:
                    </label>
                    <div class="input-field">
                        <?php
                        $icon_id = rand(1000000, 99999999);

                        echo apuscityo_icon_picker($text_field_icon, $icon_id, $prefix.'[icon][]');
                        ?>
                    </div>
                </div>


                <?php
                    $number_column_val = isset($field_data['number_columns']) ? $field_data['number_columns'] : '1';
                    $columns = array(
                        '1' => __('1 Column', 'apus-cityo'),
                        '2' => __('2 Column', 'apus-cityo'),
                        '3' => __('3 Column', 'apus-cityo'),
                        '4' => __('4 Column', 'apus-cityo'),
                    );
                    self::select( $prefix.'[number_columns][]', $columns, esc_html__('Columns Inner', 'apuscityo-types'), $number_column_val, '', false);

                    // packages
                    $packages = self::get_packages();
                    if ( $packages ) {
                        $show_in_package = isset($field_data['show_in_package']) ? $field_data['show_in_package'] : '';
                        $package_display = isset($field_data['package_display']) ? $field_data['package_display'] : '';
                        self::checkbox( $prefix.'[show_in_package][]', esc_html__('Enable package visibility', 'apuscityo-types'), $show_in_package, false, true, 'show_in_package');
                        self::select( $prefix.'[package_display]['.$field_counter.'][]', $packages, esc_html__('Packages', 'apuscityo-types'), $package_display, esc_html__('Choose Packages to show this field insubmit form.', 'apuscityo-types'), true, true, 'show_if_show_in_package');
                    }

                    do_action('apuscityo_custom_field_heading_html_callback');
                ?>

            </div>
        </div>
        <?php
        $html = ob_get_clean();

        return $html;
    }

    public static function field_file_html_callback($type, $field_counter, $field_data) {
        ob_start();
        $rand = $field_counter;

        $label_val = isset($field_data['label']) ? $field_data['label'] : 'Custom Field';
        $key_val = isset($field_data['key']) ? $field_data['key'] : 'custom-'.$type.'-'.$field_counter;
        $placeholder_val = isset($field_data['placeholder']) ? $field_data['placeholder'] : '';
        $description_val = isset($field_data['description']) ? $field_data['description'] : '';

        $text_field_multiple_files = isset($field_data['multiple_files']) ? $field_data['multiple_files'] : '';
        $required_val = isset($field_data['required']) ? $field_data['required'] : '';
        $show_in_submit_form_val = isset($field_data['show_in_submit_form']) ? $field_data['show_in_submit_form'] : 'yes';
        $show_in_admin_edit_val = isset($field_data['show_in_admin_edit']) ? $field_data['show_in_admin_edit'] : 'yes';

        $text_field_allow_types = isset($field_data['allow_types']) ? $field_data['allow_types'] : '';

        $prefix = 'apuscityo-custom-fields-'.$type;
        ?>
        <div class="apuscityo-custom-field-container apuscityo-custom-field-<?php echo esc_attr($type); ?>-container">
            <?php self::header_html($type, $rand, $label_val); ?>

            <div class="field-data form-group-wrapper" id="<?php echo esc_attr($type); ?>-field-wraper<?php echo esc_html($rand); ?>" style="display:none;">
                <input type="hidden" name="apuscityo-custom-fields-type[]" value="<?php echo esc_attr($type); ?>" />
                <input type="hidden" name="apuscityo-custom-fields-id[]" value="<?php echo esc_html($field_counter); ?>" />

                <?php
                self::text( $prefix.'[label][]', esc_html__('Label', 'apuscityo-types'), $label_val, '', 'apuscityo-custom-field-label');
                self::text( $prefix.'[key][]', esc_html__('Key', 'apuscityo-types'), $key_val, '', 'apuscityo-custom-field-key');
                self::text( $prefix.'[placeholder][]', esc_html__('Placeholder', 'apuscityo-types'), $placeholder_val);
                self::text( $prefix.'[description][]', esc_html__('Description', 'apuscityo-types'), $description_val);

                $mime_types = get_allowed_mime_types();
                self::select( $prefix.'[allow_types]['.$field_counter.'][]', $mime_types, esc_html__('Allowed file types', 'apuscityo-types'), $text_field_allow_types, '', true);

                self::checkbox( $prefix.'[multiple_files][]', esc_html__('Multiple files', 'apuscityo-types'), $text_field_multiple_files);
                self::checkbox( $prefix.'[required][]', esc_html__('Required', 'apuscityo-types'), $required_val);
                self::checkbox( $prefix.'[show_in_submit_form][]', esc_html__('Show in submit form', 'apuscityo-types'), $show_in_submit_form_val);
                self::checkbox( $prefix.'[show_in_admin_edit][]', esc_html__('Show in admin edit page', 'apuscityo-types'), $show_in_admin_edit_val);

                // packages
                $packages = self::get_packages();
                if ( $packages ) {
                    $show_in_package = isset($field_data['show_in_package']) ? $field_data['show_in_package'] : '';
                    $package_display = isset($field_data['package_display']) ? $field_data['package_display'] : '';
                    self::checkbox( $prefix.'[show_in_package][]', esc_html__('Enable package visibility', 'apuscityo-types'), $show_in_package, false, true, 'show_in_package');
                    self::select( $prefix.'[package_display]['.$field_counter.'][]', $packages, esc_html__('Packages', 'apuscityo-types'), $package_display, esc_html__('Choose Packages to show this field insubmit form.', 'apuscityo-types'), true, true, 'show_if_show_in_package');
                }

                // hook
                $hook_display = isset($field_data['hook_display']) ? $field_data['hook_display'] : '';
                $opts = apuscityo_display_hooks();
                self::select( $prefix.'[hook_display][]', $opts, esc_html__('Position Display', 'apuscityo-types'), $hook_display, '', false, true);

                do_action('apuscityo_custom_field_file_html_callback');
                ?>
                
            </div>
        </div>
        <?php
        $html = ob_get_clean();

        return $html;
    }

    public static function field_available_simple_callback($type, $field_counter, $field_data) {
        ob_start();
        $rand = $field_counter;

        $label_val = isset($field_data['label']) ? $field_data['label'] : 'Available Field';
        $key_val = $type;
        $placeholder_val = isset($field_data['placeholder']) ? $field_data['placeholder'] : '';
        $description_val = isset($field_data['description']) ? $field_data['description'] : '';

        $required_val = isset($field_data['required']) ? $field_data['required'] : '';
        $show_in_submit_form_val = isset($field_data['show_in_submit_form']) ? $field_data['show_in_submit_form'] : 'yes';
        $show_in_admin_edit_val = isset($field_data['show_in_admin_edit']) ? $field_data['show_in_admin_edit'] : 'yes';

        $disable_check_val = isset($field_data['disable_check']) ? $field_data['disable_check'] : false;

        $prefix = 'apuscityo-custom-fields-'.$type;
        ?>
        <div class="apuscityo-custom-field-container apuscityo-custom-field-<?php echo esc_attr($type); ?>-container">
            <?php self::header_html($type, $rand, $label_val); ?>
            <?php self::hidden( $prefix.'[key][]', $key_val, 'apuscityo-custom-field-key'); ?>
            <div class="field-data form-group-wrapper" id="<?php echo esc_attr($type); ?>-field-wraper<?php echo esc_html($rand); ?>" style="display:none;">
                <input type="hidden" name="apuscityo-custom-fields-type[]" value="<?php echo esc_attr($type); ?>" />
                <input type="hidden" name="apuscityo-custom-fields-id[]" value="<?php echo esc_html($field_counter); ?>" />
                
                <?php
                self::text( $prefix.'[label][]', esc_html__('Label', 'apuscityo-types'), $label_val, '', 'apuscityo-custom-field-label');
                self::text( $prefix.'[placeholder][]', esc_html__('Placeholder', 'apuscityo-types'), $placeholder_val);
                self::text( $prefix.'[description][]', esc_html__('Description', 'apuscityo-types'), $description_val);
                self::checkbox( $prefix.'[required][]', esc_html__('Required', 'apuscityo-types'), $required_val, $disable_check_val);
                self::checkbox( $prefix.'[show_in_submit_form][]', esc_html__('Show in submit form', 'apuscityo-types'), $show_in_submit_form_val, $disable_check_val);
                self::checkbox( $prefix.'[show_in_admin_edit][]', esc_html__('Show in admin edit page', 'apuscityo-types'), $show_in_admin_edit_val, $disable_check_val);

                // packages
                $packages = self::get_packages();
                if ( $packages ) {
                    $show_in_package = isset($field_data['show_in_package']) ? $field_data['show_in_package'] : '';
                    $package_display = isset($field_data['package_display']) ? $field_data['package_display'] : '';
                    self::checkbox( $prefix.'[show_in_package][]', esc_html__('Enable package visibility', 'apuscityo-types'), $show_in_package, false, true, 'show_in_package');
                    self::select( $prefix.'[package_display]['.$field_counter.'][]', $packages, esc_html__('Packages', 'apuscityo-types'), $package_display, esc_html__('Choose Packages to show this field insubmit form.', 'apuscityo-types'), true, true, 'show_if_show_in_package');
                }

                do_action('apuscityo_custom_field_available_simple_callback');
                ?>

            </div>
        </div>
        <?php
        $html = ob_get_clean();

        return $html;
    }

    public static function field_available_tax_callback($type, $field_counter, $field_data) {
        ob_start();
        $rand = $field_counter;

        $label_val = isset($field_data['label']) ? $field_data['label'] : 'Custom Field';
        $key_val = $type;
        $placeholder_val = isset($field_data['placeholder']) ? $field_data['placeholder'] : '';
        $description_val = isset($field_data['description']) ? $field_data['description'] : '';
        $text_field_select_type = isset($field_data['select_type']) ? $field_data['select_type'] : 'term-multiselect';

        $required_val = isset($field_data['required']) ? $field_data['required'] : '';
        $show_in_submit_form_val = isset($field_data['show_in_submit_form']) ? $field_data['show_in_submit_form'] : 'yes';
        $show_in_admin_edit_val = isset($field_data['show_in_admin_edit']) ? $field_data['show_in_admin_edit'] : 'yes';

        $disable_check_val = isset($field_data['disable_check']) ? $field_data['disable_check'] : false;

        $prefix = 'apuscityo-custom-fields-'.$type;
        ?>
        <div class="apuscityo-custom-field-container apuscityo-custom-field-<?php echo esc_attr($type); ?>-container">
            <?php self::header_html($type, $rand, $label_val); ?>
            <?php self::hidden( $prefix.'[key][]', $key_val, 'apuscityo-custom-field-key'); ?>
            <div class="field-data form-group-wrapper" id="<?php echo esc_attr($type); ?>-field-wraper<?php echo esc_html($rand); ?>" style="display:none;">
                <input type="hidden" name="apuscityo-custom-fields-type[]" value="<?php echo esc_attr($type); ?>" />
                <input type="hidden" name="apuscityo-custom-fields-id[]" value="<?php echo esc_html($field_counter); ?>" />
                
                <?php
                self::text( $prefix.'[label][]', esc_html__('Label', 'apuscityo-types'), $label_val, '', 'apuscityo-custom-field-label');
                self::text( $prefix.'[placeholder][]', esc_html__('Placeholder', 'apuscityo-types'), $placeholder_val);
                self::text( $prefix.'[description][]', esc_html__('Description', 'apuscityo-types'), $description_val);

                $opts = array(
                    'term-select' => esc_html__('Term Select', 'apuscityo-types'),
                    'term-multiselect' => esc_html__('Term Multiselect', 'apuscityo-types'),
                    'term-checklist' => esc_html__('Term Checklist', 'apuscityo-types'),
                );
                self::select( $prefix.'[select_type][]', $opts, esc_html__('Template', 'apuscityo-types'), $text_field_select_type);
                self::checkbox( $prefix.'[required][]', esc_html__('Required', 'apuscityo-types'), $required_val, $disable_check_val);
                self::checkbox( $prefix.'[show_in_submit_form][]', esc_html__('Show in submit form', 'apuscityo-types'), $show_in_submit_form_val, $disable_check_val);
                self::checkbox( $prefix.'[show_in_admin_edit][]', esc_html__('Show in admin edit page', 'apuscityo-types'), $show_in_admin_edit_val, $disable_check_val);

                // packages
                $packages = self::get_packages();
                if ( $packages ) {
                    $show_in_package = isset($field_data['show_in_package']) ? $field_data['show_in_package'] : '';
                    $package_display = isset($field_data['package_display']) ? $field_data['package_display'] : '';
                    self::checkbox( $prefix.'[show_in_package][]', esc_html__('Enable package visibility', 'apuscityo-types'), $show_in_package, false, true, 'show_in_package');
                    self::select( $prefix.'[package_display]['.$field_counter.'][]', $packages, esc_html__('Packages', 'apuscityo-types'), $package_display, esc_html__('Choose Packages to show this field insubmit form.', 'apuscityo-types'), true, true, 'show_if_show_in_package');
                }

                do_action('apuscityo_custom_field_available_tax_callback');
                ?>

            </div>
        </div>
        <?php
        $html = ob_get_clean();

        return $html;
    }

    public static function field_available_file_callback($type, $field_counter, $field_data) {
        ob_start();
        $rand = $field_counter;

        $label_val = isset($field_data['label']) ? $field_data['label'] : 'Available Field';
        $key_val = $type;
        $placeholder_val = isset($field_data['placeholder']) ? $field_data['placeholder'] : '';
        $description_val = isset($field_data['description']) ? $field_data['description'] : '';

        $required_val = isset($field_data['required']) ? $field_data['required'] : '';
        $show_in_submit_form_val = isset($field_data['show_in_submit_form']) ? $field_data['show_in_submit_form'] : 'yes';
        $show_in_admin_edit_val = isset($field_data['show_in_admin_edit']) ? $field_data['show_in_admin_edit'] : 'yes';

        $disable_check_val = isset($field_data['disable_check']) ? $field_data['disable_check'] : false;

        $text_field_allow_types = isset($field_data['allow_types']) ? $field_data['allow_types'] : '';

        $prefix = 'apuscityo-custom-fields-'.$type;
        ?>
        <div class="apuscityo-custom-field-container apuscityo-custom-field-<?php echo esc_attr($type); ?>-container">
            <?php self::header_html($type, $rand, $label_val); ?>
            <?php self::hidden( $prefix.'[key][]', $key_val, 'apuscityo-custom-field-key'); ?>
            <div class="field-data form-group-wrapper" id="<?php echo esc_attr($type); ?>-field-wraper<?php echo esc_html($rand); ?>" style="display:none;">
                <input type="hidden" name="apuscityo-custom-fields-type[]" value="<?php echo esc_attr($type); ?>" />
                <input type="hidden" name="apuscityo-custom-fields-id[]" value="<?php echo esc_html($field_counter); ?>" />
                
                <?php
                self::text( $prefix.'[label][]', esc_html__('Label', 'apuscityo-types'), $label_val, '', 'apuscityo-custom-field-label');
                self::text( $prefix.'[placeholder][]', esc_html__('Placeholder', 'apuscityo-types'), $placeholder_val);
                self::text( $prefix.'[description][]', esc_html__('Description', 'apuscityo-types'), $description_val);
                
                $mime_types = get_allowed_mime_types();
                
                self::select( $prefix.'[allow_types]['.$field_counter.'][]', $mime_types, esc_html__('Allowed file types', 'apuscityo-types'), $text_field_allow_types, '', true);

                self::checkbox( $prefix.'[required][]', esc_html__('Required', 'apuscityo-types'), $required_val, $disable_check_val);
                self::checkbox( $prefix.'[show_in_submit_form][]', esc_html__('Show in submit form', 'apuscityo-types'), $show_in_submit_form_val, $disable_check_val);
                self::checkbox( $prefix.'[show_in_admin_edit][]', esc_html__('Show in admin edit page', 'apuscityo-types'), $show_in_admin_edit_val, $disable_check_val);

                // packages
                $packages = self::get_packages();
                if ( $packages ) {
                    $show_in_package = isset($field_data['show_in_package']) ? $field_data['show_in_package'] : '';
                    $package_display = isset($field_data['package_display']) ? $field_data['package_display'] : '';
                    self::checkbox( $prefix.'[show_in_package][]', esc_html__('Enable package visibility', 'apuscityo-types'), $show_in_package, false, true, 'show_in_package');
                    self::select( $prefix.'[package_display]['.$field_counter.'][]', $packages, esc_html__('Packages', 'apuscityo-types'), $package_display, esc_html__('Choose Packages to show this field insubmit form.', 'apuscityo-types'), true, true, 'show_if_show_in_package');
                }

                do_action('apuscityo_custom_field_available_file_callback');
                ?>

            </div>
        </div>
        <?php
        $html = ob_get_clean();

        return $html;
    }

    public static function field_available_files_callback($type, $field_counter, $field_data) {
        ob_start();
        $rand = $field_counter;

        $label_val = isset($field_data['label']) ? $field_data['label'] : 'Available Field';
        $key_val = $type;
        $placeholder_val = isset($field_data['placeholder']) ? $field_data['placeholder'] : '';
        $description_val = isset($field_data['description']) ? $field_data['description'] : '';
        $file_limit = isset($field_data['file_limit']) ? $field_data['file_limit'] : 5;

        $required_val = isset($field_data['required']) ? $field_data['required'] : '';
        $show_in_submit_form_val = isset($field_data['show_in_submit_form']) ? $field_data['show_in_submit_form'] : 'yes';
        $show_in_admin_edit_val = isset($field_data['show_in_admin_edit']) ? $field_data['show_in_admin_edit'] : 'yes';

        $disable_check_val = isset($field_data['disable_check']) ? $field_data['disable_check'] : false;

        $text_field_allow_types = isset($field_data['allow_types']) ? $field_data['allow_types'] : '';

        $prefix = 'apuscityo-custom-fields-'.$type;
        ?>
        <div class="apuscityo-custom-field-container apuscityo-custom-field-<?php echo esc_attr($type); ?>-container">
            <?php self::header_html($type, $rand, $label_val); ?>
            <?php self::hidden( $prefix.'[key][]', $key_val, 'apuscityo-custom-field-key'); ?>
            <div class="field-data form-group-wrapper" id="<?php echo esc_attr($type); ?>-field-wraper<?php echo esc_html($rand); ?>" style="display:none;">
                <input type="hidden" name="apuscityo-custom-fields-type[]" value="<?php echo esc_attr($type); ?>" />
                <input type="hidden" name="apuscityo-custom-fields-id[]" value="<?php echo esc_html($field_counter); ?>" />
                
                <?php
                self::text( $prefix.'[label][]', esc_html__('Label', 'apuscityo-types'), $label_val, '', 'apuscityo-custom-field-label');
                self::text( $prefix.'[placeholder][]', esc_html__('Placeholder', 'apuscityo-types'), $placeholder_val);
                self::text( $prefix.'[description][]', esc_html__('Description', 'apuscityo-types'), $description_val);
                
                self::text( $prefix.'[file_limit][]', esc_html__('File limit', 'apuscityo-types'), $file_limit);

                $mime_types = get_allowed_mime_types();
                
                self::select( $prefix.'[allow_types]['.$field_counter.'][]', $mime_types, esc_html__('Allowed file types', 'apuscityo-types'), $text_field_allow_types, '', true);

                self::checkbox( $prefix.'[required][]', esc_html__('Required', 'apuscityo-types'), $required_val, $disable_check_val);
                self::checkbox( $prefix.'[show_in_submit_form][]', esc_html__('Show in submit form', 'apuscityo-types'), $show_in_submit_form_val, $disable_check_val);
                self::checkbox( $prefix.'[show_in_admin_edit][]', esc_html__('Show in admin edit page', 'apuscityo-types'), $show_in_admin_edit_val, $disable_check_val);

                // packages
                $packages = self::get_packages();
                if ( $packages ) {
                    $show_in_package = isset($field_data['show_in_package']) ? $field_data['show_in_package'] : '';
                    $package_display = isset($field_data['package_display']) ? $field_data['package_display'] : '';
                    self::checkbox( $prefix.'[show_in_package][]', esc_html__('Enable package visibility', 'apuscityo-types'), $show_in_package, false, true, 'show_in_package');
                    self::select( $prefix.'[package_display]['.$field_counter.'][]', $packages, esc_html__('Packages', 'apuscityo-types'), $package_display, esc_html__('Choose Packages to show this field insubmit form.', 'apuscityo-types'), true, true, 'show_if_show_in_package');
                }

                do_action('apuscityo_custom_field_available_file_callback');
                ?>

            </div>
        </div>
        <?php
        $html = ob_get_clean();

        return $html;
    }

    public static function field_available_job_description_callback($type, $field_counter, $field_data) {
        ob_start();
        $rand = $field_counter;

        $label_val = isset($field_data['label']) ? $field_data['label'] : 'Custom Field';
        $key_val = $type;
        $placeholder_val = isset($field_data['placeholder']) ? $field_data['placeholder'] : '';
        $description_val = isset($field_data['description']) ? $field_data['description'] : '';
        $text_field_select_type = isset($field_data['select_type']) ? $field_data['select_type'] : 'textarea';

        $required_val = isset($field_data['required']) ? $field_data['required'] : '';
        $show_in_submit_form_val = isset($field_data['show_in_submit_form']) ? $field_data['show_in_submit_form'] : 'yes';
        $show_in_admin_edit_val = isset($field_data['show_in_admin_edit']) ? $field_data['show_in_admin_edit'] : 'yes';

        $disable_check_val = isset($field_data['disable_check']) ? $field_data['disable_check'] : false;
        $prefix = 'apuscityo-custom-fields-'.$type;
        ?>
        <div class="apuscityo-custom-field-container apuscityo-custom-field-<?php echo esc_attr($type); ?>-container">
            <?php self::header_html($type, $rand, $label_val); ?>
            <?php self::hidden( $prefix.'[key][]', $key_val, 'apuscityo-custom-field-key'); ?>
            <div class="field-data form-group-wrapper" id="<?php echo esc_attr($type); ?>-field-wraper<?php echo esc_html($rand); ?>" style="display:none;">
                <input type="hidden" name="apuscityo-custom-fields-type[]" value="<?php echo esc_attr($type); ?>" />
                <input type="hidden" name="apuscityo-custom-fields-id[]" value="<?php echo esc_html($field_counter); ?>" />

                <?php

                self::text( $prefix.'[label][]', esc_html__('Label', 'apuscityo-types'), $label_val, '', 'apuscityo-custom-field-label');
                self::text( $prefix.'[placeholder][]', esc_html__('Placeholder', 'apuscityo-types'), $placeholder_val);
                self::text( $prefix.'[description][]', esc_html__('Description', 'apuscityo-types'), $description_val);

                $opts = array(
                    'textarea' => esc_html__('Textarea', 'apuscityo-types'),
                    'wp-editor' => esc_html__('WP Editor', 'apuscityo-types'),
                );
                self::select( $prefix.'[select_type][]', $opts, esc_html__('Template', 'apuscityo-types'), $text_field_select_type);
                self::checkbox( $prefix.'[required][]', esc_html__('Required', 'apuscityo-types'), $required_val, $disable_check_val);
                self::checkbox( $prefix.'[show_in_submit_form][]', esc_html__('Show in submit form', 'apuscityo-types'), $show_in_submit_form_val, $disable_check_val);
                self::checkbox( $prefix.'[show_in_admin_edit][]', esc_html__('Show in admin edit page', 'apuscityo-types'), $show_in_admin_edit_val, $disable_check_val);

                // packages
                $packages = self::get_packages();
                if ( $packages ) {
                    $show_in_package = isset($field_data['show_in_package']) ? $field_data['show_in_package'] : '';
                    $package_display = isset($field_data['package_display']) ? $field_data['package_display'] : '';
                    self::checkbox( $prefix.'[show_in_package][]', esc_html__('Enable package visibility', 'apuscityo-types'), $show_in_package, false, true, 'show_in_package');
                    self::select( $prefix.'[package_display]['.$field_counter.'][]', $packages, esc_html__('Packages', 'apuscityo-types'), $package_display, esc_html__('Choose Packages to show this field insubmit form.', 'apuscityo-types'), true, true, 'show_if_show_in_package');
                }

                do_action('apuscityo_custom_field_available_job_description_callback');
                ?>

            </div>
        </div>
        <?php
        $html = ob_get_clean();

        return $html;
    }

    public static function field_available_job_products_callback($type, $field_counter, $field_data) {
        ob_start();
        $rand = $field_counter;

        $label_val = isset($field_data['label']) ? $field_data['label'] : 'Custom Field';
        $key_val = $type;
        $placeholder_val = isset($field_data['placeholder']) ? $field_data['placeholder'] : '';
        $description_val = isset($field_data['description']) ? $field_data['description'] : '';
        $text_field_product_type = isset($field_data['product_type']) ? $field_data['product_type'] : 'textarea';

        $required_val = isset($field_data['required']) ? $field_data['required'] : '';
        $show_in_submit_form_val = isset($field_data['show_in_submit_form']) ? $field_data['show_in_submit_form'] : 'yes';
        $show_in_admin_edit_val = isset($field_data['show_in_admin_edit']) ? $field_data['show_in_admin_edit'] : 'yes';

        $disable_check_val = isset($field_data['disable_check']) ? $field_data['disable_check'] : false;
        $prefix = 'apuscityo-custom-fields-'.$type;
        ?>
        <div class="apuscityo-custom-field-container apuscityo-custom-field-<?php echo esc_attr($type); ?>-container">
            <?php self::header_html($type, $rand, $label_val); ?>
            <?php self::hidden( $prefix.'[key][]', $key_val, 'apuscityo-custom-field-key'); ?>
            <div class="field-data form-group-wrapper" id="<?php echo esc_attr($type); ?>-field-wraper<?php echo esc_html($rand); ?>" style="display:none;">
                <input type="hidden" name="apuscityo-custom-fields-type[]" value="<?php echo esc_attr($type); ?>" />
                <input type="hidden" name="apuscityo-custom-fields-id[]" value="<?php echo esc_html($field_counter); ?>" />

                <?php

                self::text( $prefix.'[label][]', esc_html__('Label', 'apuscityo-types'), $label_val, '', 'apuscityo-custom-field-label');
                self::text( $prefix.'[placeholder][]', esc_html__('Placeholder', 'apuscityo-types'), $placeholder_val);
                self::text( $prefix.'[description][]', esc_html__('Description', 'apuscityo-types'), $description_val);

                $opts = array(
                    'own' => esc_html__('Only their own', 'apuscityo-types'),
                    'all' => esc_html__('All', 'apuscityo-types'),
                );
                self::select( $prefix.'[product_type][]', $opts, esc_html__('Products limitation', 'apuscityo-types'), $text_field_product_type);

                self::checkbox( $prefix.'[required][]', esc_html__('Required', 'apuscityo-types'), $required_val, $disable_check_val);
                self::checkbox( $prefix.'[show_in_submit_form][]', esc_html__('Show in submit form', 'apuscityo-types'), $show_in_submit_form_val, $disable_check_val);
                self::checkbox( $prefix.'[show_in_admin_edit][]', esc_html__('Show in admin edit page', 'apuscityo-types'), $show_in_admin_edit_val, $disable_check_val);

                // packages
                $packages = self::get_packages();
                if ( $packages ) {
                    $show_in_package = isset($field_data['show_in_package']) ? $field_data['show_in_package'] : '';
                    $package_display = isset($field_data['package_display']) ? $field_data['package_display'] : '';
                    self::checkbox( $prefix.'[show_in_package][]', esc_html__('Enable package visibility', 'apuscityo-types'), $show_in_package, false, true, 'show_in_package');
                    self::select( $prefix.'[package_display]['.$field_counter.'][]', $packages, esc_html__('Packages', 'apuscityo-types'), $package_display, esc_html__('Choose Packages to show this field insubmit form.', 'apuscityo-types'), true, true, 'show_if_show_in_package');
                }

                do_action('apuscityo_custom_field_available_job_products_callback');
                ?>

            </div>
        </div>
        <?php
        $html = ob_get_clean();

        return $html;
    }

    public static function field_available_job_date_callback($type, $field_counter, $field_data) {
        ob_start();
        $rand = $field_counter;

        $label_val = isset($field_data['label']) ? $field_data['label'] : 'Custom Field';
        $key_val = $type;
        $placeholder_val = isset($field_data['placeholder']) ? $field_data['placeholder'] : '';
        $description_val = isset($field_data['description']) ? $field_data['description'] : '';
        $format = isset($field_data['format']) ? $field_data['format'] : 'date';

        $required_val = isset($field_data['required']) ? $field_data['required'] : '';
        $show_in_submit_form_val = isset($field_data['show_in_submit_form']) ? $field_data['show_in_submit_form'] : 'yes';
        $show_in_admin_edit_val = isset($field_data['show_in_admin_edit']) ? $field_data['show_in_admin_edit'] : 'yes';

        $disable_check_val = isset($field_data['disable_check']) ? $field_data['disable_check'] : false;

        $prefix = 'apuscityo-custom-fields-'.$type;
        ?>
        <div class="apuscityo-custom-field-container apuscityo-custom-field-<?php echo esc_attr($type); ?>-container">
            <?php self::header_html($type, $rand, $label_val); ?>
            <?php self::hidden( $prefix.'[key][]', $key_val, 'apuscityo-custom-field-key'); ?>
            <div class="field-data form-group-wrapper" id="<?php echo esc_attr($type); ?>-field-wraper<?php echo esc_html($rand); ?>" style="display:none;">
                <input type="hidden" name="apuscityo-custom-fields-type[]" value="<?php echo esc_attr($type); ?>" />
                <input type="hidden" name="apuscityo-custom-fields-id[]" value="<?php echo esc_html($field_counter); ?>" />

                <?php
                self::text( $prefix.'[label][]', esc_html__('Label', 'apuscityo-types'), $label_val, '', 'apuscityo-custom-field-label');
                self::text( $prefix.'[placeholder][]', esc_html__('Placeholder', 'apuscityo-types'), $placeholder_val);
                self::text( $prefix.'[description][]', esc_html__('Description', 'apuscityo-types'), $description_val);

                $opts = array(
                    'date' => esc_html__('Date', 'apuscityo-types'),
                    'datetime' => esc_html__('Datetime', 'apuscityo-types'),
                );
                self::select( $prefix.'[format][]', $opts, esc_html__('Format', 'apuscityo-types'), $format);
                self::checkbox( $prefix.'[required][]', esc_html__('Required', 'apuscityo-types'), $required_val, $disable_check_val);
                self::checkbox( $prefix.'[show_in_submit_form][]', esc_html__('Show in submit form', 'apuscityo-types'), $show_in_submit_form_val, $disable_check_val);
                self::checkbox( $prefix.'[show_in_admin_edit][]', esc_html__('Show in admin edit page', 'apuscityo-types'), $show_in_admin_edit_val, $disable_check_val);

                // packages
                $packages = self::get_packages();
                if ( $packages ) {
                    $show_in_package = isset($field_data['show_in_package']) ? $field_data['show_in_package'] : '';
                    $package_display = isset($field_data['package_display']) ? $field_data['package_display'] : '';
                    self::checkbox( $prefix.'[show_in_package][]', esc_html__('Enable package visibility', 'apuscityo-types'), $show_in_package, false, true, 'show_in_package');
                    self::select( $prefix.'[package_display]['.$field_counter.'][]', $packages, esc_html__('Packages', 'apuscityo-types'), $package_display, esc_html__('Choose Packages to show this field insubmit form.', 'apuscityo-types'), true, true, 'show_if_show_in_package');
                }

                do_action('apuscityo_custom_field_available_job_date_callback');
                ?>

            </div>
        </div>
        <?php
        $html = ob_get_clean();

        return $html;
    }

    public static function field_available_job_select_option_callback($type, $field_counter, $field_data) {
        ob_start();
        $rand = $field_counter;

        $label_val = isset($field_data['label']) ? $field_data['label'] : 'Available Field';
        $key_val = $type;
        $placeholder_val = isset($field_data['placeholder']) ? $field_data['placeholder'] : '';
        $description_val = isset($field_data['description']) ? $field_data['description'] : '';
        $text_field_options = isset($field_data['options']) ? $field_data['options'] : '';

        $required_val = isset($field_data['required']) ? $field_data['required'] : '';
        $show_in_submit_form_val = isset($field_data['show_in_submit_form']) ? $field_data['show_in_submit_form'] : 'yes';
        $show_in_admin_edit_val = isset($field_data['show_in_admin_edit']) ? $field_data['show_in_admin_edit'] : 'yes';

        $disable_check_val = isset($field_data['disable_check']) ? $field_data['disable_check'] : false;

        $prefix = 'apuscityo-custom-fields-'.$type;
        ?>
        <div class="apuscityo-custom-field-container apuscityo-custom-field-<?php echo esc_attr($type); ?>-container">
            <?php self::header_html($type, $rand, $label_val); ?>
            <?php self::hidden( $prefix.'[key][]', $key_val, 'apuscityo-custom-field-key'); ?>
            <div class="field-data form-group-wrapper" id="<?php echo esc_attr($type); ?>-field-wraper<?php echo esc_html($rand); ?>" style="display:none;">
                <input type="hidden" name="apuscityo-custom-fields-type[]" value="<?php echo esc_attr($type); ?>" />
                <input type="hidden" name="apuscityo-custom-fields-id[]" value="<?php echo esc_html($field_counter); ?>" />
                
                <?php
                self::text( $prefix.'[label][]', esc_html__('Label', 'apuscityo-types'), $label_val, '', 'apuscityo-custom-field-label');
                self::text( $prefix.'[placeholder][]', esc_html__('Placeholder', 'apuscityo-types'), $placeholder_val);
                self::text( $prefix.'[description][]', esc_html__('Description', 'apuscityo-types'), $description_val);
                self::textarea( $prefix.'[options][]', esc_html__('Options', 'apuscityo-types'), $text_field_options, esc_html__('Add each option in a new line.', 'apuscityo-types'));
                self::checkbox( $prefix.'[required][]', esc_html__('Required', 'apuscityo-types'), $required_val, $disable_check_val);
                self::checkbox( $prefix.'[show_in_submit_form][]', esc_html__('Show in submit form', 'apuscityo-types'), $show_in_submit_form_val, $disable_check_val);
                self::checkbox( $prefix.'[show_in_admin_edit][]', esc_html__('Show in admin edit page', 'apuscityo-types'), $show_in_admin_edit_val, $disable_check_val);

                // packages
                $packages = self::get_packages();
                if ( $packages ) {
                    $show_in_package = isset($field_data['show_in_package']) ? $field_data['show_in_package'] : '';
                    $package_display = isset($field_data['package_display']) ? $field_data['package_display'] : '';
                    self::checkbox( $prefix.'[show_in_package][]', esc_html__('Enable package visibility', 'apuscityo-types'), $show_in_package, false, true, 'show_in_package');
                    self::select( $prefix.'[package_display]['.$field_counter.'][]', $packages, esc_html__('Packages', 'apuscityo-types'), $package_display, esc_html__('Choose Packages to show this field insubmit form.', 'apuscityo-types'), true, true, 'show_if_show_in_package');
                }

                do_action('apuscityo_custom_field_available_simple_callback');
                ?>

            </div>
        </div>
        <?php
        $html = ob_get_clean();

        return $html;
    }

    public static function field_actions_html_callback($li_rand, $rand, $field_type, $delete = true) {
        ob_start();
        ?>
        <div class="actions">
            <a href="javascript:void(0);" class="custom-fields-edit <?php echo esc_attr($field_type); ?>-field<?php echo esc_attr($rand); ?>" ><i  class="dashicons dashicons-edit" aria-hidden="true"></i></a>
            <?php if ($delete) { ?>
                <a href="javascript:void(0);" class="custom-fields-remove" data-randid="<?php echo esc_attr($li_rand) ?>" data-fieldtype="<?php echo esc_attr($field_type); ?>"><i  class="dashicons dashicons-trash" aria-hidden="true"></i></a>
            <?php } ?>
        </div>
        <?php
        $html = ob_get_clean();

        return $html;
    }

    public static function header_html($type, $rand, $label_val) {
        ?>
        <div class="field-intro">
            <?php $field_dyn_name = $label_val != '' ? '<b>(' . $label_val . ')</b>' : '' ?>
            <a href="javascript:void(0);" class="<?php echo esc_attr($type); ?>-field<?php echo esc_attr($rand); ?>" >
                <?php echo wp_kses(sprintf(__('%s Field %s', 'apuscityo-types'), $type, $field_dyn_name), array('b' => array())); ?>
            </a>
        </div>
        <?php
    }

    public static function text($name, $title = '', $value = '', $desc = '', $inputclass = '', $fullwidth = false) {
        ?>
        <div class="form-group <?php echo esc_attr($fullwidth ? 'fullwidth' : ''); ?>">
            <label><?php echo $title; ?></label>
            <div class="input-field">
                <input type="text" name="<?php echo $name ;?>" value="<?php echo esc_attr($value); ?>" <?php echo trim($inputclass ? 'class="'.$inputclass.'"' : ''); ?>/>
                <?php if ( !empty($desc) ) { ?>
                    <span class="desc"><?php echo $desc; ?></span>
                <?php } ?>
            </div>
        </div>
        <?php
    }

    public static function hidden($name, $value = '', $inputclass = '') {
        ?>
        <input type="hidden" name="<?php echo $name ;?>" value="<?php echo esc_attr($value); ?>" <?php echo trim($inputclass ? 'class="'.$inputclass.'"' : ''); ?>/>
        <?php
    }

    public static function textarea($name, $title = '', $value = '', $desc = '', $fullwidth = false) {
        ?>
        <div class="form-group <?php echo esc_attr($fullwidth ? 'fullwidth' : ''); ?>">
            <label><?php echo $title; ?></label>
            <div class="input-field">
                <textarea name="<?php echo $name ;?>"><?php echo esc_html($value); ?></textarea>
                <?php if ( !empty($desc) ) { ?>
                    <span class="desc"><?php echo $desc; ?></span>
                <?php } ?>
            </div>
        </div>
        <?php
    }

    public static function checkbox($name, $title = '', $value = '', $disabled = false, $fullwidth = true, $inputclass = '') {
        ?>
        <div class="form-group <?php echo esc_attr($fullwidth ? 'fullwidth' : ''); ?>">
            <label>
                <input <?php echo trim($inputclass ? 'class="'.$inputclass.'"' : ''); ?> type="checkbox" name="<?php echo $name ;?>" value="yes" <?php echo ($value == 'yes' ? 'checked="checked"' : ''); ?> <?php echo ($disabled ? 'disabled="disabled"' : ''); ?>/>
                <?php echo $title; ?>
            </label>
        </div>
        <?php
    }

    public static function select($name, $opts, $title = '', $values = '', $desc = '', $multiple = false, $fullwidth = false, $wrapperclass = '') {
        ?>
        <div class="form-group <?php echo esc_attr($fullwidth ? 'fullwidth' : ''); ?> <?php echo trim($wrapperclass ? $wrapperclass : ''); ?>">
            <label><?php echo $title; ?></label>
            <div class="input-field">
                <select name="<?php echo $name ;?>" <?php echo ($multiple ? 'multiple="multiple"' : ''); ?>>
                    <?php
                    if ( !empty($opts) && is_array($opts) ) {
                        foreach ($opts as $key => $text) { ?>
                            <option value="<?php echo esc_attr($key); ?>" <?php self::selected($key, $values); ?>><?php echo $text; ?></option>
                        <?php }
                    } ?>
                </select>
                <?php if ( !empty($desc) ) { ?>
                    <span class="desc"><?php echo $desc; ?></span>
                <?php } ?>
            </div>
        </div>
        <?php
    }

    public static function selected($val, $defaults) {
        if ( is_array($defaults) ) {
            if ( in_array($val, $defaults) ) {
                echo 'selected="selected"';
            }
        } else {
            if ( $val == $defaults ) {
                echo 'selected="selected"';
            }
        }
    }

}

ApusCityo_CustomFieldHTML::init();