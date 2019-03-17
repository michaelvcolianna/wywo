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

// Global Utilities/Libraries: 
// NOTE: Truly ubiquitous Libraries *should* be added to Webpack's awareness via it's `resolve.alias`
import 'foo.js'; // REMEMBER: Webpack knows to look in `vendor/` to resolve this filepath

// Custom Modules
import Bar from 'bar.js'; // REMEMBER: Webpack knows to look in `modules/` to resolve this filepath

( function () {

    // do stuff…

    // like kicking off a module…
    Bar.init();

    // or using a Library…
    Foo();

}() );