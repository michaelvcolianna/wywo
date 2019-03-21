<?php

namespace Wywo;

use Wywo\Base;
use Wywo\Actions\Auth;
use Wywo\Actions\Entry;
use Wywo\Actions\Note;
use Wywo\Pages\Archive;
use Wywo\Pages\Calls;

class Core extends Base
{
    public function handleActions ()
    {
        if ( in_array( $this->page, self::VALID_ACTIONS ) )
        {
            if ( $this->page == 'login' )
            {
                Auth::login();
            }

            if ( $this->page == 'logout' )
            {
                Auth::logout();
            }

            if ( !empty( Auth::getUsername() ) )
            {
                if ( $this->page == 'create' )
                {
                    // Pretending validation has occurred
                    Entry::create( $this->db, $this->form );
                }

                if ( $this->page == 'note' )
                {
                    Note::add( $this->db, $this->value, $this->form );
                }
            }

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
                $this->type,
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
            'user_name' => Auth::getUsername(),
            'calls' => [
                'all' => Calls::getCurrent( $this->db ),
                'genius' => Calls::getCurrent( $this->db, 'genius' ),
                'business' => Calls::getCurrent( $this->db, 'business' ),
                'manager' => Calls::getCurrent( $this->db, 'manager' ),
            ],
        ];

        if ( $this->type == 'archive' )
        {
            $this->variables['calls']['archive'] = Archive::getCurrent( $this->db );
        }

        return;
    }

    public function render()
    {
        return $this->twig->render( $this->template, $this->variables );
    }
}
