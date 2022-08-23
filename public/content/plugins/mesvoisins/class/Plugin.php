<?php

  namespace Mesvoisins;

  use Mesvoisins\Controllers\UserDataController;
  use Mesvoisins\PostTypes\Ad;
  use Mesvoisins\Roles\Neighbour;
  use Mesvoisins\Roles\Moderator;
  use Mesvoisins\Taxonomies\Types;
  use Mesvoisins\Taxonomies\Categories;
  use Mesvoisins\Taxonomies\Status;
  
  
  


class Plugin
{
    public function __construct()
    {
        //* Initiate the plugin
        add_action("init", [$this,"onInit"]);


        add_action("rest_api_init", [$this,"onRestApiInit"]);

        //*Activate deactivate plugin
        register_activation_hook(MESVOISINS_ENTRY_FILE, [$this,"onActivation"]);
        register_deactivation_hook(MESVOISINS_ENTRY_FILE, [$this,"onDeactivation"]);

        
    }

    public function onInit()
    {
        //* Register CPT
        Ad::register();

        Types::register();
        Categories::register();
        Status::register();
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

        $modelController = new UserDataController();
        $modelController->createTable();
        $modelController->insertData();
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
    }

    
}

?>