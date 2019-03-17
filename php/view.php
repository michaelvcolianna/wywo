<?php	//	Genius Room: WYWO
		//	Script: Viewing calls
		//	Revision: 3.0.6

#	-----	Account for viewing the types of calls.
if( $_GET['view'] == 'genius' || $_GET['view'] == 'business' || $_GET['view'] == 'manager' ) {
	$search = " WHERE `type`='" . $_GET['view'] . "'";
	$title = ' - Viewing ' . ucfirst( $_GET['view'] ) . ' Calls';
}

#	-DOC-	Pull all current calls for output.
if( mysql_num_rows( $calls_pull = mysql_query( "SELECT * FROM `calls`" . $search . " ORDER BY `id` DESC" ) ) > 0 ) {
	while( $call = mysql_fetch_assoc( $calls_pull ) ) {

	// Start the call, build the left side. Don't bug me about my page buffer.
		$page[] = '		<div class="call ' . $call['status'] . '" id="call_' . $call['id'] . '">';
		$page[] = '			<div class="call_left" id="call_left_' . $call['id'] . '">';
		$page[] = '				<div class="call_name" id="call_name_' . $call['id'] . '">';
		$page[] = '					<span class="name_text" id="name_text_' . $call['id'] . '">' . $call['customer'] . '</span>';
		$page[] = '				</div>';
		$page[] = '				<div class="call_type" id="call_type_' . $call['id'] . '">';
		$page[] = '					<span class="type_text" id="type_text_' . $call['id'] . '">For ' . $call['type'] . ' Team</span>';
		$page[] = '				</div>';

	// Add the repair number if it exists.
		if( $call['repair'] ) {
			$page[] = '				<div class="call_info" id="call_repair_' . $call['id'] . '">';
			$page[] = '					<span class="repair_text" id="repair_text_' . $call['id'] . '"><strong>Repair:</strong> ' . $call['repair'] . '</span>';
			$page[] = '				</div>';
		}

	// Add the primary number.
		$page[] = '				<div class="call_info" id="call_primary_' . $call['id'] . '">';
		$page[] = '					<span class="primary_text" id="primary_text_' . $call['id'] . '"><strong>Phone #1:</strong> ' . phone_text( $call['primary'] ) . '</span>';
		$page[] = '				</div>';

	// Add the secondary number if it exists.
		if( $call['secondary'] ) {
			$page[] = '				<div class="call_info" id="call_secondary_' . $call['id'] . '">';
			$page[] = '					<span class="secondary_text" id="secondary_text_' . $call['id'] . '"><strong>Phone #2:</strong> ' . phone_text( $call['secondary'] ) . '</span>';
			$page[] = '				</div>';
		}

	// Employee who closed the call.
		$employee = mysql_real_escape_string( $_COOKIE['wywo_user'] );
		$password = $_COOKIE['wywo_pass'];

	// Get employee info for ability to close.
		$user = get_ldap( $employee, $password );

	// Add the close link if a WYWO admin and the call is old.
		if( strpos( $user[0]['apple-user-printattribute'][0], 'ALL' ) != FALSE && $call['status'] == 'old' ) {
			$page[] = '				<div class="call_close" id="call_close_' . $call['id'] . '">';
			$page[] = '					<a class="helped" href="./?area=close&id=' . $call['id'] . '" id="link_close_' . $call['id'] . '">Mark as Helped</a>';
			$page[] = '				</div>';
		}

	// Finish the left side.
		$page[] = '			</div>';

	// Pull notes for output.
		$notes_pull = mysql_query( "SELECT * FROM `notes` WHERE `call`='" . $call['id'] . "' ORDER BY `id` DESC" );

	// Get the newest note. (This may be the only note.)
		$newest_note = mysql_fetch_assoc( $notes_pull );

	// Start the right side with the newest note.
		$page[] = '			<div class="call_right" id="call_right_' . $call['id'] . '">';
		$page[] = '				<div class="newest_note" id="newest_note_' . $call['id'] . '">';
		$page[] = '					<div class="note_text" id="newest_text_' . $call['id'] . '">';
		$page[] = '						<span class="text" id="new_text_' . $call['id'] . '">' . str_replace( "\n", '<br />', $newest_note['content'] ) . '</span>';
		$page[] = '					</div>';
		$page[] = '					<div class="note_time" id="newest_time_' . $call['id'] . '">';
		$page[] = '						<span class="time" id="new_time_' . $call['id'] . '">' . date( 'M jS, Y @ g:ia', $newest_note['timestamp'] ) . '</span>';
		$page[] = '					</div>';
		$page[] = '					<div class="note_employee" id="newest_employee_' . $call['id'] . '">';
		$page[] = '						<span class="employee" id="new_employee_' . $call['id'] . '">' . $newest_note['employee'] . '</span>';
		$page[] = '					</div>';
		$page[] = '				</div>';

	// If there are additional notes, put in links to show and hide them.
		if( mysql_num_rows( $notes_pull ) > 1 ) {
			$page[] = '				<div class="toggle" id="show_' . $call['id'] . '">';
			$page[] = '					<span class="toggle_text" id="show_text_' . $call['id'] . '">See All Notes...</span>';
			$page[] = '				</div>';
			$page[] = '				<div class="toggle" id="hide_' . $call['id'] . '" style="display: none;">';
			$page[] = '					<span class="toggle_text" id="hide_text_' . $call['id'] . '">Hide Notes...</span>';
			$page[] = '				</div>';
		}

	// Output any additional notes if they exist.
		$page[] = '				<div class="hidden" id="hidden_' . $call['id'] . '" style="display: none;">';
		while( $note = mysql_fetch_assoc( $notes_pull ) ) {
			$page[] = '					<div class="regular_note" id="note_' . $note['id'] . '">';
			$page[] = '						<div class="note_text" id="note_text_' . $note['id'] . '">';
			$page[] = '							<span class="text" id="text_' . $note['id'] . '">' . str_replace( "\n", '<br />', $note['content'] ) . '</span>';
			$page[] = '						</div>';
			$page[] = '						<div class="note_time" id="note_time_' . $note['id'] . '">';
			$page[] = '							<span class="time" id="time_' . $note['id'] . '">' . date( 'M jS, Y @ g:ia' , $note['timestamp'] ) . '</span>';
			$page[] = '						</div>';
			$page[] = '						<div class="note_employee" id="note_employee_' . $note['id'] . '">';
			$page[] = '							<span class="employee" id="employee_' . $note['id'] . '">' . $note['employee'] . '</span>';
			$page[] = '						</div>';
			$page[] = '					</div>';
		}
		$page[] = '					<!-- End of notes -->';
		$page[] = '				</div>';

	// Put in the ability to add a note if logged in.
		if( $_COOKIE['wywo_user'] ) {
			$page[] = '				<form action="./?area=note&id=' . $call['id'] . '" class="add_note" id="add_note_' . $call['id'] . '" method="post">';
			$page[] = '					<div class="add_text" id="add_text_' . $call['id'] . '">';
			$page[] = '						<textarea class="note" id="textarea_' . $call['id'] . '" name="note" placeholder="New notes go here."></textarea>';
			$page[] = '					</div>';
			$page[] = '					<div class="add_button" id="add_button_' . $call['id'] . '">';
			$page[] = '						<input class="button" id="add_' . $call['id'] . '" name="add" type="submit" value="Add Note" />';
			$page[] = '					</div>';
			$page[] = '				</form>';
		}

	// Finish it up.
		$page[] = '			</div>';
		$page[] = '		</div>';
	}

} else {

// Print out the "empty" page.
	$page[] = '		<div id="empty">';
	$page[] = '			<span id="empty_text">No calls...</span>';
	$page[] = '		</div>';

}

		// Copyright: 2010 by Michael V. Colianna ?>
