<?php 

namespace Mesvoisins\Taxonomies;
use       Mesvoisins\PostTypes\Ad;

class Categories
{
    const KEY = "AdCategory";

    static public function register()
    {
        register_taxonomy(
            self::KEY, 
            [Ad::KEY],
            [
                "label"         => "Catégories",
                "hierarchical"  => false,
                "public"        => true,
                "show_in_rest"  => true,
            ]);

    }

}

?>