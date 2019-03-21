<?php

namespace Wywo\Actions;

use Wywo\Actions\Auth;

class Entry
{
    public static function create ( $db, $formdata )
    {
        $create_params = [
            ':type' => $_POST['type'],
            ':timestamp' => time(),
            ':customer' => ucwords( strtolower( $_POST['customer'] ) ),
            ':repair' => $_POST['repair'],
            ':primary' => $_POST['primary'],
            ':secondary' => $_POST['secondary'],
            ':new' => 'new',
        ];

        $create_query = "INSERT INTO `calls` (`type`, `timestamp`, `customer`, `repair`, `primary`, `secondary`, `status`) VALUES (:type, :timestamp, :customer, :repair, :primary, :secondary, :new);";
        $create_stmt = $db->prepare( $create_query );
        $create_stmt->execute( $create_params );

        $note_params = [
            ':call' => $db->lastInsertId(),
            ':timestamp' => time(),
            ':employee' => Auth::getUsername(),
            ':content' => $_POST['note'],
        ];
        $note_query = "INSERT INTO `notes` (`call`, `timestamp`, `employee`, `content`) VALUES (:callid, :timestamp, :employee, :content);";
        $note_stmt = $db->prepare( $note_query );
        $note_stmt->execute( $note_params );
    }
}
