<?php

use OpenAI\Api\GPT3;

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

