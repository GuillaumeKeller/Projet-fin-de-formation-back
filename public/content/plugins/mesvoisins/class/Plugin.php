<?php

namespace Mesvoisins;

use Mesvoisins\Controllers\UserDataController;
use Mesvoisins\PostTypes\Ad;
use Mesvoisins\Roles\Neighbour;
use Mesvoisins\Roles\Moderator;
use Mesvoisins\Taxonomies\Types;
use Mesvoisins\Taxonomies\Categories;
use Mesvoisins\Taxonomies\Status;
use Mesvoisins\Taxonomies\Location;





class Plugin
{
    public function __construct()
    {
        //* Initiate the plugin
        add_action("init", [$this, "onInit"]);
        add_action("rest_api_init", [$this, "onRestApiInit"], 15);

        //*Activate deactivate plugin
        register_activation_hook(MESVOISINS_ENTRY_FILE, [$this, "onActivation"]);
        register_deactivation_hook(MESVOISINS_ENTRY_FILE, [$this, "onDeactivation"]);

        add_filter( 'jwt_auth_whitelist', function ( $endpoints ) {
            $mesvoisins_endpoints = array(
                '/wp-json/mesvoisins/v1/userdata/*',
            );
        
            return array_unique( array_merge( $endpoints, $mesvoisins_endpoints ) );
        } );
    }

    public function onInit()
    {
        //* Register CPT
        Ad::register();

        Types::register();
        Categories::register();
        Status::register();
        Location::register();

    }

    public function onActivation()
    {
        Neighbour::register();
        Moderator::register();

        Types::register();
        wp_insert_term("Offre", Types::KEY);
        wp_insert_term("Demande", Types::KEY);

        Categories::register();
        wp_insert_term("Service", Categories::KEY);
        wp_insert_term("Matériel", Categories::KEY);

        Status::register();
        wp_insert_term("Active", Status::KEY);
        wp_insert_term("Archivée", Status::KEY);

        Location::register();
        wp_insert_term("Calvados", Location::KEY);

        $modelController = new UserDataController();
        $modelController->createTable();
    }

    public function onDeactivation()
    {
        Neighbour::unregister();
        Moderator::register();

        $modelController = new UserDataController();
        $modelController->deleteTable();
    }



    public function onRestApiInit()
    {
        $controller = new UserDataController();
        $controller->registerRoutes();

        remove_filter('rest_pre_serve_request', 'rest_send_cors_headers');
        add_filter('rest_pre_serve_request', [$this, 'setupCors']);
    }

    /**
     * setupCors()
     * filters the Cross Origin Policy
     *
     * @return void
     */
    static public function setupCors()
    {
        // header('Access-Control-Allow-Headers: Authorization, X-WP-Nonce,Content-Type, X-Requested-With');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
        // header( 'Access-Control-Allow-Credentials: true' );
    }
}
