<?php

  namespace Mesvoisins;

  use Mesvoisins\PostTypes\Ad;
  use Mesvoisins\Roles\Neighbour;
  use Mesvoisins\Roles\Moderator;
  use Mesvoisins\Taxonomies\Types;


class Plugin
{
    public function __construct()
    {
        //*Activate deactivate plugin
        register_activation_hook(MESVOISINS_ENTRY_FILE, [$this,"onActivation"]);
        register_deactivation_hook(MESVOISINS_ENTRY_FILE, [$this,"onDeactivation"]);

        //* Initiate the plugin
        add_action("init", [$this,"onInit"]);
    }

    public function onInit()
    {
        //* Register CPT
        Ad::register();

        Types::register();
    }

    public function onActivation()
    {
     Neighbour::register();
     Moderator::register();
    
     Types::register();
     wp_insert_term("Offre", Types::KEY);
     wp_insert_term("Demande", Types::KEY);

    }

    public function onDeactivation()
    {
        Neighbour::unregister();
        Moderator::register();

    }
}
?>