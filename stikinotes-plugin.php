<?php

/*
Plugin Name: Stikinotes Widget
Plugin URI: http://www.stikinotes.com
Description: Plugin to display a Stikinotes widget on your wordpress website.
Version: 1.3
Author: Gareth Chidgey, Ahoy Creative
Author URI: http://www.ahoycreative.co.uk
License: GPL2
*/


// Enqueus internal jQuery and stikinotes Javascript
function stiki_load_scripts()
{
        wp_deregister_script( 'jquery' );
        wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'stiki_js' , 'http://www.stikinotes.com/resources/js/stikishare.js');
}

function stiki_register_widget()
{
    register_widget('stiki_widget');
}

class stiki_widget extends WP_Widget
{
    function stiki_widget()
    {
        $this->WP_Widget( 'stiki_widget', 'Stikinotes Widget',
                            array( 'classname' => 'stikinotes_widget', 'description' => __('Stikinotes Widget', "stiki_widget") ),
                            array( 'width' => 200, 'height' => 250, 'id_base' => 'stiki_widget' )
                            );
    }
    
    function widget( $args, $instance )
    {
        extract( $args );
        echo $before_widget;
        echo '<div size="' . $instance['stiki_size'] . '" class="stikishare" locId="' . $instance['stiki_id'] . '" imageType="' . $instance['stiki_type'] . '" ></div>';
        echo $after_widget;
    }
    
    function form( $instance )
    {
        $instance = wp_parse_args( (array) $instance, array('title' => __("", "stiki_title"), 'tabindex' => '1') );
        $selected = '';
        if($instance['stiki_size'] == null)
        {
            $instance['stiki_size'] = '32';
        }
        if ($instance['stiki_type'] == 1)
        {
            $selected1 = ' selected="selected"';
            $selected2 = '';
        }
        else if ($instance['stiki_type'] == 2)
        {
            $selected1 = '';
            $selected2 = ' selected="selected"';
        }
        echo '
            <p>
                <h3>Your Stikiplace ID</h3>
                <input id="' . $this->get_field_id( 'stiki_id' ) . '" name="' . $this->get_field_name( 'stiki_id' ) . '" value="' . $instance['stiki_id'] . '" style="width:90%;" />
            </p>
            <p>
                <h3>Icon Size</h3>
                <input id="' . $this->get_field_id( 'stiki_size' ) . '" name="' . $this->get_field_name( 'stiki_size' ) . '" value="' . $instance['stiki_size'] . '" style="width:90%;" />
            </p>
            <p>
                <h3>Select Widget</h3>
                <select id="' . $this->get_field_id( 'stiki_type' ) . '" name="' . $this->get_field_name( 'stiki_type' ) . '" style="width:90%;">
                    <option value="1" ' . $selected1 . '>Visitor Book</option>
                    <option value="2" ' . $selected2 . '>Stikinotes Icon</option>
                </select>
            </p>

        ';
    }
}
add_action('wp_enqueue_scripts', 'stiki_load_scripts');
add_action('widgets_init','stiki_register_widget');

?>