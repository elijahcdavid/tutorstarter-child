# TutorStarter Child Theme

This is a child theme for the TutorStarter WordPress theme.

## What is a Child Theme?

A child theme inherits all the functionality, features, and styling of the parent theme (TutorStarter) while allowing you to make customizations without affecting the parent theme. This means your customizations will be preserved when the parent theme is updated.

## Files Included

- **style.css** - Main stylesheet with theme header and custom CSS
- **functions.php** - Custom PHP functions and enqueuing of stylesheets
- **screenshot.png** - Theme preview image
- **README.md** - This documentation file

## How to Use

1. **Activate the Child Theme**: Go to Appearance > Themes in your WordPress admin and activate "TutorStarter Child"

2. **Customize CSS**: Edit the `style.css` file to add your custom styles. The parent theme styles are automatically imported.

3. **Add Custom Functions**: Use the `functions.php` file to add custom PHP functionality.

4. **Override Template Files**: Copy any template file from the parent theme to the child theme directory to override it.

## Customization Examples

### Adding Custom CSS
```css
/* Add your custom styles below the @import line in style.css */
.custom-header {
    background-color: #f0f0f0;
    padding: 20px 0;
}
```

### Adding Custom Functions
```php
// Add to functions.php
function my_custom_function() {
    // Your custom code here
}
add_action('wp_head', 'my_custom_function');
```

### Overriding Template Files
To override a template file (e.g., `header.php`):
1. Copy the file from `wp-content/themes/tutorstarter/` to `wp-content/themes/tutorstarter-child/`
2. Make your modifications to the copied file

## Important Notes

- Always test your changes on a staging site first
- Keep backups of your customizations
- The child theme will automatically inherit all parent theme updates
- You can safely update the parent theme without losing your customizations

## Support

For questions about the parent theme, visit: https://www.themeum.com
For child theme customization help, consult WordPress documentation or your developer.
