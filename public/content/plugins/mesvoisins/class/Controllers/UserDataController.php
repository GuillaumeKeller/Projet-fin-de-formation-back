<?php 

namespace Mesvoisins\Controllers;

use Mesvoisins\Models\UserDataModel;
use WP_REST_Response;
use WP_REST_Server;

class UserDataController extends CoreController 
{
    public function createTable()
    {
        $model = new UserDataModel();
        $model->createTable();
    }

    public function deleteTable()
    {
        $model = new UserDataModel();
        $model->deleteTable();
    }


    public function insertData()
    {

    $model = new UserDataModel();
    $model->insert(2,'15 rue des pommes', 'Caen', 14000, '0606060606', 'tonton@tonton.com');


    }

    public function registerRoutes()
    {
        register_rest_route('mesvoisins/v1', '/userdata/', [
            'methods' => WP_REST_Server::READABLE,
            'callback' => function(){
                global $wpdb;
                $sql = "SELECT * FROM `user_data`";
                $list = $wpdb->get_results($sql);

                return $list;
            },
            
        ]);
    }

    
}