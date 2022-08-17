<?php

  namespace Mesvoisins;

  use Mesvoisins\PostTypes\Ad;
  use Mesvoisins\Roles\Voisin;
  use Mesvoisins\Roles\Moderateur;


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
    }

    public function onActivation()
    {
     Voisin::register();
     Moderateur::register();

    }

    public function onDeactivation()
    {
        Voisin::unregister();
        Moderateur::register();

    }
}
?>