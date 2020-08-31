<?php
class Conf{

    static $debug = 1;

    static $databases = array(
        'default' => array(
            'host'      => 'localhost',
            'database'  => 'projet_fil_rouge',
            'login'     => 'root',
            'password'  => 'Bb@0770560063'
        )
        
    );
}

Router::prefix('cockpit', 'admin');
Router::connect('/','posts/index');
Router::connect('post/:slug-:id','posts/view/id:([0-9]+)/slug:([a-z0-9\-]+)');
Router::connect('blog/:action','posts/:action');
