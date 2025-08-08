<?php

/**
 * OpenAI Integration and Ad Copy Generation Functions
 * 
 * This file contains all functions related to OpenAI GPT-3 API integration and
 * platform-specific ad copy generation. It handles the core AI-powered content
 * generation and creates tailored ad copy variations for Google Ads, Facebook Ads,
 * and LinkedIn Ads.
 * 
 * Functions included:
 * - generate_ad_copy(): Main OpenAI API integration for base ad copy generation
 * - generate_google_ad_copy(): Creates Google Ads-specific copy with appropriate CTA
 * - generate_facebook_ad_copy(): Creates Facebook Ads-specific copy with social CTAs
 * - generate_linkedin_ad_copy(): Creates LinkedIn Ads-specific copy for professional audience
 * 
 * @author AdCopy-Generator
 * @version 1.0.0
 * @requires PHP 7.2+
 * @requires OpenAI PHP SDK
 */

use OpenAI\Api\GPT3;

/**
 * Generate base ad copy using OpenAI GPT-3 API
 * 
 * This function integrates with OpenAI's GPT-3 API to generate advertising copy
 * based on website title and description. It uses the text-davinci-002 engine
 * with optimized parameters for marketing content generation.
 * 
 * @param string $title The website title extracted from <title> tag
 * @param string $description The meta description extracted from website
 * @return string Generated ad copy text from OpenAI API
 * @throws Exception If OpenAI API request fails or returns invalid response
 * 
 * @example
 * $ad_copy = generate_ad_copy("Best Coffee Shop", "Premium coffee and pastries");
 * // Returns: AI-generated marketing copy based on the input
 */
function generate_ad_copy($title, $description) {
    $openai_api_key = 'YOUR API KEY HERE';
    $gpt3 = new GPT3($openai_api_key);
    $gpt3->setEngineId('text-davinci-002');
    $gpt3->setPrompt('Write ad copy for ' . $title . ' using the following description: ' . $description);
    $gpt3->setMaxTokens(200);
    $gpt3->setTemperature(0.7);
    $gpt3->setTopP(1);
    $gpt3->setFrequencyPenalty(0);
    $gpt3->setPresencePenalty(0);
    $gpt3->setStopSequences(['\n\n']);
    return $gpt3->complete();
}

function generate_google_ad_copy($generated_text) {
    // Remove any HTML tags from generated text
    $text = strip_tags($generated_text);
    
    // Trim any whitespace from beginning or end of text
    $text = trim($text);
    
    // Split text into sentences
    $sentences = preg_split('/(?<=[.?!])\s+/', $text);
    
    // Select a random sentence from the generated text
    $random_sentence = $sentences[array_rand($sentences)];
    
    // Generate Google Ads copy
    $google_ad_copy = 'Discover ' . $random_sentence . ' Click Here Now!';
    
    return $google_ad_copy;
}


function generate_facebook_ad_copy($generated_text) {
    // Remove any HTML tags from generated text
    $text = strip_tags($generated_text);
    
    // Trim any whitespace from beginning or end of text
    $text = trim($text);
    
    // Split text into sentences
    $sentences = preg_split('/(?<=[.?!])\s+/', $text);
    
    // Select a random sentence from the generated text
    $random_sentence = $sentences[array_rand($sentences)];
    
    // Generate Facebook Ads copy
    $facebook_ad_copy = 'Get ' . $random_sentence . ' Like & Share Now!';
    
    return $facebook_ad_copy;
}


function generate_linkedin_ad_copy($generated_text) {
    // Remove any HTML tags from generated text
    $text = strip_tags($generated_text);
    
    // Trim any whitespace from beginning or end of text
    $text = trim($text);
    
    // Split text into sentences
    $sentences = preg_split('/(?<=[.?!])\s+/', $text);
    
    // Select a random sentence from the generated text
    $random_sentence = $sentences[array_rand($sentences)];
    
    // Generate LinkedIn Ads copy
    $linkedin_ad_copy = 'Explore ' . $random_sentence . ' Connect Now!';
    
    return $linkedin_ad_copy;
}



