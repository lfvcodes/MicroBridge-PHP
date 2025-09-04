# Contributing to MicroBridge-PHP

Thank you for considering contributing to MicroBridge-PHP! This document provides guidelines for contributing to the project.

## 🚀 Getting Started

### Prerequisites

- PHP 7.1 or higher
- Composer
- Git

### Setting Up Development Environment

1. Fork the repository on GitHub
2. Clone your fork locally:
   ```bash
   git clone https://github.com/your-username/microbridge-php.git
   cd microbridge-php
   ```

3. Install dependencies:
   ```bash
   composer install
   ```

4. Run tests to ensure everything works:
   ```bash
   composer test
   ```

## 🧪 Testing

### Running Tests

```bash
# Run all tests
composer test

# Run tests with coverage
composer test -- --coverage-html coverage-html
```

### Writing Tests

- All new features must include tests
- Tests should be placed in the `tests/` directory
- Follow the existing test structure and naming conventions
- Use descriptive test method names that explain what is being tested

Example test:
```php
public function testMethodDoesExpectedBehavior()
{
    // Arrange
    $bridge = new MicroBridge('GET');
    
    // Act
    $result = $bridge->request('./test-endpoint.php');
    
    // Assert
    $this->assertArrayHasKey('status', $result);
}
```

## 📝 Code Style

This project follows PSR-12 coding standards.

### Checking Code Style

```bash
# Check code style
composer cs-check

# Automatically fix code style issues
composer cs-fix
```

### Code Style Guidelines

- Use 4 spaces for indentation
- Follow PSR-12 naming conventions
- Add PHPDoc comments for all public methods
- Keep methods focused and single-purpose
- Use meaningful variable and method names

## 🐛 Bug Reports

When filing bug reports, please include:

1. **Clear description** of the issue
2. **Steps to reproduce** the problem
3. **Expected behavior** vs actual behavior
4. **PHP version** and environment details
5. **Code examples** demonstrating the issue

## ✨ Feature Requests

For new features:

1. **Check existing issues** to avoid duplicates
2. **Describe the use case** and why it's needed
3. **Provide examples** of how the feature would be used
4. **Consider backward compatibility** implications

## 🔄 Pull Request Process

1. **Create a feature branch** from `main`:
   ```bash
   git checkout -b feature/your-feature-name
   ```

2. **Make your changes** following the code style guidelines

3. **Add or update tests** for your changes

4. **Run the test suite** to ensure nothing is broken:
   ```bash
   composer test
   composer cs-check
   ```

5. **Update documentation** if needed

6. **Commit your changes** with clear, descriptive messages:
   ```bash
   git commit -m "Add feature: description of what was added"
   ```

7. **Push to your fork** and create a pull request

### Pull Request Guidelines

- **One feature per PR** - keep changes focused
- **Clear title and description** explaining the changes
- **Reference related issues** using `#issue-number`
- **Include tests** for new functionality
- **Update documentation** as needed

## 📋 Code Review Process

All submissions require review. We look for:

- **Code quality** and adherence to standards
- **Test coverage** for new features
- **Documentation** completeness
- **Backward compatibility** considerations
- **Performance** implications

## 🏷️ Versioning

This project uses [Semantic Versioning](https://semver.org/):

- **MAJOR** version for incompatible API changes
- **MINOR** version for backward-compatible functionality additions
- **PATCH** version for backward-compatible bug fixes

## 📄 License

By contributing, you agree that your contributions will be licensed under the MIT License.

## 🤝 Code of Conduct

- Be respectful and inclusive
- Focus on constructive feedback
- Help others learn and grow
- Maintain a positive environment

## 💬 Getting Help

If you need help:

1. Check the [documentation](README.md)
2. Look through [existing issues](https://github.com/lfvcodes/microbridge-php/issues)
3. Create a new issue with your question

Thank you for contributing to MicroBridge-PHP! 🎉