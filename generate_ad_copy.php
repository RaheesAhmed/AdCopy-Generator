<?php

require_once 'simple_html_dom.php';
require_once 'openai.php';

// Validate URL
$url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
if (!$url) {
    die('Invalid URL');
}

// Extract relevant content from website
$html = file_get_html($url);
if (!$html) {
    die('Unable to retrieve website content');
}

$title = $html->find('title', 0)->plaintext;
$description = $html->find('meta[name="description"]', 0)->attr['content'];

// Generate ad copy using OpenAI API
$generated_text = generate_ad_copy($title, $description);

// Generate ad copy for selected ad types
$google_ad_copy = '';
$facebook_ad_copy = '';
$linkedin_ad_copy = '';

if (isset($_POST['google'])) {
    $google_ad_copy = generate_google_ad_copy($generated_text);
}

if (isset($_POST['facebook'])) {
    $facebook_ad_copy = generate_facebook_ad_copy($generated_text);
}

if (isset($_POST['linkedin'])) {
    $linkedin_ad_copy = generate_linkedin_ad_copy($generated_text);
}

// Display ad copy results
require_once 'display_ad_copy.php';
