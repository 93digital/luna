# Luna cookie control

[Civic Cookie Control](https://www.civicuk.com/cookie-control/documentation) has been integrated into the theme with the aim of simplifying and standardising the way we integrate cookie consent notices and functionality into the sites we build.

While the set up of cookie consent should be far more straightforward than it has been previously, a small amount of development work is still required when integrating third party scripts into a site. This may be updated over time to allow control of this completely via the CMS, but for now we will see how it works with the current set up.

## Global Options

All customisable options for the cookie notifier are accessible via **Global Options > General > Civic Cookie Control**.

### Civic license key

The License key needs to be generated on a site by site basis via [this link](https://www.civicuk.com/cookie-control/download). A license key only works for a single domain so will need to be updated prior to moving the site to WP Engine and go live. Adding the license key to the relevant field allows access to other fields in the Civic Options group.

### Civic product type

There is also the option to set the product type which will have been chosen when generating the license key. This is set to the **Community** (free!) version by default in Global Options and the basic cookie control functionality baked in the theme can work with that.

More information on the 2 other product types, **Pro** and **Multisite**, are available within the Civic documentation. Most of the **Pro** and **Multisite** features just add more functionality and styling options (although we've managed to replicate some of those styling options sith custom CSS and lots of `!important` declarations!). **Multisite** is obviously required when developing a WordPress Multisite, although this has yet to be tested within the development team.

### Google Analytics ID

The only third-party script which can be integrated without any coding is Google Analytics. The relevant config file in the theme (which is covered in more detail further down) contains the typical GA code snippet and injects the GA ID into it, if it has been set.

### Civic Options

This contains all the options for the popup itself, allowing customisation of all the content within it. Most of these are self explanatory but there are a few that contain pointers to give more details how the field data is used, as it may not be initially apparent.

Many of these fields will be populated with some default content to help speed up the set up of the cookie control. These defaults are baked into a Local ACF JSON file in the theme.

*Please note that updating the **Privacy policy date** will cause all user's consent to be removed and the cookie notifier to pop up for all users again, so only change this if absolutely necessary.*

## Adding custom scripts

This is the area which requires some custom development.

Obviously the main point of cookie control is to stop these third-party marketing and tracking scripts from dumping cookies on the user's browser without their consent. These third-party script snippets need to be added to the custom config file so it comes under the control of Civic.

The config file, `js/src/cookie-control.js` contains a `config` object which is where all customisation of the cookie control is added. The first part of this file grabs all the localised data set in Global Options.

Adding scripts must be done within the `config.optionalCookies[].onAccept()` function. You'll notice this also is where the default Google Analytics snippet is. All custom script snippets should be added below this.

Ideally we should also be adding the list of the cookies which these scripts set in the browser to the `cookies` array set at the top of the config file. At this point I'm not entirely sure how the cookie control works if this is ignored and whether it still works correctly, so ideally the cookies that are set should be added just to be safe.

### Script categorisation

Civic does offer the ability to add multiple cookie categories to cookie control, e.g. functional, analytical and marketing are typical categories that are often seen. These categories themselves are easy enough to add to the `config.optionalCookies` array.

The reason they have been omitted and there is only one default category baked into the theme is due to Google Tag Manager. GTM throws a spanner into the works as it can house all third party scripts away from the site and cookie control and then just the GTM script is embedded on the site. This obviously creates an issue around categorisation as the GTM snippet can only be added in one place, under one category.

From having a brief look, there are ways in which developers can categorise scripts added to GTM using special GTM JavaScript code, but on the face of it it looks like a bit of a bastard to work with. I would happily be proved wrong though!

So ideally, we only use a single category which then give the user just the option to consent to all or no cookies. I mean who really chooses to allow some cookies and not others. Like really really... The vast majority of people just accept or reject!

### Other options

While the cookie control integration offers a number of useful options via Global Options, occasionally a client may have certain cookie consent configuration requirements. In this instance you will need to edit the `config` object to add custom configuration in order to meet the client's needs. Civic's documentation is pretty good and complete (linked at the top of this document) and should provide you with everything you need.

## Under the hood

The `Luna_Base` class automatically includes the latest version of the remote Civic Cookie Control JavaScript file, if the relevant fields have been set in Global Options.

There is custom base styling already included in the theme that styles the popup's layout and sets a default monotone colour scheme. This provides a basic 'out of the box' structure for the pop up but can be updated if required.

### Theme PHP

The field data set in Global Options is handled in `Luna_Base_Global_Options` and uses the custom `luna_localize_script` and `luna_enqueue_script` filter hooks to localise the Global Options data and include the required theme JS.

### Theme JavaScript

In order to use Civic Cookie Control and special config variable must be created and passed to `CookieControl.load()`. The `CookieControl` JavaScript object is declared in the remote Civic script which is enqueued as a dependency of the main script file in `Luna_Base`.

The config variable declaration and call to `CookieControl.load()` is done in `js/src/cookie-control.js`. This file is collated into the main theme JavaScript file, `build/index.js`.

### Theme CSS

The CSS use to customise the cookie consent popup is found in `sass/components/_cookie-control.scss`. By default the popup should be docked to the right-hand side of the screen (which is the only option of the free version), however this CSS forces the element to be centred in the screen as a popup which is usually a premium feature :D!

Any customisation of the popup to fit in with the branding and designs of the site should be done here.
