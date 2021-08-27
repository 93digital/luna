/**
 * The Civic config file.
 * All scripts which are required to be controlled by the cookie consent notice must be added here.
 * @see https://www.civicuk.com/cookie-control/documentation
 */
(() => {
  if (!luna.hasOwnProperty("civic")) {
    // A license key is required for Civic to work.
    return;
  }
  const civic = luna.civic;

  // Declare some config objects (and defaults) which we will be adding custom data to.
  let cookies = [];
  let text = {
    notifyTitle: false,
  };
  let statement = {};
  let optionalCookies = {
    label: "Marketing",
    name: "marketing",
    description:
      "We use marketing cookies to help us improve the relevancy of marketing campaigns and to track the results.",
  };
  // This is a custom button appended to the bottom of the last optional cookie object.
  let saveButtonText = "Save Cookie Preferences and Close";

  // Add GA cookies if a GA ID has been added to Global Options.
  if (civic.googleAnalytics) {
    cookies = ["_ga", "_ga_" + civic.googleAnalytics, "_gid"];
  }

  // Set the options pulled from Global options.
  if (civic.options) {
    if (civic.options.title) {
      // The main popup title.
      text.title = civic.options.title;
    }
    if (civic.options.intro) {
      // The popup intro, just below the title.
      text.intro = civic.options.intro;
    }
    if (civic.options.privacy_policy_description) {
      // The privacy policy description, this sits just below the intro.
      statement.description = civic.options.privacy_policy_description;
    }
    if (civic.options.privacy_policy_link) {
      // Privacy policy link. This sits inline with above description.
      statement.name =
        "<u>" + civic.options.privacy_policy_link.title + "</u>.";
      statement.url = civic.options.privacy_policy_link.url;
    }
    if (civic.options.privacy_policy_date) {
      // The privacy policy date. This is required to show the link.
      statement.updated = civic.options.privacy_policy_date;
    }
    if (civic.options.accept_button_text) {
      // The accept recommended settings button text.
      text.acceptSettings = civic.options.accept_button_text;
    }
    if (civic.options.necessary_cookies_title) {
      // Title for necessary cookie section.
      text.necessaryTitle = civic.options.necessary_cookies_title;
    }
    if (civic.options.necessary_cookies_description) {
      // Description for necessary cookie section.
      text.necessaryDescription = civic.options.necessary_cookies_description;
    }
    if (civic.options.optional_cookies_title) {
      // The optional cookies title.
      optionalCookies.label = civic.options.optional_cookies_title;
      optionalCookies.name = string_to_slug(
        civic.options.optional_cookies_title
      );
    }
    if (civic.options.optional_cookies_description) {
      // The optional cookies description.
      optionalCookies.description = civic.options.optional_cookies_description;
    }
    if (civic.options.save_preferences_button_text) {
      // Save preferences button text.
      saveButtonText = civic.options.save_preferences_button_text;
    }
  }

  // Lastly append the save button to the optional cookies description.
  optionalCookies.description +=
    '<br><br><button id="ccc-save-and-close" class="ccc-notify-button ccc-tabbable" onclick="CookieControl.hide();">' +
    saveButtonText +
    "</button>";

  /* eslint-disable */
  const config = {
    apiKey: civic.licenseKey,
    product: civic.productType,
    necessaryCookies: ["PHPSESSID", "wordpress_test_cookie", "__cfduid"],
    initialState: "open",
    consentCookieExpiry: 90, // Default
    logConsent: true,
    rejectButton: false,
    notifyDismissButton: false,
    notifyOnce: false,
    setInnerHTML: true,
    statement: statement,
    text: text,
    branding: {
      removeIcon: true,
      removeAbout: true,
    },
    optionalCookies: [
      {
        name: optionalCookies.name,
        label: optionalCookies.label,
        description: optionalCookies.description,
        cookies: cookies,
        onAccept: function () {
          // console.log( 'cookies accepted' );
          if (civic.googleAnalytics) {
            // Google Analytics.
            (function (i, s, o, g, r, a, m) {
              i["GoogleAnalyticsObject"] = r;
              (i[r] =
                i[r] ||
                function () {
                  (i[r].q = i[r].q || []).push(arguments);
                }),
                (i[r].l = 1 * new Date());
              (a = s.createElement(o)), (m = s.getElementsByTagName(o)[0]);
              a.async = 1;
              a.src = g;
              m.parentNode.insertBefore(a, m);
            })(
              window,
              document,
              "script",
              "https://www.google-analytics.com/analytics.js",
              "ga"
            );

            ga("create", civic.googleAnalytics, "auto");
            ga("send", "pageview");
          }

          // Add more here.
        },
        onRevoke: function () {
          // console.log( 'cookies rejected' );
        },
      },
    ],
    position: "RIGHT",
    theme: "DARK",
  };

  CookieControl.load(config);

  function string_to_slug(str) {
    str = str.replace(/^\s+|\s+$/g, ""); // trim
    str = str.toLowerCase();

    // remove accents, swap ñ for n, etc
    var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
    var to = "aaaaeeeeiiiioooouuuunc------";
    for (var i = 0, l = from.length; i < l; i++) {
      str = str.replace(new RegExp(from.charAt(i), "g"), to.charAt(i));
    }

    str = str
      .replace(/[^a-z0-9 -]/g, "") // remove invalid chars
      .replace(/\s+/g, "-") // collapse whitespace and replace by -
      .replace(/-+/g, "-"); // collapse dashes

    return str;
  }
})();
