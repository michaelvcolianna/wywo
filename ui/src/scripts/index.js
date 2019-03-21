// index.js
// Kicks off any/all sitewide JS and modular JS components
// Note, in this build, jQuery is globally available — as $, jQuery, or even window.jQuery — via WebPack aliasing & ProvidePlugin
'use strict';

/*
    NOTE: Webpack is configured to automatically try to resolve imported files in the following directories:
    * `node_modules/`
    * `ui/src/scripts/modules/`
    * `ui/src/scripts/vendor/`
    * `ui/src/scripts/models/`
*/

// Custom Modules
import Togglenotes from 'togglenotes.js';

( function () {

    Togglenotes.init();

}() );
