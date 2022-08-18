<?php 

namespace Mesvoisins\Taxonomies;
use       Mesvoisins\PostTypes\Ad;

class Status
{
    const KEY = "AdStatus";

    static public function register()
    {
        register_taxonomy(
            self::KEY, 
            [Ad::KEY],
            [
                "label"         => "Status",
                "hierarchical"  => false,
                "public"        => true,
                "show_in_rest"  => true,
            ]);

    }

}

?>