<?php 

namespace Mesvoisins\Controllers;

use Mesvoisins\Models\UserDataModel;

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
        register_rest_route('mesvoisins/v1', '/ad', [
            'methods' => 'POST',
            'callback' => [$this, 'insertData'],
        ]);
    }
}