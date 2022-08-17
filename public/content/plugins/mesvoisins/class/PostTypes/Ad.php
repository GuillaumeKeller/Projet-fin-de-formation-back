<?php

Namespace Mesvoisins\PostTypes;

class Ad
{
    const KEY = "ad";

    static public function register()
    {
        register_post_type(
            self::KEY,
            [
                "label"         => "Annonces",
                "description"   => "Post detaillant une annonce",
                "menu_icon"     => "dashicons-align-left",
                // * Controls how the type is visible to authors
                "public"          => true,
                "supports"       => 
                [
                    "title",
                    "author",
                    "thumbnail",
                    "comments",
                    "excerpt",
                    "editor"
                ],
                // *The string to use to build the read, edit, and delete capabilities
                "capabilities" => [/* TODO */],

                // * Whether to use the internal default meta capability handling
                // * Here the stantards admin role is able to edite posts types
                "map_meta_cap"    => true,

                // *  Whether to expose this post type in the REST API
                "show_in_rest"    => true,

            ]
        );
    }
}
?>