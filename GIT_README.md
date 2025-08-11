# Git Setup for TutorStarter Child Theme

This directory is now a Git repository that tracks only your child theme files, excluding all WordPress core files and unnecessary system files.

## What's Tracked

Your child theme includes:
- `style.css` - Main stylesheet with custom CSS modifications
- `functions.php` - Theme functions and enqueuing
- `header.php` - Custom header template
- `views/partials/header/` - Custom header partial templates
- `inc/Traits/Header_Components.php` - Custom header components trait
- `screenshot.png` - Theme preview image
- `README.md` - Theme documentation

## Git Commands

### Check Status
```bash
git status
```

### View Changes
```bash
git diff
```

### Add Changes
```bash
git add .                    # Add all changes
git add filename.php         # Add specific file
```

### Commit Changes
```bash
git commit -m "Description of changes"
```

### View History
```bash
git log --oneline
```

### Create a New Branch
```bash
git checkout -b feature-name
```

### Switch Between Branches
```bash
git checkout branch-name
git checkout master          # Return to main branch
```

### Merge Changes
```bash
git checkout master
git merge feature-name
```

## Best Practices

1. **Commit frequently** - Make small, focused commits
2. **Use descriptive commit messages** - Explain what and why, not how
3. **Test before committing** - Ensure your changes work
4. **Keep commits atomic** - Each commit should represent one logical change

## Excluded Files

The `.gitignore` file excludes:
- OS generated files (`.DS_Store`, `Thumbs.db`)
- IDE/Editor files (`.vscode/`, `.idea/`)
- Temporary and backup files
- Node.js and Composer dependencies
- Environment files

## Benefits of This Setup

- **Clean history** - Only tracks your custom code
- **Easy deployment** - Can clone just the theme to other sites
- **Version control** - Track changes and rollback if needed
- **Collaboration** - Share your theme with others
- **Backup** - Your customizations are safely versioned

## Next Steps

1. Update the Git configuration with your actual name and email
2. Consider setting up a remote repository (GitHub, GitLab, etc.)
3. Create branches for different features or experiments
4. Document any major changes in commit messages
