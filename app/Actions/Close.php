<?php

namespace Wywo\Actions;

use Wywo\Actions\Auth;

class Close
{
    public static function archive ( $db, $id )
    {
        $call_params = [
            ':id' => $id,
        ];

        $call_query = "SELECT * FROM `calls` WHERE `id` = :id";
        $call_stmt = $db->prepare( $call_query );
        $call_stmt->execute( $call_params );
        $call = $call_stmt->fetch( \PDO::FETCH_ASSOC );

        $notes_params = [
            ':call' => $call['id'],
        ];

        $notes_query = "SELECT * FROM `notes` WHERE `call` = :call";
        $notes_stmt = $db->prepare( $notes_query );
        $notes_stmt->execute( $notes_params );
        $notes_list = $notes_stmt->fetchAll( \PDO::FETCH_ASSOC );

        foreach ($notes_list as $note)
        {
            $notes.= date( 'm/d/Y', $note['timestamp'] );
            $notes.= ' at ' . date( 'g:ia', $note['timestamp'] );
            $notes.= ' by ' . $note['employee'];
            $notes.= ': ' . str_replace( "\n", ' ', $note['content'] );
            $notes.= "\n";
        }

        $close_params = [
            ':opened' => $call['timestamp'],
            ':closed' => time(),
            ':employee' => Auth::getUsername(),
            ':type' => $call['type'],
            ':customer' => $call['customer'],
            ':info' => implode( ' / ', [ $call['primary'], $call['secondary'] ] ),
            ':notes' => $notes,
        ];

        $close_query = "INSERT INTO `archive` (`opened`, `closed`, `employee`, `type`, `customer`, `info`, `notes`) VALUES (:opened, :closed, :employee, :type, :customer, :info, :notes)";
        $close_stmt = $db->prepare( $close_query );
        $close_stmt->execute( $close_params );

        $uncall_query = "DELETE FROM `calls` WHERE `id` = :id";
        $uncall_stmt = $db->prepare( $uncall_query );
        $uncall_stmt->execute( $call_params );

        $unnotes_query = "DELETE FROM `notes` WHERE `call` = :call";
        $unnotes_stmt = $db->prepare( $unnotes_query );
        $unnotes_stmt->execute( $notes_params );
    }
}
