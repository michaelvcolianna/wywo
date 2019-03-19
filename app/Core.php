<?php

namespace Wywo;

use Wywo\Base;
use Wywo\Pages\Archive;
use Wywo\Pages\Calls;

class Core extends Base
{
    public function handleActions ()
    {
        if ( in_array( $this->page, self::VALID_ACTIONS ) )
        {
            // do action
            header( 'Location:/' );
            exit();
        }

        return;
    }

    public function setTemplate ()
    {
        if ( array_key_exists( $this->page, self::VALID_PAGES ) )
        {
            $this->template = implode( '.', [
                self::VALID_PAGES[$this->page],
                'html',
                'twig',
            ] );
        }
        else
        {
            header( 'Location:/' );
            exit();
        }

        return;
    }

    public function assembleVariables()
    {
        $this->variables = [
            'title' => 'All Calls',
            'page' => $this->page,
            'user_name' => 'MVC',
        ];

        if ( $this->page == 'calls' )
        {
            $this->variables['calls'] = [
                'all' => Calls::getCurrent( $this->db ),
                'genius' => Calls::getCurrent( $this->db, 'genius' ),
                'business' => Calls::getCurrent( $this->db, 'business' ),
                'manager' => Calls::getCurrent( $this->db, 'manager' ),
            ];
        }

        if ( $this->page == 'archive' )
        {
            $this->variables['calls'] = [
                'archive' => Archive::getCurrent( $this->db ),
            ];
        }

        return;
    }

    public function render()
    {
        return $this->twig->render( $this->template, $this->variables );
    }
}
