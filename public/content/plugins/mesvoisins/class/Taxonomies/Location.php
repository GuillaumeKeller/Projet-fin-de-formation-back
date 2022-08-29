<?php 

namespace Mesvoisins\Taxonomies;
use       Mesvoisins\PostTypes\Ad;

class Location
{
    const KEY = "AdLocation";

    static public function register()
    {
        register_taxonomy(
            self::KEY, 
            [Ad::KEY],
            [
                "label"         => "Localisation",
                "hierarchical"  => false,
                "public"        => true,
                "show_in_rest"  => true,
            ]);

    }

}
             

?>