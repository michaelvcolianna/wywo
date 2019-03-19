<?php

namespace Wywo\Pages;

class Calls
{
    const VALID_TYPES = [ 'genius', 'business', 'manager' ];

    public static function getCurrent( $db, $type = null )
    {
        $current = [];

        // In the real world, we use stored procedures.
        $calls_query = "SELECT * FROM `calls`";

        if ( in_array( $type, self::VALID_TYPES ) )
        {
            $calls_query.= " WHERE `type` = :type";
        }

        $calls_query.= " ORDER BY `id` DESC";

        $calls_stmt = $db->prepare( $calls_query );
        $calls_stmt->execute( [ ':type' => $type ] );
        $calls_list = $calls_stmt->fetchAll( \PDO::FETCH_ASSOC );

        foreach ( $calls_list as $id => $call )
        {
            $current[$id] = $call;

            $notes_query = "SELECT * FROM `notes` WHERE `call` = :cid ORDER BY `id` DESC";
            $notes_stmt = $db->prepare( $notes_query );
            $notes_stmt->execute( [ ':cid' => $call['id'] ] );
            $notes_list = $notes_stmt->fetchAll( \PDO::FETCH_ASSOC );

            $current[$id]['newest_note'] = $notes_list[0];

            array_shift( $notes_list );
            $current[$id]['notes'] = [];
            foreach ( $notes_list as $note )
            {
                $current[$id]['notes'][] = $note;
            }
        }

        return $current;
    }
}
