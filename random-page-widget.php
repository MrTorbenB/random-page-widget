<?php
/*
Plugin Name: Random Page Widget
Plugin URI: https://torbenb.info/download/
Description: Zeigt eine zufällige Seite mit Vorschau, Textauszug und einem Bild an, basierend auf einer Auswahl von Seiten.
Version: 1.1
Author: TorbenB
Author URI: https://torbenb.info/
*/

// Sicherheit: Blockiere den direkten Aufruf dieser Datei
if (!defined('ABSPATH')) {
    exit;
}

// Registriere den Shortcode
function rpw_register_shortcode() {
    add_shortcode('random_page', 'rpw_display_random_page');
}
add_action('init', 'rpw_register_shortcode');

// Funktion, die die zufällige Seite anzeigt basierend auf den gespeicherten Seiten
function rpw_display_random_page($selected_pages = array()) {
    if (empty($selected_pages)) {
        return '<p>Keine Seiten verfügbar.</p>';
    }
    
    // Zufällige Seite aus der Auswahl anzeigen
    $args = array(
        'post_type' => 'page',
        'posts_per_page' => 1,
        'orderby' => 'rand',
        'post__in' => $selected_pages
    );
    
    $random_page_query = new WP_Query($args);

    // Wenn eine Seite gefunden wurde
    if ($random_page_query->have_posts()) {
        while ($random_page_query->have_posts()) {
            $random_page_query->the_post();
            
            // Titel der Seite
            $output = '<h3>' . get_the_title() . '</h3>';
            
            // Vorschau Bild (Thumbnail)
            if (has_post_thumbnail()) {
                $output .= get_the_post_thumbnail(get_the_ID(), 'medium');
            }
            
            // Textauszug der Seite
            $output .= '<p>' . get_the_excerpt() . '</p>';
            
            // Link zur Seite
            $output .= '<a href="' . get_permalink() . '">Weiterlesen</a>';
        }
        
        // Reset Post Data nach der Schleife
        wp_reset_postdata();
    } else {
        $output = '<p>Keine Seiten verfügbar.</p>';
    }

    return $output;
}

// Widget-Registrierung
class Random_Page_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'random_page_widget',
            __('Random Page Widget', 'text_domain'),
            array('description' => __('Zeigt eine zufällige Seite basierend auf der Auswahl von Seiten an.', 'text_domain'))
        );
    }
    
    // Das Front-End des Widgets
    public function widget($args, $instance) {
        $selected_pages = !empty($instance['selected_pages']) ? $instance['selected_pages'] : array();
        echo $args['before_widget'];
        echo rpw_display_random_page($selected_pages);
        echo $args['after_widget'];
    }
    
    // Widget-Backend Formular für die Seitenauswahl
    public function form($instance) {
        $selected_pages = !empty($instance['selected_pages']) ? $instance['selected_pages'] : array();
        $pages = get_pages();

        echo '<p>';
        echo '<label for="' . $this->get_field_id('selected_pages') . '">' . __('Seiten auswählen:', 'text_domain') . '</label>';
        echo '<br>';
        
        // Kästchen für jede Seite anzeigen
        foreach ($pages as $page) {
            $checked = in_array($page->ID, $selected_pages) ? 'checked="checked"' : '';
            echo '<input type="checkbox" id="' . $this->get_field_id('selected_pages') . '[]" name="' . $this->get_field_name('selected_pages') . '[]" value="' . $page->ID . '" ' . $checked . '>';
            echo '<label for="' . $this->get_field_id('selected_pages') . '[]">' . esc_html($page->post_title) . '</label><br>';
        }
        echo '</p>';
    }
    
    // Aktualisierung der Widget-Einstellungen
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['selected_pages'] = !empty($new_instance['selected_pages']) ? array_map('intval', $new_instance['selected_pages']) : array();
        return $instance;
    }
}

// Widget registrieren
function rpw_register_widget() {
    register_widget('Random_Page_Widget');
}
add_action('widgets_init', 'rpw_register_widget');
