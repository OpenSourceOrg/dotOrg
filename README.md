# open-source-initiative

This repo is for open-source-initiative, powered by WordPress.

## Project Structure

- Git is initialized in the `wp-content` directory
- The main `themes`, `plugins`, and `mu-plugins` directories are ignored
- Project-relevant themes and plugins are added as exceptions to the `.gitignore` file so they will be tracked

If the PHPCS checks are taking too long because of a plugin/code that we aren't responsible for, feel free to include that plugin folder in the files `.vipgoci_lint_skip_folders` and `.vipgoci_phpcs_skip_folders`. Please use this feature sparingly. We view the checks as a safety mechanism that can save sites from serious errors.

If `mu-plugins` are needed for a project, create a `mu-plugins` directory and include a `mu-autoloader.php` file within that mu-plugins directory (`/mu-plugins/mu-autoloader.php`). In that `mu-autoloader.php` file, add the following contents:

```
<?php
/**
 * This file is for loading all mu-plugins within subfolders
 * where the PHP file name is exactly like the directory name + .php.
 *
 * Example: /mu-tools/mu-tools.php
 */

$dirs = glob(dirname(__FILE__) . '/*' , GLOB_ONLYDIR);

foreach($dirs as $dir) {
    if(file_exists($dir . DIRECTORY_SEPARATOR . basename($dir) . ".php")) {
        require($dir . DIRECTORY_SEPARATOR . basename($dir) . ".php");
    }
}
```

## GitHub Workflow

1. Make your fix in a new branch.
1. Merge your `fix/` branch into the `develop` branch and test on the staging site.
1. If all looks good, make a PR and merge from your fix branch into `trunk`.

NOTE: While PRs are not required to be manually reviewed, we are happy to review any PR for any reason. Please ping us in Slack with a link to the PR.

## Deployment

- Pushing to the `trunk` branch will automatically deploy to the production site.
- Pushing to the `develop` branch will automatically deploy to the stating site.

#### Developer Checklist v1.0
- [x] Updated PHPCS Action to version from Project Scaffold
- [x] Updated .phpcs.xml in the project to include Team51-Configs .phpcs.xml
- [x] Added PHP Syntax Check Action from Project Scaffold
- [x] Updated Pull Request Template and Issue Templates from Project Scaffold
- [x] Added/updated .editorconfig to match Project Scaffold
- [x] Updated .gitignore with extended ignorelist from Project Scaffold
- [x] Updated/Verified the Project Readme and added this Checklist
- [ ] Added Engines to Package.json with Node and NPM working versions
