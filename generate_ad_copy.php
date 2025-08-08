<?php

/**
 * Ad Copy Generator - Main Processing Script
 * 
 * This script handles the main processing workflow for generating ad copy from website content.
 * It processes form submissions from index.html, extracts website metadata, generates AI-powered
 * ad copy using OpenAI's GPT-3 API, and creates platform-specific variations for Google Ads,
 * Facebook Ads, and LinkedIn Ads.
 * 
 * Workflow:
 * 1. Validates the submitted URL
 * 2. Extracts title and meta description from the target website
 * 3. Generates base ad copy using OpenAI API
 * 4. Creates platform-specific ad copy variations based on user selection
 * 5. Displays results using the display template
 * 
 * @author AdCopy-Generator
 * @version 1.0.0
 * @requires PHP 7.2+
 * @requires simple_html_dom.php
 * @requires openai.php
 */

require_once 'simple_html_dom.php';
require_once 'openai.php';

/**
 * Validate the submitted URL from POST data
 * Uses PHP's built-in filter_input with FILTER_VALIDATE_URL to ensure
 * the provided URL is properly formatted and valid
 */
$url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
if (!$url) {
    die('Invalid URL');
}

/**
 * Extract relevant content from the target website
 * Uses Simple HTML DOM Parser to fetch and parse the website content
 * Terminates execution if the website cannot be accessed or parsed
 */
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



