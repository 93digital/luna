# Luna cookie control

[Civic Cookie Control](https://www.civicuk.com/cookie-control/documentation) has been integrated into the theme with the aim of simplifying and standardising the way we integrate cookie consent notices and functionality into the sites we build.

While the set up of cookie consent should be far more straightforward than it has been previously, a small amount of development work is still required when integrating third party scripts into a site. This may be updated over time to allow control of this completely via the CMS, but for now we will see how it works with the current set up.

## Setting up cookie control

### Global Options

#### Civic license key

The License key (which is required for all sites) need to be added to **Global Options > General > Civic Cookie Control**, adding this allows access to other fields in the Civic Options group.

#### Civic product type

There is also the option to select the product type. This is set to the **Community** (free!) version by default and the basic cookie control functionality can work with that. More information on the 2 other product types, **Pro** and **Multisite**, are available within the Civic documentation. Many of these just add more functionality and styling options (although we've managed to replicate some of those styling options sith custom CSS and lots of `!important` declarations :D).

#### Google Analytics ID

The only third-party script which can be integrated without any coding is Google Analytics. The relevant config file in the theme (which is covered in more detail further down) contains the GA script template code and injects the GA ID in should it be set.

#### Civic Options

This contains all the options for the popup itself, allowing customisation of all the content within it. Most of these are self explanatory and there are a few that contain pointers where more knowledge may be required as to what the field is for.

Many of these fields will be populated with some default content to help speed up the set up of the cookie control.

*Please note that updating the **Privacy policy date** will cause all user's consent to be removed and the cookie notifier to pop up for all users again, so only change this if absolutely necessary.*

### Adding scripts

This is the area which requires some development. Obviously the point of this feature is to stop these third-party marketing and tracking scripts from dumping cookies on the user's browser without there consent. So we need to add these JavaScript snippets to the relevant place in the custom config file.

The config file, `js/src/cookie-control.js` contains a `config` object which is where all customisation of the cookie control is added. The first part of this file grabs all the localised data set in Global Options.

Adding scripts must be done within the `config.optionalCookies[].onAccept()` function. You'll notice this is where the default Google Analytics script is. All scripts should be added below this.

Ideally we should also be adding the list of the cookies which these scripts set to the `cookies` array set at the top of the config file. At this point I'm not entirely sure how the cookie control works if this is ignored, so ideally the cookies that are set should be added.

#### Script categorisation

Civic does offer the ability to add multiple cookie categories to cookie control, e.g. functional, analytical and marketing are typical categories that are often seen. These categories themselves are easy enough to add to the `config.optionalCookies` array.

The reason they have been omitted here and there is only one default category (marketing) is due to Google Tag Manager. GTM throws a spanner into the works as it can house all of these third party scripts away from the site and then just the GTM script needs to be added. This obviously creates an issue around categorisation. From having a brief look, there are ways in which developers can categorise using special GTM code, but on the face of it it looks like a bit of a bastard to work with. I would happily be proved wrong though!

So ideally, we only use a single category which then give the user just the option to consent to all or no cookies. I mean who really chooses to allow some and not others. Like really really...

#### Other options

While cookie control integration offers a number of the most useful options via Global Options, occasionally a client may have certain requirements around their cookie consent configuration. In this instance you will need to edit the `config` object to fit the needs of the client. Civic's documentation is pretty good and complete (linked at the top of this document) and should provide you with everything you need.

## Under the hood

The `Luna_Base` class automatically includes the latest version of the remote Civic Cookie Control JavaScript file if the relevant fields have been set in Global Options.

There is some custom base styling already included in the theme that styles the popup using the default site font and monotone colour scheme.

### Theme PHP

The field data set in Global Options is handled in `Luna_Base_Global_Options` and uses the custom `luna_localize_script` and `luna_enqueue_script` filter hooks to localise the Global Options data and include the required theme JS.

### Theme JavaScript

In order to user Civic Cookie Control and special config variable must be created and passed to `CookieControl.load()`. The `CookieControl` JavaScript object is declared in the remote Civic script enqueued as a dependency of the main script file in `Luna_Base`.

The config variable declaration and call to `CookieControl.load()` is done in `js/src/cookie-control.js`. This file is collated into the main theme JavaScript file, `build/index.js`.

### Theme CSS

The CSS use to customise the cookie consent popup is found in `sass/components/_cookie-control.scss`. By default the popup should be docked to the right-hand side of the screen (which is the only option of the free version), however this CSS forces the element to be centred in the screen as a popup which is usually a premium feature :D!

Any customisation of the popup to fit in with the branding and designs of the site should be done here.
