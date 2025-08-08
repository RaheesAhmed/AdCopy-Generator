# AdCopy-Generator Setup Guide

This guide provides detailed installation and configuration instructions for the AdCopy-Generator application. Follow these steps to set up the application on your web server.

## System Requirements

### PHP Requirements
- **PHP Version**: 7.2 or higher (recommended: PHP 8.0+)
- **Required PHP Extensions**:
  - `curl` - For making HTTP requests to OpenAI API
  - `dom` - For HTML parsing functionality
  - `json` - For handling JSON responses from APIs
  - `libxml` - For XML/HTML processing
  - `mbstring` - For multi-byte string handling
  - `openssl` - For secure HTTPS connections

### Web Server Requirements
- **Apache HTTP Server** 2.4+ with mod_rewrite enabled
- **Nginx** 1.18+ with PHP-FPM
- **IIS** 10.0+ with PHP support
- **Built-in PHP Server** (for development only)

### System Resources
- **Memory**: Minimum 128MB PHP memory limit (recommended: 256MB+)
- **Disk Space**: 50MB free space
- **Network**: Outbound HTTPS access for OpenAI API calls

## Pre-Installation Checklist

Before starting the installation, ensure you have:

- [ ] Web server with PHP 7.2+ installed and configured
- [ ] OpenAI API account and API key
- [ ] Command line access to your server (optional but recommended)
- [ ] Basic knowledge of web server configuration

## Installation Methods

### Method 1: Direct Download and Setup

1. **Download the Application**
   ```bash
   # Clone from repository
   git clone https://github.com/your-username/AdCopy-Generator.git
   cd AdCopy-Generator
   
   # Or download and extract ZIP file
   wget https://github.com/your-username/AdCopy-Generator/archive/main.zip
   unzip main.zip
   cd AdCopy-Generator-main
   ```

2. **Set Proper File Permissions**
   ```bash
   # Set directory permissions
   find . -type d -exec chmod 755 {} \;
   
   # Set file permissions
   find . -type f -exec chmod 644 {} \;
   
   # Ensure web server can read files
   chown -R www-data:www-data . # For Apache/Nginx on Ubuntu/Debian
   # OR
   chown -R apache:apache .     # For Apache on CentOS/RHEL
   ```

### Method 2: Web Server Document Root Setup

1. **Copy Files to Web Root**
   ```bash
   # For Apache (typical locations)
   cp -r AdCopy-Generator/* /var/www/html/adcopy/
   # OR
   cp -r AdCopy-Generator/* /var/www/html/
   
   # For Nginx (typical locations)
   cp -r AdCopy-Generator/* /usr/share/nginx/html/adcopy/
   ```

2. **Configure Virtual Host (Optional but Recommended)**
   
   **Apache Virtual Host Example:**
   ```apache
   <VirtualHost *:80>
       ServerName adcopy.yourdomain.com
       DocumentRoot /var/www/html/adcopy
       
       <Directory /var/www/html/adcopy>
           AllowOverride All
           Require all granted
       </Directory>
       
       ErrorLog ${APACHE_LOG_DIR}/adcopy_error.log
       CustomLog ${APACHE_LOG_DIR}/adcopy_access.log combined
   </VirtualHost>
   ```
   
   **Nginx Server Block Example:**
   ```nginx
   server {
       listen 80;
       server_name adcopy.yourdomain.com;
       root /usr/share/nginx/html/adcopy;
       index index.html index.php;
       
       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
           fastcgi_index index.php;
           fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
           include fastcgi_params;
       }
       
       location / {
           try_files $uri $uri/ =404;
       }
   }
   ```

## OpenAI API Configuration

### Step 1: Obtain OpenAI API Key

1. **Create OpenAI Account**
   - Visit [https://openai.com/api/](https://openai.com/api/)
   - Sign up for a new account or log in to existing account
   - Complete account verification if required

2. **Generate API Key**
   - Navigate to the API Keys section in your dashboard
   - Click "Create new secret key"
   - Copy the generated API key (starts with `sk-`)
   - **Important**: Store this key securely - it won't be shown again

3. **Set Up Billing (Required)**
   - Add a payment method to your OpenAI account
   - Set up usage limits to control costs
   - Monitor your usage regularly

### Step 2: Configure API Key in Application

**Method 1: Direct Configuration (Quick Setup)**
1. Open `openai.php` in a text editor
2. Find the line: `$openai_api_key = 'YOUR API KEY HERE';`
3. Replace `'YOUR API KEY HERE'` with your actual API key:
   ```php
   $openai_api_key = 'sk-your-actual-api-key-here';
   ```

**Method 2: Environment Variable (Recommended for Production)**
1. Create a `.env` file in the project root:
   ```bash
   echo "OPENAI_API_KEY=sk-your-actual-api-key-here" > .env
   ```

2. Modify `openai.php` to use environment variable:
   ```php
   // Load environment variables (add this at the top)
   if (file_exists('.env')) {
       $env = parse_ini_file('.env');
       foreach ($env as $key => $value) {
           $_ENV[$key] = $value;
       }
   }
   
   // Use environment variable
   $openai_api_key = $_ENV['OPENAI_API_KEY'] ?? 'YOUR API KEY HERE';
   ```

3. Secure the `.env` file:
   ```bash
   chmod 600 .env
   ```

## Web Server Configuration

### Apache Configuration

1. **Enable Required Modules**
   ```bash
   sudo a2enmod rewrite
   sudo a2enmod php8.0  # Adjust version as needed
   sudo systemctl restart apache2
   ```

2. **Create .htaccess File (Optional)**
   ```apache
   # Create .htaccess in project root
   RewriteEngine On
   
   # Security headers
   Header always set X-Content-Type-Options nosniff
   Header always set X-Frame-Options DENY
   Header always set X-XSS-Protection "1; mode=block"
   
   # Hide sensitive files
   <Files ".env">
       Order allow,deny
       Deny from all
   </Files>
   
   <Files "*.md">
       Order allow,deny
       Deny from all
   </Files>
   ```

### Nginx Configuration

1. **PHP-FPM Configuration**
   ```bash
   # Ensure PHP-FPM is running
   sudo systemctl start php8.0-fpm
   sudo systemctl enable php8.0-fpm
   ```

2. **Security Configuration**
   ```nginx
   # Add to server block
   location ~ /\. {
       deny all;
       access_log off;
       log_not_found off;
   }
   
   location ~* \.(md|env)$ {
       deny all;
       access_log off;
       log_not_found off;
   }
   ```

## PHP Configuration

### Required PHP Settings

Edit your `php.ini` file and ensure these settings:

```ini
# Memory and execution limits
memory_limit = 256M
max_execution_time = 60
max_input_time = 60

# File upload settings (if needed for future features)
upload_max_filesize = 10M
post_max_size = 10M

# Error reporting (adjust for production)
display_errors = Off          # Set to On for development
log_errors = On
error_log = /var/log/php/error.log

# Security settings
allow_url_fopen = On          # Required for OpenAI API calls
allow_url_include = Off
expose_php = Off

# Extension requirements
extension=curl
extension=dom
extension=json
extension=libxml
extension=mbstring
extension=openssl
```

### Restart Web Server
```bash
# Apache
sudo systemctl restart apache2

# Nginx
sudo systemctl restart nginx
sudo systemctl restart php8.0-fpm

# PHP built-in server (development)
php -S localhost:8000
```

## Testing the Installation

### Step 1: Basic Functionality Test

1. **Access the Application**
   - Open your web browser
   - Navigate to your application URL (e.g., `http://localhost/adcopy/` or `http://adcopy.yourdomain.com`)
   - You should see the "Ad Copy Generator" form

2. **Test Form Submission**
   - Enter a valid website URL (e.g., `https://example.com`)
   - Select one or more ad platforms
   - Click "Generate Ad Copy"

### Step 2: API Integration Test

1. **Check OpenAI API Connection**
   - Submit the form with a real website URL
   - If configured correctly, you should see generated ad copy
   - Check error logs if you encounter issues:
     ```bash
     tail -f /var/log/apache2/error.log  # Apache
     tail -f /var/log/nginx/error.log    # Nginx
     tail -f /var/log/php/error.log      # PHP errors
     ```

### Step 3: Verify File Permissions

```bash
# Check if web server can read files
ls -la /path/to/adcopy/

# Test PHP execution
php -l generate_ad_copy.php
php -l openai.php
php -l display_ad_copy.php
```

## Troubleshooting Common Issues

### Issue: "Invalid URL" Error
**Cause**: URL validation failing
**Solution**: 
- Ensure URL includes protocol (http:// or https://)
- Check if `filter_var()` function is available
- Verify PHP `filter` extension is loaded

### Issue: "Unable to retrieve website content" Error
**Cause**: Cannot fetch website content
**Solutions**:
- Check if `allow_url_fopen` is enabled in PHP
- Verify outbound HTTP/HTTPS connections are allowed
- Test with different websites
- Check firewall settings

### Issue: OpenAI API Errors
**Common Causes and Solutions**:

1. **Invalid API Key**
   ```
   Error: Unauthorized (401)
   Solution: Verify API key is correct and active
   ```

2. **Insufficient Credits**
   ```
   Error: Quota exceeded
   Solution: Add billing information to OpenAI account
   ```

3. **Rate Limiting**
   ```
   Error: Too many requests (429)
   Solution: Implement request throttling or upgrade API plan
   ```

### Issue: PHP Extension Missing
**Check Extensions**:
```bash
php -m | grep -E "(curl|dom|json|mbstring|openssl)"
```

**Install Missing Extensions (Ubuntu/Debian)**:
```bash
sudo apt-get install php-curl php-dom php-json php-mbstring php-xml
```

**Install Missing Extensions (CentOS/RHEL)**:
```bash
sudo yum install php-curl php-dom php-json php-mbstring php-xml
```

### Issue: File Permission Errors
**Fix Permissions**:
```bash
# Set correct ownership
sudo chown -R www-data:www-data /path/to/adcopy/

# Set correct permissions
sudo chmod -R 755 /path/to/adcopy/
sudo chmod 644 /path/to/adcopy/*.php
sudo chmod 644 /path/to/adcopy/*.html
```

## Security Considerations

### Production Deployment Security

1. **Secure API Key Storage**
   - Never commit API keys to version control
   - Use environment variables or secure configuration files
   - Restrict file permissions on configuration files

2. **Web Server Security**
   - Hide sensitive files (.env, .md files)
   - Implement HTTPS in production
   - Use security headers
   - Regular security updates

3. **Input Validation**
   - The application validates URLs, but consider additional sanitization
   - Implement rate limiting to prevent abuse
   - Monitor API usage and costs

4. **File Security**
   ```bash
   # Secure sensitive files
   chmod 600 .env
   chmod 644 *.php
   chmod 644 *.html
   
   # Hide from web access
   echo "deny from all" > .htaccess  # In sensitive directories
   ```

## Performance Optimization

### Caching Recommendations
- Consider implementing caching for frequently requested URLs
- Use Redis or Memcached for session storage if scaling
- Implement OpenAI API response caching to reduce costs

### Monitoring
- Monitor OpenAI API usage and costs
- Set up error logging and monitoring
- Track application performance metrics

## Development Environment Setup

### Local Development with PHP Built-in Server
```bash
# Navigate to project directory
cd /path/to/AdCopy-Generator

# Start PHP development server
php -S localhost:8000

# Access application
open http://localhost:8000
```

### Using Docker (Optional)
```dockerfile
# Create Dockerfile
FROM php:8.0-apache

# Install required extensions
RUN docker-php-ext-install curl dom json mbstring

# Copy application files
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html/
```

## Next Steps

After successful installation:

1. **Review Security Settings** - Ensure production security measures are in place
2. **Set Up Monitoring** - Monitor API usage and application performance
3. **Backup Strategy** - Implement regular backups of configuration
4. **Documentation** - Review [README.md](README.md) for usage instructions
5. **Contributing** - See [CONTRIBUTING.md](CONTRIBUTING.md) for development guidelines

## Support

If you encounter issues during setup:

1. Check the troubleshooting section above
2. Review PHP and web server error logs
3. Verify all requirements are met
4. Test with minimal configuration first
5. Open an issue on GitHub with detailed error information

For additional help, include the following information:
- Operating system and version
- PHP version (`php -v`)
- Web server type and version
- Error messages from logs
- Steps to reproduce the issue
