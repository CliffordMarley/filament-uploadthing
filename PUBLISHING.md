# Publishing to Packagist Guide

## Prerequisites

1. GitHub account
2. Packagist account (sign up at https://packagist.org)
3. Git installed locally

## Step 1: Prepare Your Package

### 1.1 Update composer.json

Replace `cliffthecoder` with your actual vendor name (usually your GitHub username):

```json
{
    "name": "cliffthecoder/filament-uploadthing",
    "description": "UploadThing integration for FilamentPHP",
    "keywords": ["filament", "laravel", "uploadthing", "upload"],
    "license": "MIT",
    "authors": [
        {
            "name": "Clifford Mwale",
            "email": "cliffmwale97@gmail.com
        }
    ],
    "require": {
        "php": "^8.1",
        "filament/filament": "^4.0",
        "illuminate/contracts": "^11.0"
    },
    "autoload": {
        "psr-4": {
            "YourName\\FilamentUploadThing\\": "src/"
        }
    }
}
```

### 1.2 Update Namespace in All Files

Replace `cliffthecoder` with your actual namespace in:
- src/FilamentUploadThingServiceProvider.php
- src/Forms/Components/UploadThingFileUpload.php
- All other PHP files

Example: Change `cliffthecoder\\FilamentUploadThing` to `JohnDoe\\FilamentUploadThing`

### 1.3 Add License File

Create LICENSE file (MIT):

```
MIT License

Copyright (c) 2024 Your Name

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

## Step 2: Build JavaScript Assets

```bash
# Install dependencies
npm install

# Build the JavaScript
npm run build

# This creates resources/dist/filament-uploadthing.js
```

**Important:** Commit the built `resources/dist/filament-uploadthing.js` file to Git. Users need this file.

## Step 3: Create GitHub Repository

### 3.1 Initialize Git

```bash
git init
git add .
git commit -m "Initial commit"
```

### 3.2 Create GitHub Repo

1. Go to https://github.com/new
2. Name it `filament-uploadthing` (or your chosen name)
3. Don't initialize with README (you already have one)
4. Create repository

### 3.3 Push to GitHub

```bash
git remote add origin https://github.com/yourusername/filament-uploadthing.git
git branch -M main
git push -u origin main
```

## Step 4: Tag Your Release

```bash
# Create a version tag
git tag -a v1.0.0 -m "First release"

# Push the tag
git push origin v1.0.0
```

## Step 5: Submit to Packagist

1. Go to https://packagist.org/packages/submit
2. Enter your GitHub repo URL: `https://github.com/yourusername/filament-uploadthing`
3. Click "Check"
4. Click "Submit"

## Step 6: Set Up Auto-Updates (Recommended)

### Option A: GitHub Service Hook (Easier)

1. In Packagist, go to your package page
2. Click "Edit"
3. Copy the webhook URL shown
4. Go to your GitHub repo → Settings → Webhooks → Add webhook
5. Paste the Packagist webhook URL
6. Set Content type to `application/json`
7. Click "Add webhook"

### Option B: GitHub Actions (More Control)

Create `.github/workflows/packagist.yml`:

```yaml
name: Update Packagist

on:
  release:
    types: [published]

jobs:
  packagist:
    runs-on: ubuntu-latest
    steps:
      - name: Update Packagist
        run: |
          curl -XPOST -H'content-type:application/json'           'https://packagist.org/api/update-package?username=YOUR_PACKAGIST_USERNAME&apiToken=${{ secrets.PACKAGIST_TOKEN }}'           -d'{"repository":{"url":"https://github.com/yourusername/filament-uploadthing"}}'
```

Add your Packagist API token as a GitHub secret.

## Step 7: Release Updates

When you want to release a new version:

```bash
# Make your changes
git add .
git commit -m "Add new feature"

# Create new version tag
git tag -a v1.1.0 -m "Version 1.1.0"

# Push changes and tag
git push
git push origin v1.1.0
```

Packagist will automatically update (if you set up webhooks).

## Version Numbering (Semantic Versioning)

- **v1.0.0** - Major release (breaking changes)
- **v1.1.0** - Minor release (new features, backward compatible)
- **v1.1.1** - Patch release (bug fixes)

## Troubleshooting

### Package not showing on Packagist
- Check composer.json is valid: `composer validate`
- Ensure you pushed tags: `git push --tags`

### "Could not find package"
- Wait 5-10 minutes after submission
- Clear Composer cache: `composer clear-cache`

### Updates not appearing
- Verify webhook is working in GitHub Settings
- Manually update: Go to package page on Packagist → Click "Update"

## Testing Before Publishing

Test locally first:

```bash
# In another Laravel project
composer config repositories.local path /path/to/your/plugin
composer require cliffthecoder/filament-uploadthing:@dev
```

## Post-Publishing Checklist

✅ Package appears on Packagist
✅ `composer require cliffthecoder/filament-uploadthing` works
✅ README displays correctly
✅ License is visible
✅ Latest version shows correct tag
✅ Download stats are tracking

## Badges for README (Optional)

Add to your README.md:

```markdown
[![Latest Version](https://img.shields.io/packagist/v/cliffthecoder/filament-uploadthing.svg)](https://packagist.org/packages/cliffthecoder/filament-uploadthing)
[![Total Downloads](https://img.shields.io/packagist/dt/cliffthecoder/filament-uploadthing.svg)](https://packagist.org/packages/cliffthecoder/filament-uploadthing)
[![License](https://img.shields.io/packagist/l/cliffthecoder/filament-uploadthing.svg)](https://packagist.org/packages/cliffthecoder/filament-uploadthing)
```

## Need Help?

- Packagist Docs: https://packagist.org/about
- Composer Docs: https://getcomposer.org/doc/
- Filament Plugins: https://filamentphp.com/plugins