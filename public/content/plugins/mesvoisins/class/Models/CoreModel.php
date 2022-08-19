<?php 

namespace Mesvoisins\Models;

class CoreModel
{
    // on stocke la connexion à la bdd wordpress
    protected $database;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
    }
}