<?php
/**
 * nwp_nurego_offering():
 * fetches an offering for the api_key it is called with
 *
 * Following params are can be passed through shortcode
 *  ie [nurego param="value"]
 *
 * @param string $api_key
 * @param string $element_id         ID of DOM element
 * @param string $theme              CSS class for pricing table
 * @param string $css_url            URL to css file if non-default is desired
 * @param string $select_url         URL prefix for plan link
 * @param function $select_callback  Callback function for pricing plan
 * @param string $label_price        Label in price column
 * @param string $label_select       Label on select button
 * @param string $label_feature_on   String for enabled option
 * @param string $label_feature_off  String for disabled option
 * @param string $label_before_price Prefix for price value (currency)
 * @param string $label_after_price  Suffix for price value (currency)
 * @param integer $time_out          Timeout in milliseconds
 * @param string $loading_class      CSS class for loading block
 * @param string $error_class        CSS class for error block
 * @param string $warning_class      CSS class for warning block
 * @param string $empty_class        CSS class for empty block
 * @param string $price_class        CSS class for price block
 */
function nwp_nurego_offering($atts, $content = null) {

    // Load the nurego-js library at this time to use it 
    wp_enqueue_script('nurego-js');

    // Load all potential params from symbol table
    $a = shortcode_atts( array(
        'api_key'            => '',
        'element_id'         => 'nwp_div',   // Default for correct placement
        'theme'              => '',
        'css_url'            => '',
        'select_url'         => '',
        'select_callback'    => '',
        'label_price'        => '',
        'label_select'       => '',
        'label_feature_on'   => '',
        'label_feature_off'  => '',
        'label_before_price' => '',
        'label_after_price'  => '',
        'time_out'           => '',
        'error_class'        => '',
        'warning_class'      => '',
        'empty_class'        => '',
        'price_class'        => '',
    ), $atts );

    // Top part of JS sandwich that will be returned
    $output_top = '<script type="text/javascript">'
        .'jQuery( document ).ready( function() {';

    // Middle part of sandwich w/params
    $output_middle = '';
    foreach ($a as $key => $value) {
        if ($value != '' && $key != 'api_key') {
            $output_middle .= 'Nurego.setParam(\''.$key .'\',\''.$value.'\');';
        } else {
            // Debugging code:
            //$output_middle .='<!--Tried to set: '.$key.' with value: '.$value.'-->';
            continue;
        };
    };
    
    $output_bottom = 'Nurego.setApiKey(' . "'". $a['api_key'] . "'" . ');'
        .'});'
        .'</script>'
        .'<div id=\'nwp_div\'>' // Default div to specify for correct placement
        .'</div>';

    // Combine it all for the correct output
    $output = $output_top . $output_middle . $output_bottom;

    return $output;
}

/**
 * nwp_nurego_live_shortcode 
 * Following params are set in the settings page
 *
 * @param string $live_api_key
 * @param string $element_id         ID of DOM element
 * @param string $theme              CSS class for pricing table
 * @param string $css_url            URL to css file if non-default is desired
 * @param string $select_url         URL prefix for plan link
 * @param function $select_callback  Callback function for pricing plan
 * @param string $label_price        Label in price column
 * @param string $label_select       Label on select button
 * @param string $label_feature_on   String for enabled option
 * @param string $label_feature_off  String for disabled option
 * @param string $label_before_price Prefix for price value (currency)
 * @param string $label_after_price  Suffix for price value (currency)
 * @param integer $time_out          Timeout in milliseconds
 * @param string $loading_class      CSS class for loading block
 * @param string $error_class        CSS class for error block
 * @param string $warning_class      CSS class for warning block
 * @param string $empty_class        CSS class for empty block
 * @param string $price_class        CSS class for price block
 */
function nwp_nurego_live_shortcode() {

    // Load the nurego-js library at this time to use it 
    wp_enqueue_script('nurego-js');


    //Array of options to iterate through
    $a = array( 'element_id'    => 'nwp_div',   // Default for correct placement
           'theme'              => '',
           'select_url'         => '',
           'select_callback'    => '',
           'label_price'        => '',
           'label_select'       => '',
           'label_feature_on'   => '',
           'label_feature_off'  => '',
           'label_before_price' => '',
           'label_after_price'  => '',
           'time_out'           => '',
           'error_class'        => '',
           'warning_class'      => '',
           'empty_class'        => '',
           'price_class'        => '',
           'css_url'            => '',
       );

    // Flag to ignore css url 
    $ignore_css;
    if (get_option('use_theme_css') == true) {
        $ignore_css = true;
    }

    // Top part of JS sandwich that will be returned
    $output_top = '<script type="text/javascript">'
        .'jQuery( document ).ready( function() {';

    // Iterate through and set the parameters
    $output_middle = '';
    foreach ($a as $key => $value) {
        if (get_option($key) != '') {

            // If $ignore_css flag == true, skip setting it
            if ( $key != 'css_url' && $ignore_css != true) {
                $output_middle .= 'Nurego.setParam(\''.$key .'\',\''.get_option($key).'\');';
            } else {
                continue;
            }
        } elseif ( $key == 'element_id') { // Still need the default element_id if it isn't set.
            $output_middle .= 'Nurego.setParam(\''.$key.'\',\''.$value.'\');'; 
        } else {
            // Throw debugging stuff here as needed
            continue;
        }
    }
    
    //Bottom part of sandwich
    $output_bottom = 'Nurego.setApiKey(' . "'". get_option('live_api_key') . "'" . ');'
        .'});'
        .'</script>'
        .'<div id=\'nwp_div\'>' // Default div to specify for correct placement
        .'</div>';

    // Combine it all for the correct output
    $output = $output_top . $output_middle . $output_bottom;

    return $output;
}


/**
 * nwp_nurego_test_shortcode 
 * Following params are set in the settings page
 *
 * @param string $test_api_key
 * @param string $element_id         ID of DOM element
 * @param string $theme              CSS class for pricing table
 * @param string $css_url            URL to css file if non-default is desired
 * @param string $select_url         URL prefix for plan link
 * @param function $select_callback  Callback function for pricing plan
 * @param string $label_price        Label in price column
 * @param string $label_select       Label on select button
 * @param string $label_feature_on   String for enabled option
 * @param string $label_feature_off  String for disabled option
 * @param string $label_before_price Prefix for price value (currency)
 * @param string $label_after_price  Suffix for price value (currency)
 * @param integer $time_out          Timeout in milliseconds
 * @param string $loading_class      CSS class for loading block
 * @param string $error_class        CSS class for error block
 * @param string $warning_class      CSS class for warning block
 * @param string $empty_class        CSS class for empty block
 * @param string $price_class        CSS class for price block
 */
function nwp_nurego_test_shortcode() {

    // Load the nurego-js library at this time to use it 
    wp_enqueue_script('nurego-js');


    //Array of options to iterate through
    $a = array( 'element_id'    => 'nwp_div',   // Default for correct placement
           'theme'              => '',
           'css_url'            => '',
           'select_url'         => '',
           'select_callback'    => '',
           'label_price'        => '',
           'label_select'       => '',
           'label_feature_on'   => '',
           'label_feature_off'  => '',
           'label_before_price' => '',
           'label_after_price'  => '',
           'time_out'           => '',
           'error_class'        => '',
           'warning_class'      => '',
           'empty_class'        => '',
           'price_class'        => '',
       );

    // Top part of JS sandwich that will be returned
    $output_top = '<script type="text/javascript">'
        .'jQuery( document ).ready( function() {';

    // Iterate through and set the parameters
    $output_middle = '';
    foreach ($a as $key => $value) {
        if (get_option($key) != '') {
            $output_middle .= 'Nurego.setParam(\''.$key .'\',\''.get_option($key).'\');';
        } elseif ( $key == 'element_id') { // Still need the default element_id if it isn't set.
            $output_middle .= 'Nurego.setParam(\''.$key.'\',\''.$value.'\');'; 
        } else {
            // Throw debugging stuff here as needed
            continue;
        }
    }

    //Bottom part of sandwich
    $output_bottom = 'Nurego.setApiKey(' . "'". get_option('test_api_key') . "'" . ');'
        .'});'
        .'</script>'
        .'<div id=\'nwp_div\'>' // Default div to specify for correct placement
        .'</div>';

    // Combine it all for the correct output
    $output = $output_top . $output_middle . $output_bottom;

    return $output;
}


/**
 * Now we include all the shortcodes
 */
add_shortcode('nurego-test', 'nwp_nurego_test_shortcode');
add_shortcode('nurego-live', 'nwp_nurego_live_shortcode');
add_shortcode('nurego', 'nwp_nurego_offering');
?>

