# AdCopy-Generator

A PHP-based web application that automatically generates targeted ad copy for Google Ads, Facebook Ads, and LinkedIn Ads using OpenAI's GPT-3 API. Simply provide a website URL, and the application will extract relevant content and create platform-specific ad copy tailored for each advertising platform.

## Features

- **Multi-Platform Support**: Generate ad copy for Google Ads, Facebook Ads, and LinkedIn Ads
- **AI-Powered Content Generation**: Uses OpenAI's GPT-3 (text-davinci-002) for intelligent ad copy creation
- **Website Content Extraction**: Automatically extracts title and meta description from target websites
- **Platform-Specific Optimization**: Creates unique ad copy variations with platform-appropriate calls-to-action
- **Simple Web Interface**: Easy-to-use HTML form for URL input and platform selection
- **Instant Results**: Real-time ad copy generation and display

## Technical Requirements

- **PHP**: Version 7.2 or higher
- **Web Server**: Apache, Nginx, or any PHP-compatible web server
- **OpenAI API Key**: Required for GPT-3 integration
- **Internet Connection**: Required for website content extraction and OpenAI API calls
- **PHP Extensions**: 
  - `curl` (for API requests)
  - `dom` (for HTML parsing)
  - `json` (for API response handling)

## Installation

### Quick Setup

1. **Clone the repository**:
   ```bash
   git clone https://github.com/your-username/AdCopy-Generator.git
   cd AdCopy-Generator
   ```

2. **Configure your web server** to serve the project directory

3. **Set up OpenAI API key** (see Configuration section below)

4. **Access the application** through your web browser

### Detailed Installation

For detailed installation instructions including web server configuration, see [SETUP.md](SETUP.md).

## Configuration

### OpenAI API Key Setup

1. **Get an OpenAI API Key**:
   - Visit [OpenAI's website](https://openai.com/api/)
   - Create an account or sign in
   - Navigate to API Keys section
   - Generate a new API key

2. **Configure the API Key**:
   - Open `openai.php`
   - Replace `'YOUR API KEY HERE'` with your actual OpenAI API key:
   ```php
   $openai_api_key = 'sk-your-actual-api-key-here';
   ```

3. **Security Note**: Never commit your actual API key to version control. Consider using environment variables or a separate configuration file.

## Usage

### Basic Usage

1. **Access the Application**: Open `index.html` in your web browser
2. **Enter Website URL**: Provide the URL of the website you want to create ads for
3. **Select Ad Platforms**: Choose one or more platforms (Google, Facebook, LinkedIn)
4. **Generate Ad Copy**: Click "Generate Ad Copy" to create your ads
5. **Review Results**: View the generated ad copy for each selected platform

### Example Workflow

1. Enter URL: `https://example-business.com`
2. Select: Google Ads ✓, Facebook Ads ✓
3. Click "Generate Ad Copy"
4. Results:
   - **Generated Text**: AI-generated base content from website analysis
   - **Google Ads Copy**: "Discover [key message] Click Here Now!"
   - **Facebook Ads Copy**: "Get [key message] Like & Share Now!"

## File Structure

```
AdCopy-Generator/
├── index.html              # Main web interface
├── generate_ad_copy.php    # Core processing script
├── display_ad_copy.php     # Results display template
├── openai.php              # OpenAI API integration
├── simple_html_dom.php     # HTML parsing library
├── README.md               # Project documentation
└── LICENSE                 # GPL v3 license
```

### File Descriptions

- **`index.html`**: User interface with form for URL input and platform selection
- **`generate_ad_copy.php`**: Main processing script that handles form submission, extracts website content, and coordinates ad copy generation
- **`display_ad_copy.php`**: HTML template for displaying generated ad copy results
- **`openai.php`**: Contains OpenAI API integration functions and platform-specific ad copy generation logic
- **`simple_html_dom.php`**: Third-party HTML parsing library for extracting website metadata

## How It Works

1. **Content Extraction**: The application uses Simple HTML DOM Parser to extract the title and meta description from the provided website URL
2. **AI Generation**: Extracted content is sent to OpenAI's GPT-3 API with a structured prompt to generate base ad copy
3. **Platform Optimization**: The base content is processed to create platform-specific variations:
   - **Google Ads**: "Discover [content] Click Here Now!"
   - **Facebook Ads**: "Get [content] Like & Share Now!"
   - **LinkedIn Ads**: "Explore [content] Connect Now!"
4. **Results Display**: All generated ad copy is presented in an organized format

## API Configuration

The application uses the following OpenAI GPT-3 parameters:

- **Engine**: `text-davinci-002`
- **Max Tokens**: 200
- **Temperature**: 0.7 (balanced creativity)
- **Top P**: 1.0
- **Frequency Penalty**: 0
- **Presence Penalty**: 0
- **Stop Sequences**: `['\n\n']`

## Troubleshooting

### Common Issues

**"Invalid URL" Error**
- Ensure the URL includes the protocol (http:// or https://)
- Verify the URL is accessible and valid

**"Unable to retrieve website content" Error**
- Check if the target website is accessible
- Verify your server can make outbound HTTP requests
- Some websites may block automated requests

**OpenAI API Errors**
- Verify your API key is correctly configured
- Check your OpenAI account has sufficient credits
- Ensure your API key has the necessary permissions

**No Ad Copy Generated**
- Verify at least one platform checkbox is selected
- Check that the website has extractable title/description content
- Review PHP error logs for detailed error information

### Debug Mode

To enable debugging, check your PHP error logs:
```bash
tail -f /var/log/php/error.log
```

### Performance Issues

- Large websites may take longer to process
- Consider implementing caching for frequently accessed URLs
- Monitor OpenAI API usage to avoid rate limits

## Security Considerations

- **API Key Protection**: Never expose your OpenAI API key in client-side code or version control
- **Input Validation**: The application validates URLs, but additional sanitization may be needed for production use
- **Rate Limiting**: Consider implementing rate limiting to prevent API abuse
- **HTTPS**: Use HTTPS in production to protect API communications

## Contributing

We welcome contributions! Please see [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines on how to contribute to this project.

## API Reference

For detailed information about the OpenAI integration and API usage, see [API_REFERENCE.md](API_REFERENCE.md).

## License

This project is licensed under the GNU General Public License v3.0 - see the [LICENSE](LICENSE) file for details.

## Support

If you encounter issues or have questions:

1. Check the troubleshooting section above
2. Review the [SETUP.md](SETUP.md) for detailed configuration instructions
3. Open an issue on GitHub with detailed information about your problem

## Changelog

### Version 1.0.0
- Initial release
- Multi-platform ad copy generation
- OpenAI GPT-3 integration
- Web-based interface

