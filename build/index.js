/**
 * The Civic config file.
 * All scripts which are required to be controlled by the cookie consent notice must be added here.
 * @see https://www.civicuk.com/cookie-control/documentation
 */
(() => {
  if ( ! luna['civic']['licenseKey'] ) {
    return;
  }

  // Set the cookies here.
  let cookies = [];

  // Add GA cookies if a GA ID has been added to Global Options.
  if ( luna['civic']['googleAnalytics'] ) {
    cookies = [ '_ga', '_ga_' + luna['civic']['googleAnalytics'], '_gid' ];
  }

  /* eslint-disable */
  var config = {
    apiKey: luna['civic']['licenseKey'],
    product: luna['civic']['productType'],
    necessaryCookies: ['PHPSESSID', 'wordpress_test_cookie', '__cfduid'],
    initialState: 'open',
    consentCookieExpiry: 90, // Default
    logConsent: true,
    rejectButton: false,
    layout: 'popup',
    notifyDismissButton: false,
    notifyOnce: false,
    setInnerHTML: true,
    branding: {
      removeIcon: true,
      removeAbout: true,
    },
    statement: {
      description: 'This site uses cookies to improve your browsing experience, perform analytics and research, and conduct advertising. To change your preferences, see our ',
      name: '<u>Privacy & Cookie Policy</u>.',
      url: 'https://93digital.co.uk/privacy-cookie-policy/',
      updated: '30/10/2020',
    },
    text: {
      acceptSettings: 'Accept recommended settings',
      notifyTitle: false,
      notifyDescription: 'This site uses cookies to improve your browsing experience, perform analytics and research, and conduct advertising. Clicking "Accept" indicates you agree to the use of cookies on your device.',
    },
    optionalCookies: [
      {
        name: 'marketing',
        label: 'Marketing',
        description: 'We use marketing cookies to help us improve the relevancy of marketing campaigns and to track the results.<br><br><button id="ccc-save-and-close" class="ccc-notify-button ccc-tabbable" onclick="CookieControl.hide();">Save Cookie Preferences and Close</button>',
        cookies: cookies,
        onAccept : function(){
          console.log( 'cookies accepted' );
          if ( luna['civic']['googleAnalytics'] ) {
            // Google Analytics.
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', luna['civic']['googleAnalytics'], 'auto');
            ga('send', 'pageview');
          }

          // Add more here.
        },
        onRevoke: function(){
          console.log( 'cookies rejected' );
        }
      }
    ],
    position: 'RIGHT',
    theme: 'DARK'
  };

  CookieControl.load( config );
})();
