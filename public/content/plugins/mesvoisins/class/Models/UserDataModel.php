<?php 

namespace Mesvoisins\Models;


use Symfony\Component\VarDumper\VarDumper;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;




class UserDataModel extends CoreModel
{
    

    // *-------------------------------
    // *        TABLE                 
    // * ------------------------------

    const TABLE = 'user_data';

    public function createTable()
    {
        $charset_collate = $this->wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS ". self::TABLE." (

        user_id INT NOT NULL,
        first_name VARCHAR(255) NOT NULL,
        last_name VARCHAR(255) NOT NULL,
        address VARCHAR(255) NOT NULL,
        city VARCHAR(255) NOT NULL,
        postal_code INT(5) NOT NULL,
        phone VARCHAR(10)  NULL,
        email VARCHAR(255) NOT NULL
        
    ) $charset_collate;";

        $this->wpdb->query($sql);
    }

    public function deleteTable()
    {
        $sql = "DROP TABLE IF EXISTS `". self::TABLE ."`";
        $this->wpdb->query( $sql );
    }

   

    // Ici je veux insérer des données dans ma table custom user_data en récupérant les données du formulaire de mon plugin
    public function insertData(WP_REST_REQUEST $request)
    {
        global $wpdb;
        
        $requestedData = $request->get_json_params();
        $user = wp_create_user($requestedData['login'], $requestedData['password'], $requestedData['email']);
        //retourner l'id de l'utilisateur créé
	$user_id = $user;
	if (is_wp_error($user_id)) {
       		return http_response_code(400);
	}

       	$data = [
        	'user_id'          => $user_id,
        	'first_name'       => $requestedData['first_name'],
        	'last_name'        => $requestedData['last_name'],
        	'address'          => $requestedData['address'],
        	'city'             => $requestedData['city'],
        	'postal_code'      => $requestedData['postal_code'],
        	'phone'            => $requestedData['phone'],
        	'email'            => $requestedData['email'],
        ];
        
	if($this->wpdb->insert('user_data', $data) != false) {
		return http_response_code(200);
	}

	return http_response_code(400);
    }

  





    // *-------------------------------
    // *          USER                 
    // * ------------------------------

      // Get content of user_data table by user_id
  public function findByID( WP_REST_Request $request)
  {

   
    
        $users = $request->get_url_params('id');
        $userID = $users['id'];
        
         
    
    $sql = "SELECT * FROM `user_data` 
            WHERE `user_id` = ".$userID.";";

    
    $results = $this->wpdb->get_results( $sql );
    

   // Fill up the array with the results
    $output = [];
    foreach ($results as $result) {
        // var_dump($result);



        $user= get_users($userID);       
        $output[] = [
            'user_id' => $result->user_id,
            'first_name' => $result-> first_name,
            'last_name' => $result -> last_name,
            'address' => $result->address,
            'city' => $result->city,
            'postal_code' => $result->postal_code,
            'phone' => $result->phone,
            'email' => $result->email,
            // 'created_at' => date( "Y-m-d H:i:s" ),
        ];
        
    }
    return $output;
    }


    public function deleteById(WP_REST_Request $request)
    {
        global $wpdb;
        $users = $request->get_url_params('id');
        $userID = $users['id'];
        // var_dump(intval($userID));die;
            
        $sql = $wpdb->prepare("DELETE FROM `user_data` 
                WHERE `user_id` = ".$userID.";");
    
        // * Delete in 'user_data'
        $this->wpdb->query( $sql);

        // * Delete in 'wp_usermeta'
        require_once(ABSPATH.'wp-admin/includes/user.php');
        $user_meta = wp_delete_user(intval($userID));
        var_dump($user_meta); die;
        

    }

    public function updateById(WP_REST_Request $request)
    {
        $requestedData = $request->get_json_params();
        // var_dump($requestedData);die;
        $users = $request->get_url_params('id');
        $userID = $users['id'];
        
        $updatedData= 
        [
        'first_name'       => $requestedData['first_name'],
        'last_name'        => $requestedData['last_name'],
        'address'          => $requestedData['address'],
        'city'             => $requestedData['city'],
        'postal_code'      => $requestedData['postal_code'],
        'phone'            => $requestedData['phone'],
        'email'            => $requestedData['email'],
        ] ;
        $data_where= ['user_id' => $userID];
            // print_r($updatedData);
            // echo '\n';
            // print_r($data_where);

        // * Update in 'user_data'
        $results = $this->wpdb->update( 'user_data', $updatedData, $data_where);
            // var_dump($results);

        // * Update in 'wp_usermeta'
        $user_data = wp_update_user( array( 'ID' => $userID, 'first_name' => '', 'last_name' => '') );
            // var_dump($user_data); die; 
    }
       
}
