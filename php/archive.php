<?php	//	Genius Room: WYWO
		//	Script: Call archive
		//	Revision: 3.0.6

#	-----	The title text.
$title = ' - Last 20 Calls';

#	-DOC-	Pull the last 20 archived calls for output.
if( mysql_num_rows( $archive_pull = mysql_query( "SELECT * FROM `archive` ORDER BY `id` DESC LIMIT 0,20" ) ) > 0 ) {
	while( $archive = mysql_fetch_assoc( $archive_pull ) ) {

	// Start the call, build the left side. Don't bug me about my page buffer.
		$page[] = '		<div class="archive" id="archive_' . $archive['id'] . '">';
		$page[] = '			<div class="archive_left" id="archive_left_' . $archive['id'] . '">';
		$page[] = '				<div class="archive_customer" id="archive_customer_' . $archive['id'] . '">';
		$page[] = '					<span class="customer_text" id="customer_text_' . $archive['id'] . '">' . $archive['customer'] . '</span>';
		$page[] = '				</div>';
		$page[] = '				<div class="archive_opened" id="archive_opened_' . $archive['id'] . '">';
		$page[] = '					<span class="opened_text" id="opened_text_' . $archive['id'] . '"><strong>Added:</strong> ' . date( 'M jS, Y @ g:ia', $archive['opened'] ) . '</span>';
		$page[] = '				</div>';
		$page[] = '				<div class="archive_closed" id="archive_closed_' . $archive['id'] . '">';
		$page[] = '					<span class="closed_text" id="closed_text_' . $archive['id'] . '"><strong>Closed:</strong> ' . date( 'M jS, Y @ g:ia', $archive['closed'] ) . ' by ' . $archive['employee'] . '</span>';
		$page[] = '				</div>';
		$page[] = '				<div class="archive_info" id="archive_info_' . $archive['id'] . '">';
		$page[] = '					<span class="info_text" id="info_text_' . $archive['id'] . '">' . $archive['info'] . '</span>';
		$page[] = '				</div>';
		$page[] = '			</div>';

	// Start the right side.
		$page[] = '			<div class="archive_right" id="archive_right_' . $archive['id'] . '">';

	// Turn the notes block into an array based on returns. (This is how they were entered.)
		$notes = explode( "\n", $archive['notes'] );

	// Loop through the array and add each note.
		foreach( $notes as $key => $value ) {
			# ASIDE: Only on actual lines.
			if( $value ) {
				$page[] = '				<div class="archive_note" id="archive_' . $archive['id'] . '_note_' . $key . '">';
				$page[] = '					<span class="archive_text" id="archive_' . $archive['id'] . '_text_' . $key . '">' . $value . '</span>';
				$page[] = '				</div>';
			}
		}

	// Close it out.
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