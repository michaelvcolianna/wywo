		//	Genius Room: WYWO
		//	Script: Auxiliary JS for jQuery
		//	Revision: 3.0.6

$(document).ready(function(){

//	-----	Autofocus for login page and add a call page.
	$( '#username' ).focus();
	$( '#customer' ).focus();

//	-----	This shows/hides the notes.
	$( '.toggle_text' ).click(function(){

	// Split the ID of the element clicked to get the number.
		var showId = this.id.split( '_' );
		var flipId = showId[2];

	// Show or hide as needed.
		$( '#show_' + flipId ).toggle();
		$( '#hide_' + flipId ).toggle();
		$( '#hidden_' + flipId ).toggle();

	});

//	-DOC-	Checks via AJAX to see if the username/password combo is correct before submitting.
	$( '[value="Log In"]' ).click(function(){

	// Pull the entered values into variables. Makes it easier.
		uName = document.getElementById( 'username' ).value;
		pWord = document.getElementById( 'password' ).value;

	// Checks that both values were entered.
		if( uName && pWord ) {

		// AJAX to the LDAP checker with the username and password. False ASYNC means wait.
			secobj = $.ajax({ url: './ldap.php?u=' + uName + '&p=' +pWord, async: false });

		// If the bind was unsuccessful the AJAX response text is empty. Alert the user.
		// A false return prevents the form from submitting.
			if( secobj.responseText == '' ) {
				alert( 'Login failed - please double check the username and password entered.' );
				return false;
			}

		}

	// Alert the user that they didn't fill it out properly.
	// A false return prevents the form from submitting.
		else {
			alert( 'Not all of the required login information was entered.' );
			return false;
		}

	});

//	-----	Back to the main screen.
	$('[value="Cancel"]').click(function(){ window.location = './'; });

//	-----	Makes sure required fields are filled out but it's not strict at all.
	$('[value="Save"]').click(function(){
		if( document.getElementById( 'customer' ).value != '' && document.getElementById( 'primary' ).value != '' && document.getElementById( 'note' ).value != '' ) { return true; }
		else {
			alert( 'Not all of the required information was filled out.' );
			return false;
		}
	});

//	-----	Same as previous but for notes.
	$('[value="Add Note"]').click(function() {

	// Split the ID of the element clicked to get the number.
		var showId = this.id.split( '_' );
		var noteId = showId[1];

	// Alert the user that they didn't fill it out properly.
	// A false return prevents the form from submitting.
		if( document.getElementById( 'textarea_' + noteId ).value == '' ) {
			alert( 'Nothing was filled out.' );
			return false;
		}

	});

//	-----	Verifies before closing a call.
	$( '.helped' ).click(function(){ return confirm( 'Are you sure you wish to close this call out?' ); });

});

		// Copyright: 2010 by Michael V. Colianna
