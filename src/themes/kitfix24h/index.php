<?php
/**
 * Fallback index template — redirects to homepage template or shows latest posts.
 */
if (is_front_page()) {
    // Use Homepage template
    include get_template_directory() . '/templates/page-homepage.php';
    return;
}
if (is_singular('post')) {
    include get_template_directory() . '/single.php';
    return;
}
// Default: show latest posts
include get_template_directory() . '/archive.php';
