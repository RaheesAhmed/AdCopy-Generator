<?php

/**
 * Simple HTML DOM Parser library.
 *
 * This library is based on the PHP Simple HTML DOM Parser library by S.C. Chen.
 * https://sourceforge.net/projects/simplehtmldom/
 *
 * This library has been modified to work with PHP 7.2+ and to fix several issues
 * with the original library.
 */

if (!defined('DEFAULT_TARGET_CHARSET')) {
    define('DEFAULT_TARGET_CHARSET', 'UTF-8');
}

if (!defined('DEFAULT_BR_TEXT')) {
    define('DEFAULT_BR_TEXT', "\r\n");
}

if (!defined('DEFAULT_SPAN_TEXT')) {
    define('DEFAULT_SPAN_TEXT', ' ');
}

if (!defined('MAX_FILE_SIZE')) {
    define('MAX_FILE_SIZE', 600000);
}

class simple_html_dom
{
    /** @var string $root The root HTML node of the document. */
    public $root = null;

    /** @var bool $preserve_whitespace Whether to preserve whitespace in text nodes. */
    public $preserve_whitespace = false;

    /** @var bool $lowercase Whether to convert all tags to lowercase. */
    public $lowercase = true;

    /** @var bool $force_tags_closed Whether to automatically close tags that are not closed in the HTML. */
    public $force_tags_closed = true;

    /** @var int $default_br_text The default text to use for <br> tags. */
    public $default_br_text = "\r\n";

    /** @var int $default_span_text The default text to use for <span> tags. */
    public $default_span_text = " ";

    /** @var string $default_target_charset The default target character set for the HTML. */
    public $default_target_charset = 'UTF-8';

    /** @var string $default_source_charset The default source character set for the HTML. */
    public $default_source_charset = 'ISO-8859-1';

    /** @var array $token_blank The list of tags that should have a blank line added before them. */
    public $token_blank = array("html", "head", "body", "title", "meta", "link");

    /** @var array $token_self_closing The list of tags that should be self-closing. */
    public $token_self_closing = array("img", "br", "input");

    /** @var array $token_doctype The list of doctypes that can appear in an HTML document. */
    public $token_doctype = array("html", "strict", "transitional", "frameset", "1.1", "basic", "mobile");

    /** @var array $callback_params The parameters to pass to callbacks. */
    protected $_callback_params = array();

    // Methods
}


function file_get_html($url, $use_include_path = false, $context = null, $offset = 0, $maxLen = 0, $lowercase = true, $forceTagsClosed = true, $target_charset = DEFAULT_TARGET_CHARSET, $stripRN = true, $defaultBRText = DEFAULT_BR_TEXT, $defaultSpanText = DEFAULT_SPAN_TEXT)
{
    // Load Simple HTML DOM Parser library
    require_once('simple_html_dom.php');
    
    // Retrieve webpage content
    $html = file_get_contents($url, $use_include_path, $context, $offset, $maxLen);
    
    // Parse HTML content
    $dom = new simple_html_dom();
    $dom->load($html, $lowercase, $forceTagsClosed, $target_charset, $stripRN, $defaultBRText, $defaultSpanText);
    
    return $dom;
}

