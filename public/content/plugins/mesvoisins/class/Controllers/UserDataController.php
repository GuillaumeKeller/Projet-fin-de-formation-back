<?php 

namespace Mesvoisins\Controllers;

use Mesvoisins\Models\UserDataModel;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

class UserDataController extends CoreController 
{

    // *-------------------------------
    // *        TABLE                 
    // * ------------------------------

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


    public function insertData(WP_REST_REQUEST $request)
    {
    	$model = new UserDataModel();
    	return $model->insertData( $request );
    }


    

    // *-------------------------------
    // *        USER                  
    // * ------------------------------



    public function findUser($id)
    {
        $model = new UserDataModel();
        $user = $model->findByID($id);
        return $user;

    }

    public function deleteUserData($id)
    {
        $model = new UserDataModel();
        $model -> DeleteById($id);

    }

    public function updateUserData($id)
    {
        // var_dump($id);die;
        $model = new UserDataModel;
        $model -> updateById($id);
        
    }



    // *-------------------------------
    // *        ROUTES                 
    // * ------------------------------

  


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
            'permission_callback' => '__return_true',
        ]);

        register_rest_route('mesvoisins/v1', '/userdata/create', [
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => [$this,'insertData'],
            'permission_callback' => '__return_true',
        ]);

        // API REST route for user_data/id
        register_rest_route('mesvoisins/v1', '/userdata/(?P<id>\d+)', [
            'methods' => WP_REST_Server::READABLE,
            'callback' => [$this,'findUser'],
            'permission_callback' => '__return_true',
        ]);


        register_rest_route('mesvoisins/v1', '/userdata/(?P<id>\d+)/delete', [
            'methods' => WP_REST_Server::DELETABLE,
            'callback' => [$this,'deleteUserData'],
            'permission_callback' => '__return_true',
        ]);

        register_rest_route('mesvoisins/v1', '/userdata/(?P<id>\d+)/edit', [
            'methods' => WP_REST_Server::EDITABLE,
            'callback' => [$this,'updateUserData'],
            'permission_callback' => '__return_true',
        ]);

       
    }

    
}
