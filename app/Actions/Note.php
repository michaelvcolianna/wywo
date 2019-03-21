<?php

namespace Wywo\Actions;

use Wywo\Actions\Auth;

class Note
{
    public static function add ( $db, $call, $formdata )
    {
        $note_params = [
            ':call' => $call,
            ':timestamp' => time(),
            ':employee' => Auth::getUsername(),
            ':content' => $_POST['note'],
        ];

        $note_query = "INSERT INTO `notes` (`call`, `timestamp`, `employee`, `content`) VALUES (:call, :timestamp, :employee, :content)";
        $note_stmt = $db->prepare( $note_query );
        $note_stmt->execute( $note_params );

        $update_params = [
            ':call' => $call,
        ];
        $update_query = "UPDATE `calls` SET `status` = 'old' WHERE `id` = :call";
        $update_stmt = $db->prepare( $update_query );
        $update_stmt->execute( $update_params );
    }
}
