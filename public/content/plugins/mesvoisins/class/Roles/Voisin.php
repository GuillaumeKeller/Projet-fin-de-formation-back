<?php 

namespace Mesvoisins\Roles;

class Voisin
{

    const KEY = "Voisin";

    static public function register()
    {
        add_role(
            self::KEY, 
            "Voisin", 
            [
                "read"              => true,
                "edit_posts"        => true, 
                "publish_posts"     => true,
                "manage_categories" => true,

            ]);
        


    }

    static public function unregister()
    {
        remove_role(self::KEY);
    }

 
}






?>