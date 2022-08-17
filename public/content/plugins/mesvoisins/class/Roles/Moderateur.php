<?php 

namespace Mesvoisins\Roles;

class Moderateur
{

    const KEY = "Moderateur";

    static public function register()
    {
        add_role(
            self::KEY, 
            "Moderateur", 
            [
                "read"              => true,
                "edit_posts"        => true, 
                "publish_posts"     => true,
                "manage_categories" => true,
                "remove_users"      => true,
                "delete_posts"      => true,
                "edit_users"        => true,

            ]);
        


    }

    static public function unregister()
    {
        remove_role(self::KEY);
    }

 
}
?>