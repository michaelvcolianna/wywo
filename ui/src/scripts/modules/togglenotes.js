// modules/togglenotes.js
// Flips display of a particular call's notes

// Global variables
const
    CONSOLE_PREFIX = '[togglenotes.js] ',
    CLASSNAME_FLAG = 'hidden'
    ;

// Elements the module will access
let
    el_toggles = document.querySelectorAll( '.toggle_text' )
    ;

module.exports = {
    init: function () {
        if ( el_toggles.length > 0 )
        {
            el_toggles.forEach( function ( elem, index )
            {
                elem.addEventListener( 'click', function () {
                    var callId = this.id.replace( /\D/g, '' );

                    document.querySelector( '#show' + callId ).classList.toggle( CLASSNAME_FLAG );
                    document.querySelector( '#hide' + callId ).classList.toggle( CLASSNAME_FLAG );
                    document.querySelector( '#hidden' + callId ).classList.toggle( CLASSNAME_FLAG );
                });
            });
        }

        return;
    }
};
