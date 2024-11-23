# Table of Contents

1. [Installation and Configuration](#installation-and-configuration)
2. [Known issues](#known-issues)
3. [Parent theme](#parent-theme)
4. [Compiling static assets](#compiling-assets)
5. [Troubleshooting Common Issues](#troubleshooting-issues)

## [Installation and Configuration](#installation-and-configuration)

* Search/Ask for a `<NPM_TOKEN>` and `<COMPOSER_TOKEN>` which should be provided for each project individually
* Create a `.npmrc.dev` file at the root of the project and populate it 
```sh 
    //registry.npmjs.org/:_authToken=<NPM_TOKEN>
```
* Run the following command to build images:
```sh
    docker-compose build --build-arg COMPOSER_USERNAME=token --build-arg COMPOSER_TOKEN=<COMPOSER_TOKEN>
```
* Once the images are built, run the services with:
```sh
    docker-compose up -d
```

## [Known issues](#known-issues)

* On Windows environment, line endings need to be set to LF instead of CRLF in `install-composer.sh` file

> If you encounter some error during this process, please report it to your project manager.

## [Parent Theme Docs](#parent-theme)
The MeanPug Legal PI Parent Theme is intended as a way to:

* Standardize the content model across Personal Injury Law Firm clients
* Abstract common/core blocks into a shared location

Reference the [Parent Theme Documentation](https://github.com/MeanPug/meanpug-legal-pi-parent-theme) for information on the content types, core blocks, and
JS libraries that ship, as well as general information on our guidelines for Wordpress Development and other DX topics.


## [Compiling Static Assets](#compiling-assets)
All our assets (js/css) are compiled inside a docker static container, so when you run `docker-compose up -d`, 
all the changes you make are immediately compiled. Please check webpack configuration for entry points.

## [Core Plugins](#core-plugins)
Until we move to a more mature package dependency manager for the development pipeline (like composer), this section will 
serve as a guide of the plugins we use for common tasks in development/prod.

* Menus - [Max Mega Menu](https://wordpress.org/plugins/megamenu/)
* Forms - [Gravity Forms](https://docs.gravityforms.com/installation/)
* SEO - [Yoast](https://yoast.com/)

## [Troubleshooting Common Issues](#troubleshooting-issues)
### Table of Contents (LWP_ToC) block is not showing up with shortcode usage
For some reason, when an excerpt isn't set for the current post/page, the LWP_ToC shortcode fails to render a ToC. It
works just fine in widget form, only in shortcode form does it fail. Additionally, disabling Yoast SEO fixes the issue.
Short answer: Include an excerpt on all posts/pages that require a ToC.
