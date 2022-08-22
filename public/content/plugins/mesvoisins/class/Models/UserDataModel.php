<?php 

namespace Mesvoisins\Models;

use WP_REST_Request;

class UserDataModel extends CoreModel
{
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

        
}