<?php 

namespace Mesvoisins\Taxonomies;
use       Mesvoisins\PostTypes\Ad;

class Types
{
    const KEY = "AdType";

    static public function register()
    {
        register_taxonomy(
            self::KEY, 
            [Ad::KEY],
            [
                "label"         => "Types",
                "hierarchical"  => false,
                "public"        => true,
                "show_in_rest"  => true,
            ]);

    }

}

?>