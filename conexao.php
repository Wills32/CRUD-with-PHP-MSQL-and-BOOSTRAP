<?php
class Conn {
    //host
    public static $Host = "localhost";
    //user
    public static $User = "root";
    //password
    public static $Pass = "";
    //database
    public static $Dbname = "crud";
    private static $Connect = null;
    
    private static function Conectar() {
        try {
            if(self::$Connect == null):
                self::$Connect = new PDO('mysql:host=' . self::$Host .';dbname='.self::$Dbname, self::$User, self::$Pass);
            endif;            
        } catch (Exception $ex) {
            echo 'Mensagem: ' . $ex->getMessage();
            die;
        }       
        return self::$Connect;
    }
    
    public function getConn() {
        return self::Conectar();
    }
    
}
