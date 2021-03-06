plugin.tx_browser_pi1 {
  frameworks {
    foundation {
      framework {

        # cat=browser foundation - framework - CSS/150/100; type=string;               label= foundation:Path to the foundation.css file. Minimised css is recommended.
        page.includeCSS.foundation  = EXT:browser/Resources/Public/JavaScript/Foundation-5.5.1/css/foundation.min.css
        # cat=browser foundation - framework - CSS/150/101; type=string;               label= normalize:Path to the normalize.css file. Minimised css is recommended.
        page.includeCSS.normalize   = EXT:browser/Resources/Public/JavaScript/Foundation-5.5.1/css/normalize.css
        # cat=browser foundation - framework - CSS/150/102; type=string;               label= browser:Path to the browser.css file for foundation css classes.
        page.includeCSS.browser     = EXT:browser/Resources/Public/Css/Foundation/browser.css

        # cat=browser foundation - framework - Javascript/250/101; type=string;        label= foundation:Path to the foundation.js file.
        page.includeJSFooter.foundation = EXT:browser/Resources/Public/JavaScript/Foundation-5.5.1/js/foundation.min.js
        # cat=browser foundation - framework - Javascript/250/102; type=string;        label= jQuery:Path to the jquery.js file. t3jquery is recommended. If you are using t3jquery, this jquery library isn't needed.
        page.includeJSFooter.jquery     = EXT:browser/Resources/Public/JavaScript/Foundation-5.5.1/js/vendor/jquery.js
        # cat=browser foundation - framework - Javascript/250/103; type=string;        label= modernizr:Path to the modernizr.js file.
        page.includeJS.modernizr        = EXT:browser/Resources/Public/JavaScript/Foundation-5.5.1/js/vendor/modernizr.js
        # cat=browser foundation - framework - Javascript/250/104; type=string;        label= fastclick:Path to the fastclick.js file.
        page.includeJS.fastclick        = EXT:browser/Resources/Public/JavaScript/Foundation-5.5.1/js/vendor/fastclick.js

      }
    }
  }
}