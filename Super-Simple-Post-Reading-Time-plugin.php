<?php
/*
Plugin Name: Super Simple Post Reading Time
Plugin URI: https://radubraniscan.com/
Description: A simple plugin that adds the estimated reading time to the top of every post.
Version: 1.1
Author: Radu Braniscan
Author URI: https://radubraniscan.com/
License: GPL2
*/

// Prevent direct access to the file
if (!defined('ABSPATH')) {
    exit;
}

// Function to calculate reading time
function calculate_reading_time($content) {
    if (is_single()) {
        $word_count = str_word_count(strip_tags($content));
        $reading_time = ceil($word_count / 200); // Assuming 200 words per minute
        $reading_time_message = '<span style="font-size: 20px;"> | <i aria-hidden="true" class="far fa-eye"></i> ' . $reading_time . ' min read' . '</span>';
               // Find the end of the post meta information (usually after the post date)
        $date_position = strpos($content, '</time>');
        if ($date_position !== false) {
            $content = substr_replace($content, $reading_time_message, $date_position + 7, 0);
        } else {
            $content = $reading_time_message . $content; // Fallback in case the date is not found
        }
    }
    return $content;
}

// Hook the function to 'the_content' filter
add_filter('the_content', 'calculate_reading_time');