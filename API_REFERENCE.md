# API Reference - AdCopy-Generator

This document provides comprehensive technical documentation for the OpenAI integration, GPT-3 parameters, prompt engineering approach, and platform-specific ad copy generation mechanisms used in the AdCopy-Generator application.

## Table of Contents

- [OpenAI Integration Overview](#openai-integration-overview)
- [GPT-3 Configuration](#gpt-3-configuration)
- [Prompt Engineering](#prompt-engineering)
- [Platform-Specific Generation](#platform-specific-generation)
- [API Functions Reference](#api-functions-reference)
- [Error Handling](#error-handling)
- [Performance Considerations](#performance-considerations)
- [Cost Management](#cost-management)
- [Security Implementation](#security-implementation)
- [Troubleshooting](#troubleshooting)

## OpenAI Integration Overview

### Architecture

The AdCopy-Generator integrates with OpenAI's GPT-3 API through a two-stage process:

1. **Base Content Generation**: Uses GPT-3 to generate foundational ad copy from website metadata
2. **Platform Optimization**: Processes the base content to create platform-specific variations

```
Website URL → Metadata Extraction → OpenAI API → Base Ad Copy → Platform Processing → Final Ad Copy
```

### API Endpoint

- **Base URL**: `https://api.openai.com/v1/`
- **Endpoint**: `/completions`
- **Method**: `POST`
- **Authentication**: Bearer Token (API Key)

### Integration Flow

```php
// Simplified integration flow
$metadata = extractWebsiteMetadata($url);
$baseContent = callOpenAI($metadata);
$platformContent = generatePlatformSpecific($baseContent);
```

## GPT-3 Configuration

### Engine Selection

**Selected Engine**: `text-davinci-002`

**Rationale**:
- High-quality text generation suitable for marketing content
- Good balance between creativity and coherence
- Reliable performance for advertising copy generation
- Cost-effective for the application's use case

**Alternative Engines Considered**:
- `text-davinci-003`: Higher quality but more expensive
- `text-curie-001`: Lower cost but reduced quality
- `gpt-3.5-turbo`: Chat-optimized, not ideal for completion tasks

### Parameter Configuration

The application uses the following GPT-3 parameters:

| Parameter | Value | Purpose | Impact |
|-----------|-------|---------|---------|
| `engine` | `text-davinci-002` | Model selection | Quality and cost balance |
| `max_tokens` | `200` | Response length limit | Controls output length |
| `temperature` | `0.7` | Creativity control | Balanced creativity/consistency |
| `top_p` | `1.0` | Nucleus sampling | Full vocabulary access |
| `frequency_penalty` | `0` | Repetition control | No repetition penalty |
| `presence_penalty` | `0` | Topic diversity | No topic penalty |
| `stop` | `['\n\n']` | Stop sequence | Prevents overlong responses |

### Parameter Details

#### Temperature (0.7)
```php
$gpt3->setTemperature(0.7);
```
- **Range**: 0.0 to 1.0
- **Current Value**: 0.7
- **Effect**: Balanced creativity and consistency
- **Rationale**: Provides creative ad copy while maintaining coherence
- **Alternative Values**:
  - `0.3-0.5`: More conservative, consistent output
  - `0.8-1.0`: More creative, potentially less coherent

#### Max Tokens (200)
```php
$gpt3->setMaxTokens(200);
```
- **Current Value**: 200 tokens (~150-200 words)
- **Rationale**: Sufficient for ad copy without excessive length
- **Cost Impact**: Directly affects API costs
- **Optimization**: Balances content quality with cost efficiency

#### Top P (1.0)
```php
$gpt3->setTopP(1);
```
- **Current Value**: 1.0 (100% of vocabulary)
- **Effect**: Full access to model's vocabulary
- **Alternative**: 0.9 for slightly more focused responses

#### Stop Sequences
```php
$gpt3->setStopSequences(['\n\n']);
```
- **Purpose**: Prevents overly long responses
- **Trigger**: Double newline characters
- **Effect**: Natural stopping point for ad copy

## Prompt Engineering

### Prompt Structure

The application uses a structured prompt format:

```
Write ad copy for [TITLE] using the following description: [DESCRIPTION]
```

### Prompt Components

#### 1. Action Directive
- **Text**: "Write ad copy for"
- **Purpose**: Clear instruction for content generation
- **Effect**: Focuses output on advertising content

#### 2. Title Integration
- **Source**: Website `<title>` tag
- **Processing**: Direct insertion without modification
- **Example**: "Best Coffee Shop in Downtown"

#### 3. Context Connector
- **Text**: "using the following description:"
- **Purpose**: Links title to additional context
- **Effect**: Provides coherent instruction flow

#### 4. Description Integration
- **Source**: Website `<meta name="description">` content
- **Processing**: Direct insertion without modification
- **Example**: "Premium coffee, fresh pastries, and cozy atmosphere"

### Prompt Examples

#### Example 1: E-commerce Site
```
Input:
- Title: "Premium Wireless Headphones - AudioTech"
- Description: "High-quality wireless headphones with noise cancellation"

Prompt:
"Write ad copy for Premium Wireless Headphones - AudioTech using the following description: High-quality wireless headphones with noise cancellation"

Expected Output:
"Experience superior sound quality with AudioTech's premium wireless headphones. Advanced noise cancellation technology blocks out distractions while delivering crystal-clear audio. Perfect for music lovers, professionals, and anyone seeking exceptional audio performance."
```

#### Example 2: Service Business
```
Input:
- Title: "Professional Web Design Services - CreativeStudio"
- Description: "Custom website design and development for small businesses"

Prompt:
"Write ad copy for Professional Web Design Services - CreativeStudio using the following description: Custom website design and development for small businesses"

Expected Output:
"Transform your business with CreativeStudio's professional web design services. We create custom websites that capture your brand's essence and drive results. Specialized in small business solutions that combine stunning design with powerful functionality."
```

### Prompt Optimization Strategies

#### Current Approach: Simple and Direct
- **Advantages**: Clear, consistent results
- **Limitations**: Limited customization for different industries

#### Potential Improvements
1. **Industry-Specific Prompts**:
   ```php
   $industryPrompts = [
       'ecommerce' => 'Write compelling product ad copy for',
       'service' => 'Create professional service advertising for',
       'restaurant' => 'Generate appetizing restaurant marketing copy for'
   ];
   ```

2. **Tone Specification**:
   ```php
   $prompt = "Write {$tone} ad copy for {$title} using the following description: {$description}";
   // Where $tone could be: professional, casual, urgent, luxury, etc.
   ```

3. **Length Control**:
   ```php
   $prompt = "Write a {$length} ad copy for {$title}...";
   // Where $length could be: brief, detailed, comprehensive
   ```

## Platform-Specific Generation

### Overview

After generating base ad copy with OpenAI, the application creates platform-specific variations using rule-based processing:

```php
Base AI Content → Platform Processing → Formatted Ad Copy
```

### Processing Pipeline

1. **Text Cleaning**: Remove HTML tags and extra whitespace
2. **Sentence Extraction**: Split content into individual sentences
3. **Random Selection**: Choose one sentence for platform formatting
4. **Platform Formatting**: Apply platform-specific templates

### Google Ads Generation

#### Function: `generate_google_ad_copy()`

```php
function generate_google_ad_copy($generated_text) {
    // Clean and process text
    $text = strip_tags($generated_text);
    $text = trim($text);
    
    // Extract sentences
    $sentences = preg_split('/(?<=[.?!])\s+/', $text);
    
    // Select random sentence
    $random_sentence = $sentences[array_rand($sentences)];
    
    // Apply Google Ads template
    $google_ad_copy = 'Discover ' . $random_sentence . ' Click Here Now!';
    
    return $google_ad_copy;
}
```

#### Template Structure
- **Prefix**: "Discover " - Creates curiosity and engagement
- **Content**: Random sentence from AI-generated text
- **CTA**: " Click Here Now!" - Direct action-oriented call-to-action

#### Example Transformation
```
Input: "Experience superior sound quality with premium wireless headphones."
Output: "Discover Experience superior sound quality with premium wireless headphones. Click Here Now!"
```

#### Google Ads Best Practices Implemented
- **Action-oriented language**: "Discover" and "Click Here Now"
- **Urgency**: "Now" creates immediate action incentive
- **Clear value proposition**: Maintains original benefit statement

### Facebook Ads Generation

#### Function: `generate_facebook_ad_copy()`

```php
function generate_facebook_ad_copy($generated_text) {
    // Clean and process text
    $text = strip_tags($generated_text);
    $text = trim($text);
    
    // Extract sentences
    $sentences = preg_split('/(?<=[.?!])\s+/', $text);
    
    // Select random sentence
    $random_sentence = $sentences[array_rand($sentences)];
    
    // Apply Facebook Ads template
    $facebook_ad_copy = 'Get ' . $random_sentence . ' Like & Share Now!';
    
    return $facebook_ad_copy;
}
```

#### Template Structure
- **Prefix**: "Get " - Implies acquisition and benefit
- **Content**: Random sentence from AI-generated text
- **CTA**: " Like & Share Now!" - Social engagement focused

#### Example Transformation
```
Input: "Transform your business with professional web design services."
Output: "Get Transform your business with professional web design services. Like & Share Now!"
```

#### Facebook Ads Best Practices Implemented
- **Social engagement**: "Like & Share" encourages interaction
- **Benefit-focused**: "Get" emphasizes user benefit
- **Community aspect**: Leverages Facebook's social nature

### LinkedIn Ads Generation

#### Function: `generate_linkedin_ad_copy()`

```php
function generate_linkedin_ad_copy($generated_text) {
    // Clean and process text
    $text = strip_tags($generated_text);
    $text = trim($text);
    
    // Extract sentences
    $sentences = preg_split('/(?<=[.?!])\s+/', $text);
    
    // Select random sentence
    $random_sentence = $sentences[array_rand($sentences)];
    
    // Apply LinkedIn Ads template
    $linkedin_ad_copy = 'Explore ' . $random_sentence . ' Connect Now!';
    
    return $linkedin_ad_copy;
}
```

#### Template Structure
- **Prefix**: "Explore " - Professional discovery and learning
- **Content**: Random sentence from AI-generated text
- **CTA**: " Connect Now!" - Professional networking focused

#### Example Transformation
```
Input: "Advanced analytics solutions for enterprise businesses."
Output: "Explore Advanced analytics solutions for enterprise businesses. Connect Now!"
```

#### LinkedIn Ads Best Practices Implemented
- **Professional tone**: "Explore" suggests professional development
- **Networking focus**: "Connect" aligns with LinkedIn's purpose
- **Business-oriented**: Maintains professional context

### Platform Comparison

| Platform | Prefix | CTA | Focus | Tone |
|----------|--------|-----|-------|------|
| Google | "Discover" | "Click Here Now!" | Action/Conversion | Direct |
| Facebook | "Get" | "Like & Share Now!" | Social Engagement | Social |
| LinkedIn | "Explore" | "Connect Now!" | Professional Networking | Professional |

## API Functions Reference

### Core Functions

#### `generate_ad_copy($title, $description)`

**Purpose**: Generate base ad copy using OpenAI GPT-3 API

**Parameters**:
- `$title` (string): Website title from `<title>` tag
- `$description` (string): Meta description from website

**Returns**: 
- `string`: AI-generated ad copy text

**Example**:
```php
$title = "Premium Coffee Shop";
$description = "Artisan coffee and fresh pastries daily";
$result = generate_ad_copy($title, $description);
// Returns: "Experience the finest artisan coffee and fresh pastries..."
```

**API Call Details**:
```php
// Internal API configuration
$gpt3 = new GPT3($openai_api_key);
$gpt3->setEngineId('text-davinci-002');
$gpt3->setPrompt('Write ad copy for ' . $title . ' using the following description: ' . $description);
$gpt3->setMaxTokens(200);
$gpt3->setTemperature(0.7);
$gpt3->setTopP(1);
$gpt3->setFrequencyPenalty(0);
$gpt3->setPresencePenalty(0);
$gpt3->setStopSequences(['\n\n']);
```

#### `generate_google_ad_copy($generated_text)`

**Purpose**: Create Google Ads-optimized copy from base AI content

**Parameters**:
- `$generated_text` (string): Base ad copy from OpenAI API

**Returns**:
- `string`: Google Ads formatted copy with "Discover" prefix and "Click Here Now!" CTA

**Processing Steps**:
1. Strip HTML tags: `strip_tags($generated_text)`
2. Trim whitespace: `trim($text)`
3. Split into sentences: `preg_split('/(?<=[.?!])\s+/', $text)`
4. Select random sentence: `$sentences[array_rand($sentences)]`
5. Apply template: `'Discover ' . $sentence . ' Click Here Now!'`

#### `generate_facebook_ad_copy($generated_text)`

**Purpose**: Create Facebook Ads-optimized copy from base AI content

**Parameters**:
- `$generated_text` (string): Base ad copy from OpenAI API

**Returns**:
- `string`: Facebook Ads formatted copy with "Get" prefix and "Like & Share Now!" CTA

**Processing**: Same as Google Ads but with Facebook-specific template

#### `generate_linkedin_ad_copy($generated_text)`

**Purpose**: Create LinkedIn Ads-optimized copy from base AI content

**Parameters**:
- `$generated_text` (string): Base ad copy from OpenAI API

**Returns**:
- `string`: LinkedIn Ads formatted copy with "Explore" prefix and "Connect Now!" CTA

**Processing**: Same as Google Ads but with LinkedIn-specific template

### Utility Functions

#### Text Processing Pipeline

```php
// Common processing steps used across all platform functions
function processTextForPlatform($generated_text) {
    // Step 1: Remove HTML tags
    $text = strip_tags($generated_text);
    
    // Step 2: Trim whitespace
    $text = trim($text);
    
    // Step 3: Split into sentences
    $sentences = preg_split('/(?<=[.?!])\s+/', $text);
    
    // Step 4: Select random sentence
    $random_sentence = $sentences[array_rand($sentences)];
    
    return $random_sentence;
}
```

## Error Handling

### OpenAI API Errors

#### Common Error Types

1. **Authentication Errors (401)**
   ```json
   {
     "error": {
       "message": "Invalid API key provided",
       "type": "invalid_request_error"
     }
   }
   ```

2. **Rate Limiting (429)**
   ```json
   {
     "error": {
       "message": "Rate limit reached",
       "type": "rate_limit_error"
     }
   }
   ```

3. **Quota Exceeded (429)**
   ```json
   {
     "error": {
       "message": "You exceeded your current quota",
       "type": "insufficient_quota"
     }
   }
   ```

4. **Server Errors (500-503)**
   ```json
   {
     "error": {
       "message": "The server had an error processing your request",
       "type": "server_error"
     }
   }
   ```

#### Error Handling Implementation

**Current Implementation**: Basic error handling in application logic

**Recommended Improvements**:
```php
function generate_ad_copy($title, $description) {
    try {
        $openai_api_key = 'YOUR API KEY HERE';
        
        if (empty($openai_api_key) || $openai_api_key === 'YOUR API KEY HERE') {
            throw new Exception('OpenAI API key not configured');
        }
        
        $gpt3 = new GPT3($openai_api_key);
        $gpt3->setEngineId('text-davinci-002');
        $gpt3->setPrompt('Write ad copy for ' . $title . ' using the following description: ' . $description);
        $gpt3->setMaxTokens(200);
        $gpt3->setTemperature(0.7);
        $gpt3->setTopP(1);
        $gpt3->setFrequencyPenalty(0);
        $gpt3->setPresencePenalty(0);
        $gpt3->setStopSequences(['\n\n']);
        
        $response = $gpt3->complete();
        
        if (empty($response)) {
            throw new Exception('Empty response from OpenAI API');
        }
        
        return $response;
        
    } catch (Exception $e) {
        error_log('OpenAI API Error: ' . $e->getMessage());
        
        // Return fallback content
        return "Discover amazing products and services. Learn more today!";
    }
}
```

### Platform Generation Errors

#### Common Issues

1. **Empty Generated Text**
   ```php
   if (empty($generated_text)) {
       return "Discover great products and services. Click Here Now!";
   }
   ```

2. **No Sentences Found**
   ```php
   if (empty($sentences) || count($sentences) === 0) {
       return "Get amazing results with our services. Like & Share Now!";
   }
   ```

3. **Malformed Content**
   ```php
   // Validate sentence structure
   if (strlen($random_sentence) < 10) {
       $random_sentence = "quality products and services";
   }
   ```

## Performance Considerations

### API Response Times

- **Typical Response Time**: 2-5 seconds
- **Factors Affecting Speed**:
  - Token count (max_tokens parameter)
  - API server load
  - Network latency
  - Prompt complexity

### Optimization Strategies

#### 1. Caching Implementation

```php
// Recommended caching approach
function getCachedAdCopy($title, $description) {
    $cache_key = md5($title . $description);
    $cache_file = "cache/adcopy_{$cache_key}.json";
    
    // Check if cached version exists and is recent (1 hour)
    if (file_exists($cache_file) && (time() - filemtime($cache_file)) < 3600) {
        return json_decode(file_get_contents($cache_file), true);
    }
    
    // Generate new content
    $ad_copy = generate_ad_copy($title, $description);
    
    // Cache the result
    file_put_contents($cache_file, json_encode($ad_copy));
    
    return $ad_copy;
}
```

#### 2. Request Batching

For multiple requests, consider batching:
```php
// Future enhancement: batch multiple requests
function generateMultipleAdCopy($requests) {
    // Batch multiple prompts into single API call
    // Process responses and distribute to individual requests
}
```

#### 3. Asynchronous Processing

```php
// Future enhancement: async processing
function generateAdCopyAsync($title, $description, $callback) {
    // Use async HTTP client for non-blocking requests
    // Call callback function when response is ready
}
```

## Cost Management

### Token Usage Analysis

#### Current Configuration Cost Impact

- **Max Tokens**: 200 per request
- **Average Usage**: ~150 tokens per request
- **Cost per Request**: ~$0.003 (based on text-davinci-002 pricing)

#### Cost Optimization Strategies

1. **Reduce Max Tokens**:
   ```php
   // Reduce from 200 to 150 tokens
   $gpt3->setMaxTokens(150); // 25% cost reduction
   ```

2. **Implement Caching**:
   ```php
   // Cache results for 1 hour to avoid duplicate requests
   // Potential 50-80% cost reduction for repeated content
   ```

3. **Use Cheaper Models**:
   ```php
   // Consider text-curie-001 for less critical applications
   $gpt3->setEngineId('text-curie-001'); // ~90% cost reduction
   ```

### Usage Monitoring

```php
// Recommended usage tracking
function trackApiUsage($tokens_used, $cost) {
    $log_entry = [
        'timestamp' => time(),
        'tokens' => $tokens_used,
        'cost' => $cost,
        'endpoint' => 'completions'
    ];
    
    file_put_contents('logs/api_usage.log', json_encode($log_entry) . "\n", FILE_APPEND);
}
```

## Security Implementation

### API Key Protection

#### Current Implementation
```php
$openai_api_key = 'YOUR API KEY HERE'; // Placeholder in code
```

#### Recommended Security Measures

1. **Environment Variables**:
   ```php
   $openai_api_key = $_ENV['OPENAI_API_KEY'] ?? '';
   ```

2. **Configuration File**:
   ```php
   // config.php (excluded from version control)
   return [
       'openai_api_key' => 'sk-actual-key-here'
   ];
   ```

3. **Key Validation**:
   ```php
   function validateApiKey($key) {
       return preg_match('/^sk-[a-zA-Z0-9]{48}$/', $key);
   }
   ```

### Input Sanitization

#### Current Implementation
- URL validation using `filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL)`
- Basic HTML tag stripping in platform functions

#### Recommended Enhancements
```php
function sanitizeInput($input) {
    // Remove potentially dangerous characters
    $input = strip_tags($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    $input = trim($input);
    
    // Limit length to prevent abuse
    $input = substr($input, 0, 500);
    
    return $input;
}
```

### Rate Limiting

```php
// Recommended rate limiting implementation
function checkRateLimit($user_ip) {
    $rate_limit_file = "rate_limits/{$user_ip}.json";
    $current_time = time();
    $rate_limit = 10; // 10 requests per hour
    $time_window = 3600; // 1 hour
    
    if (file_exists($rate_limit_file)) {
        $data = json_decode(file_get_contents($rate_limit_file), true);
        
        // Clean old entries
        $data['requests'] = array_filter($data['requests'], function($timestamp) use ($current_time, $time_window) {
            return ($current_time - $timestamp) < $time_window;
        });
        
        // Check if rate limit exceeded
        if (count($data['requests']) >= $rate_limit) {
            return false;
        }
    } else {
        $data = ['requests' => []];
    }
    
    // Add current request
    $data['requests'][] = $current_time;
    file_put_contents($rate_limit_file, json_encode($data));
    
    return true;
}
```

## Troubleshooting

### Common Issues and Solutions

#### Issue 1: Empty or Invalid API Responses

**Symptoms**:
- Blank ad copy generated
- PHP errors related to OpenAI API
- Timeout errors

**Debugging Steps**:
```php
// Add debugging to generate_ad_copy function
function generate_ad_copy($title, $description) {
    error_log("API Request - Title: {$title}, Description: {$description}");
    
    try {
        $response = $gpt3->complete();
        error_log("API Response: " . print_r($response, true));
        return $response;
    } catch (Exception $e) {
        error_log("API Error: " . $e->getMessage());
        throw $e;
    }
}
```

**Solutions**:
1. Verify API key is valid and has credits
2. Check network connectivity to OpenAI servers
3. Implement fallback content for API failures
4. Add request timeout handling

#### Issue 2: Platform-Specific Generation Failures

**Symptoms**:
- Malformed ad copy output
- PHP warnings about array operations
- Inconsistent sentence extraction

**Debugging Steps**:
```php
function generate_google_ad_copy($generated_text) {
    error_log("Input text: " . $generated_text);
    
    $text = strip_tags($generated_text);
    error_log("After strip_tags: " . $text);
    
    $sentences = preg_split('/(?<=[.?!])\s+/', $text);
    error_log("Sentences found: " . count($sentences));
    error_log("Sentences: " . print_r($sentences, true));
    
    // Continue with processing...
}
```

**Solutions**:
1. Add input validation for empty or malformed text
2. Implement fallback sentences for edge cases
3. Improve sentence splitting regex for different text formats
4. Add length validation for generated sentences

#### Issue 3: Performance Issues

**Symptoms**:
- Slow page loading
- Timeout errors
- High server resource usage

**Solutions**:
1. Implement caching for API responses
2. Add request timeout limits
3. Use asynchronous processing for multiple requests
4. Monitor and optimize API usage patterns

### Debugging Tools

#### API Response Logging
```php
function logApiResponse($request, $response, $execution_time) {
    $log_data = [
        'timestamp' => date('Y-m-d H:i:s'),
        'request' => $request,
        'response' => $response,
        'execution_time' => $execution_time,
        'memory_usage' => memory_get_usage(true)
    ];
    
    file_put_contents('logs/api_debug.log', json_encode($log_data) . "\n", FILE_APPEND);
}
```

#### Performance Monitoring
```php
function monitorPerformance($function_name, $start_time) {
    $end_time = microtime(true);
    $execution_time = ($end_time - $start_time) * 1000; // Convert to milliseconds
    
    error_log("Performance: {$function_name} took {$execution_time}ms");
    
    if ($execution_time > 5000) { // Log slow requests (>5 seconds)
        error_log("SLOW REQUEST: {$function_name} took {$execution_time}ms");
    }
}
```

---

This API reference provides comprehensive documentation for developers working with or extending the AdCopy-Generator's OpenAI integration. For additional support, refer to the [README.md](README.md), [SETUP.md](SETUP.md), and [CONTRIBUTING.md](CONTRIBUTING.md) files.
