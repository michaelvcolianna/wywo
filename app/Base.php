<?php

namespace Wywo;

abstract class Base
{
    const VIEWS_DIR     = ROOT_DIR . '/views/templates';
    const VALID_ACTIONS = [ 'close', 'note', 'logout' ];
    const VALID_PAGES   = [
        'add'      => 'add',
        'archive'  => 'archive',
        'all'      => 'calls',
        'genius'   => 'calls',
        'business' => 'calls',
        'manager'  => 'calls',
        'login'    => 'login',
    ];

    protected $page;
    protected $value;
    protected $db;
    protected $twig;
    protected $template;
    protected $variables;

    public function __construct ()
    {
        $request = explode( '/', trim( $_SERVER['REQUEST_URI'], '/' ) );

        if ( $request[0] == 'all' )
        {
            header( 'Location:/' );
            exit();
        }

        $this->page = ( !empty( $request[0] ) ) ? $request[0] : 'all';
        $this->value = $request[1] ?? null;

        $dsn  = 'mysql:dbname=concierge;host=127.0.0.1';
        $user = (getenv('C9_HOSTNAME')) ? 'mcolianna' : 'root';
        $pass = (getenv('C9_HOSTNAME')) ? '' : 'universe';

        try
        {
            $dbh = new \PDO( $dsn, $user, $pass );
        }
        catch (\PDOException $e)
        {
            // In a real environment we care about this.
            exit('Unable to connect to the database.');
        }
        $this->db = $dbh;

        $loader = new \Twig\Loader\FilesystemLoader( self::VIEWS_DIR );
        $this->twig = new \Twig\Environment( $loader, [
            'auto_reload' => true,
            'cache'       => ROOT_DIR . '/views/cache',
            'debug'       => true,
        ] );
        $this->twig->addExtension( new \Twig\Extension\DebugExtension() );
    }
}
