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

    public function insert($user_id, $address, $city, $postal_code, $phone, $email)
    {
        $data = [
            'user_id' => $user_id,
            'address' => $address,
            'city' => $city,
            'postal_code' => $postal_code,
            'phone' => $phone,
            'email' => $email,
            // 'created_at' => date( "Y-m-d H:i:s" ),
        ];

        $this->wpdb->insert(
            self::TABLE,
             $data
            );
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
        $users = $request->get_url_params('id');
        $userID = $users['id'];
        // var_dump(intval($userID));die;
            
        $sql = "DELETE FROM `user_data` 
                WHERE `user_id` = ".$userID.";";
    
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
        ['address'          => $requestedData['address'],
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