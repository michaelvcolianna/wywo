<?php

namespace Wywo;

use Wywo\Base;

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

    public function setVariables()
    {
        $this->variables = [
            'title' => 'All Calls',
            'all_calls' => 27,
            'genius_calls' => 15,
            'business_calls' => 8,
            'manager_calls' => 4,
            'page' => [],
            'logged_in' => false,
        ];

        return;
    }

    public function render()
    {
        return $this->twig->render( $this->template, $this->variables );
    }
}
