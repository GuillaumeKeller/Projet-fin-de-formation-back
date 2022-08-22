<?php 

namespace Mesvoisins\Models;

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



        
}