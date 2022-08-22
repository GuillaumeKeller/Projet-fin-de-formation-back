<?php 

namespace Mesvoisins\Controllers;

use Mesvoisins\Models\UserDataModel;
use WP_REST_Request;
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
    $model->insert(1,'15 rue des pommes', 'Lyon', 69000, '0606060606', 'coucou@mail.com');


    }

    public function findUser($id)
    {
        $model = new UserDataModel();
        $user = $model->findByID($id);
        return $user;
    }

    


    public function registerRoutes()
    {
        register_rest_route('mesvoisins/v1', '/userdata/', [
            'methods' => 'GET',
            'callback' => function(){
                global $wpdb;
                $sql = "SELECT * FROM `user_data`";
                $list = $wpdb->get_results($sql);

                return $list;
            },

            
            
        ]);
        

        // API REST route for user_data/id
        register_rest_route('mesvoisins/v1', '/userdata/(?P<id>\d+)', [
            'methods' => WP_REST_Server::READABLE,
            'callback' => [$this,'findUser'],
            
        ]);

       
    }

    
}