<?php

    class DB{
        private $host       = '127.0.0.1';
        private $username   = 'root';
        private $password   = 'aze123!321EZA';
        private $database   = 'cv';
        private $db;
        public function __construct($host = null, $username = null, $password = null, $database = null){
            if($host != null){
                $this->host     = $host;
                $this->username = $username;
                $this->password = $password;
                $this->database = $database;
            }
            try{
                $this->db = new PDO('mysql:host=' .$this->host. ';dbname=' .$this->database, $this->username, $this->password, array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8' ,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
                ));
            }catch(PDOException $e){
                die('<h1>Impossible de se connecter à la base de donnée</h1>');
            } 
        }
        public function query($sql, $data = array()){
            $req =$this->db->prepare($sql);
            $req->execute($data);
            return $req->fetchAll(PDO::FETCH_OBJ);
        }
    }


// class DB {
//     private $host       = 'localhost';
//     private $username   = 'uffbpqzg_ali';
//     private $password   = 'aze123!321EZA';
//     private $database   = 'uffbpqzg_onelist';
//     private $db;
//     public function __construct($host = null, $username = null, $password = null, $database = null)
//     {
//         if ($host != null) {
//             $this->host     = $host;
//             $this->username = $username;
//             $this->password = $password;
//             $this->database = $database;
//         }
//         try {
//             $this->db = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->database, $this->username, $this->password, array(
//                 PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
//                 PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
//             ));
//         } catch (PDOException $e) {
//             die('<h1>Impossible de se connecter à la base de donnée</h1>');
//         }
//     }
//     public function query($sql, $data = array())
//     {
//         $req = $this->db->prepare($sql);
//         $req->execute($data);
//         return $req->fetchAll(PDO::FETCH_OBJ);
//     }
// }

?>


