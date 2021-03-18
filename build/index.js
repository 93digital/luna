/**
 * This is temp functionality to test out the cookie stuff
 */

/* eslint-disable */
var config = {
  apiKey: '3ef55800140119bcb4f3f57b5bf20420eee94f15',
  product: 'COMMUNITY',
  necessaryCookies: ['PHPSESSID', 'ee_cookie_test'],
  initialState: 'open',
  optionalCookies: [
    {
      name: 'analytics',
      label: 'Analytics',
      description: '',
      cookies: [],
      onAccept : function(){},
      onRevoke: function(){}
    },{
      name: 'marketing',
      label: 'Marketing',
      description: '',
      cookies: [],
      onAccept : function(){},
      onRevoke: function(){}
    },{
      name: 'preferences',
      label: 'Preferences',
      description: '',
      cookies: [],
      onAccept : function(){},
      onRevoke: function(){}
    }
  ],
  position: 'RIGHT',
  theme: 'DARK'
};

CookieControl.load( config );
