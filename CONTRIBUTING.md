# Contributing to AdCopy-Generator

Thank you for your interest in contributing to AdCopy-Generator! We welcome contributions from the community and are excited to work with you to improve this AI-powered ad copy generation tool.

## Table of Contents

- [Code of Conduct](#code-of-conduct)
- [Getting Started](#getting-started)
- [How to Contribute](#how-to-contribute)
- [Development Workflow](#development-workflow)
- [Coding Standards](#coding-standards)
- [Testing Guidelines](#testing-guidelines)
- [Documentation Standards](#documentation-standards)
- [Submitting Changes](#submitting-changes)
- [Issue Guidelines](#issue-guidelines)
- [Feature Requests](#feature-requests)
- [Security Issues](#security-issues)
- [Community and Support](#community-and-support)

## Code of Conduct

By participating in this project, you agree to abide by our Code of Conduct:

- **Be respectful**: Treat all community members with respect and kindness
- **Be inclusive**: Welcome newcomers and help them get started
- **Be constructive**: Provide helpful feedback and suggestions
- **Be professional**: Maintain a professional tone in all communications
- **Be patient**: Remember that everyone has different skill levels and backgrounds

## Getting Started

### Prerequisites

Before contributing, ensure you have:

- PHP 7.2 or higher installed
- A web server (Apache, Nginx, or PHP built-in server)
- Git for version control
- A text editor or IDE
- Basic knowledge of PHP, HTML, and web development
- An OpenAI API account for testing (optional but recommended)

### Setting Up Your Development Environment

1. **Fork the Repository**
   ```bash
   # Fork the repository on GitHub, then clone your fork
   git clone https://github.com/YOUR-USERNAME/AdCopy-Generator.git
   cd AdCopy-Generator
   ```

2. **Set Up Remote Upstream**
   ```bash
   git remote add upstream https://github.com/ORIGINAL-OWNER/AdCopy-Generator.git
   git remote -v
   ```

3. **Install and Configure**
   - Follow the [SETUP.md](SETUP.md) guide for detailed installation instructions
   - Set up your OpenAI API key for testing (use a test key, not production)
   - Verify the application works correctly

4. **Create a Development Branch**
   ```bash
   git checkout -b feature/your-feature-name
   # OR
   git checkout -b fix/issue-description
   ```

## How to Contribute

### Types of Contributions We Welcome

- **Bug Fixes**: Fix issues and improve stability
- **Feature Enhancements**: Add new functionality or improve existing features
- **Documentation**: Improve documentation, add examples, or fix typos
- **Code Quality**: Refactor code, improve performance, or enhance security
- **Testing**: Add tests, improve test coverage, or fix test issues
- **UI/UX Improvements**: Enhance the user interface and user experience
- **Platform Support**: Add support for new advertising platforms
- **Internationalization**: Add support for multiple languages

### Areas Where We Need Help

- **Additional Ad Platforms**: Support for Twitter Ads, Pinterest Ads, TikTok Ads
- **Advanced Prompt Engineering**: Improve AI prompt templates for better results
- **Caching System**: Implement caching to reduce API costs and improve performance
- **User Interface**: Create a more modern and responsive web interface
- **API Rate Limiting**: Implement proper rate limiting and error handling
- **Configuration Management**: Better configuration file handling and validation
- **Testing Suite**: Comprehensive unit and integration tests
- **Security Enhancements**: Security audits and improvements

## Development Workflow

### 1. Planning Your Contribution

Before starting work:

- **Check existing issues** to see if your idea is already being discussed
- **Open an issue** to discuss your proposed changes (for significant features)
- **Get feedback** from maintainers before investing significant time
- **Break down large features** into smaller, manageable pull requests

### 2. Development Process

1. **Keep your fork updated**:
   ```bash
   git fetch upstream
   git checkout main
   git merge upstream/main
   git push origin main
   ```

2. **Create a feature branch**:
   ```bash
   git checkout -b feature/descriptive-name
   ```

3. **Make your changes** following our coding standards

4. **Test your changes** thoroughly

5. **Commit your changes** with clear, descriptive messages

6. **Push to your fork**:
   ```bash
   git push origin feature/descriptive-name
   ```

7. **Create a Pull Request** with a clear description

### 3. Code Review Process

- All contributions require code review before merging
- Maintainers will review your code for quality, security, and compatibility
- Be responsive to feedback and make requested changes promptly
- Engage in constructive discussion about suggested improvements

## Coding Standards

### PHP Coding Standards

We follow PSR-12 coding standards with some project-specific guidelines:

#### File Structure and Naming
```php
<?php

/**
 * File description and purpose
 * 
 * Detailed explanation of what this file does
 * 
 * @author Your Name
 * @version 1.0.0
 * @requires PHP 7.2+
 */

// File content here
```

#### Function Documentation
```php
/**
 * Brief function description
 * 
 * Detailed explanation of what the function does,
 * including any important behavior or side effects.
 * 
 * @param string $parameter Description of parameter
 * @param array $options Optional parameters with defaults
 * @return string Description of return value
 * @throws Exception When and why exceptions are thrown
 * 
 * @example
 * $result = functionName('input', ['option' => 'value']);
 * // Returns: expected output format
 */
function functionName($parameter, $options = []) {
    // Function implementation
}
```

#### Code Style Guidelines

1. **Indentation**: Use 4 spaces (no tabs)
2. **Line Length**: Maximum 120 characters per line
3. **Braces**: Opening braces on the same line for functions and classes
4. **Variable Naming**: Use camelCase for variables, snake_case for array keys
5. **Constants**: Use UPPER_CASE for constants
6. **Comments**: Use meaningful comments, avoid obvious comments

#### Example Code Style
```php
<?php

class AdCopyGenerator 
{
    private $apiKey;
    private $defaultOptions = [
        'max_tokens' => 200,
        'temperature' => 0.7
    ];

    public function __construct($apiKey) 
    {
        $this->apiKey = $apiKey;
    }

    public function generateCopy($title, $description, $options = []) 
    {
        $mergedOptions = array_merge($this->defaultOptions, $options);
        
        if (empty($title) || empty($description)) {
            throw new InvalidArgumentException('Title and description are required');
        }

        return $this->callOpenAiApi($title, $description, $mergedOptions);
    }
}
```

### HTML/CSS Standards

1. **HTML5**: Use semantic HTML5 elements
2. **Accessibility**: Include proper ARIA labels and alt text
3. **Responsive Design**: Ensure mobile compatibility
4. **Clean Markup**: Properly nested and indented HTML

### Security Standards

1. **Input Validation**: Always validate and sanitize user input
2. **Output Escaping**: Use `htmlspecialchars()` for output
3. **SQL Injection Prevention**: Use prepared statements (if database is added)
4. **XSS Prevention**: Escape all user-generated content
5. **API Key Security**: Never expose API keys in client-side code

## Testing Guidelines

### Manual Testing Requirements

Before submitting a pull request, test:

1. **Basic Functionality**:
   - Form submission with valid URLs
   - Ad copy generation for all platforms
   - Error handling for invalid inputs

2. **Edge Cases**:
   - Empty form submissions
   - Invalid URLs
   - Websites that don't respond
   - API key errors

3. **Cross-Browser Testing**:
   - Chrome, Firefox, Safari, Edge
   - Mobile browsers

4. **Different Environments**:
   - Different PHP versions (if possible)
   - Different web servers

### Automated Testing (Future)

We're working on implementing automated testing. When available:

- Write unit tests for new functions
- Ensure all tests pass before submitting
- Add integration tests for API interactions
- Include performance tests for optimization changes

### Testing Checklist

- [ ] All existing functionality still works
- [ ] New features work as expected
- [ ] Error handling works correctly
- [ ] No PHP errors or warnings
- [ ] Cross-browser compatibility verified
- [ ] Mobile responsiveness maintained
- [ ] Security measures not compromised

## Documentation Standards

### Code Documentation

- **PHPDoc Comments**: All functions must have proper PHPDoc comments
- **Inline Comments**: Explain complex logic and business rules
- **File Headers**: Include file purpose and requirements
- **Examples**: Provide usage examples for complex functions

### User Documentation

When adding features that affect users:

- Update [README.md](README.md) if needed
- Update [SETUP.md](SETUP.md) for configuration changes
- Add examples and screenshots when helpful
- Update troubleshooting sections

### API Documentation

For API-related changes:

- Update [API_REFERENCE.md](API_REFERENCE.md)
- Document new parameters and responses
- Include example requests and responses
- Explain any breaking changes

## Submitting Changes

### Pull Request Guidelines

1. **Title**: Use a clear, descriptive title
   - Good: "Add support for Twitter Ads platform"
   - Bad: "Update files"

2. **Description**: Include:
   - What changes were made and why
   - How to test the changes
   - Any breaking changes
   - Screenshots (if UI changes)
   - Related issue numbers

3. **Size**: Keep pull requests focused and reasonably sized
   - Prefer multiple small PRs over one large PR
   - Each PR should address a single concern

### Pull Request Template

```markdown
## Description
Brief description of changes made.

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Documentation update
- [ ] Code refactoring
- [ ] Performance improvement
- [ ] Security enhancement

## Testing
- [ ] Manual testing completed
- [ ] Cross-browser testing done
- [ ] Edge cases tested
- [ ] No regressions found

## Screenshots (if applicable)
Add screenshots to help explain your changes.

## Related Issues
Fixes #123
Related to #456

## Additional Notes
Any additional information or context.
```

### Commit Message Guidelines

Use clear, descriptive commit messages:

```bash
# Good commit messages
git commit -m "Add support for Twitter Ads platform"
git commit -m "Fix URL validation for international domains"
git commit -m "Improve error handling in OpenAI API calls"
git commit -m "Update documentation for new configuration options"

# Bad commit messages
git commit -m "Update code"
git commit -m "Fix bug"
git commit -m "Changes"
```

## Issue Guidelines

### Reporting Bugs

When reporting bugs, include:

1. **Environment Information**:
   - PHP version
   - Web server type and version
   - Operating system
   - Browser (if relevant)

2. **Steps to Reproduce**:
   - Detailed steps to reproduce the issue
   - Expected behavior
   - Actual behavior

3. **Error Messages**:
   - Complete error messages
   - Relevant log entries
   - Screenshots if helpful

4. **Additional Context**:
   - When did the issue start?
   - Does it happen consistently?
   - Any recent changes?

### Bug Report Template

```markdown
**Bug Description**
A clear description of what the bug is.

**Environment**
- PHP Version: [e.g., 8.0.2]
- Web Server: [e.g., Apache 2.4.41]
- OS: [e.g., Ubuntu 20.04]
- Browser: [e.g., Chrome 91.0]

**Steps to Reproduce**
1. Go to '...'
2. Click on '....'
3. Enter '....'
4. See error

**Expected Behavior**
What you expected to happen.

**Actual Behavior**
What actually happened.

**Screenshots**
If applicable, add screenshots.

**Error Messages**
```
Paste any error messages here
```

**Additional Context**
Any other context about the problem.
```

## Feature Requests

### Suggesting New Features

When suggesting features:

1. **Use Case**: Explain the problem you're trying to solve
2. **Proposed Solution**: Describe your suggested approach
3. **Alternatives**: Consider alternative solutions
4. **Impact**: Estimate the impact on existing users
5. **Implementation**: Consider implementation complexity

### Feature Request Template

```markdown
**Feature Description**
A clear description of the feature you'd like to see.

**Problem/Use Case**
What problem does this solve? What's the use case?

**Proposed Solution**
Describe the solution you'd like to see.

**Alternative Solutions**
Describe alternatives you've considered.

**Additional Context**
Any other context, mockups, or examples.

**Implementation Notes**
Any thoughts on how this might be implemented.
```

## Security Issues

### Reporting Security Vulnerabilities

**Do not report security vulnerabilities through public GitHub issues.**

Instead:

1. **Email**: Send details to [security@project-email.com] (if available)
2. **Private Issue**: Create a private security advisory on GitHub
3. **Include**: Detailed description, steps to reproduce, potential impact
4. **Response**: We'll respond within 48 hours with next steps

### Security Best Practices

When contributing:

- Never commit API keys or sensitive data
- Validate and sanitize all user inputs
- Use parameterized queries for database operations
- Implement proper authentication and authorization
- Follow OWASP security guidelines

## Community and Support

### Getting Help

- **Documentation**: Check [README.md](README.md) and [SETUP.md](SETUP.md) first
- **Issues**: Search existing issues before creating new ones
- **Discussions**: Use GitHub Discussions for questions and ideas
- **Code Review**: Ask for help during the review process

### Communication Guidelines

- **Be respectful**: Treat everyone with kindness and respect
- **Be clear**: Provide clear, detailed information
- **Be patient**: Allow time for responses
- **Be helpful**: Help others when you can

### Recognition

Contributors will be recognized in:

- **README.md**: Contributors section
- **Release Notes**: Major contributions highlighted
- **GitHub**: Contributor statistics and badges

## Development Roadmap

### Short-term Goals (Next 3 months)

- Implement comprehensive testing suite
- Add support for additional ad platforms
- Improve error handling and user feedback
- Enhance security measures
- Create better user interface

### Long-term Goals (6-12 months)

- Multi-language support
- Advanced prompt engineering
- Performance optimization
- API rate limiting and caching
- User authentication system
- Analytics and reporting features

### How to Get Involved

1. **Start Small**: Begin with documentation improvements or small bug fixes
2. **Join Discussions**: Participate in issue discussions and feature planning
3. **Review Code**: Help review pull requests from other contributors
4. **Share Ideas**: Suggest improvements and new features
5. **Spread the Word**: Help promote the project and attract more contributors

## Questions?

If you have questions about contributing:

- **Check the documentation** first
- **Search existing issues** for similar questions
- **Create a new issue** with the "question" label
- **Join our discussions** for general questions

Thank you for contributing to AdCopy-Generator! Your contributions help make this tool better for everyone. 🚀

---

*This contributing guide is a living document. Please suggest improvements by opening an issue or submitting a pull request.*
