<?php

namespace Wywo\Pages;

class Archive
{
    public static function getCurrent( $db )
    {
        $current = [];

        // In the real world, we use stored procedures.
        $calls_query = "SELECT * FROM `archive` ORDER BY `id` DESC LIMIT 0,20";
        $calls_stmt = $db->prepare( $calls_query );
        $calls_stmt->execute();
        $calls_list = $calls_stmt->fetchAll( \PDO::FETCH_ASSOC );

        foreach ( $calls_list as $id => $call )
        {
            $current[$id] = $call;
            $current[$id]['notes'] = explode( "\n", $call['notes'] );
        }

        return $current;
    }
}
