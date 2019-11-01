<?php
class Banco{
    protected static $db;
    
    public function __construct($banco){
        if(file_exists('./database.ini')){
            $ini = parse_ini_file('./database.ini',true);
            $db_host = $ini[$banco]['host'];
            $db_name = $ini[$banco]['database'];
            $db_user = $ini[$banco]['username'];
            $db_pass = $ini[$banco]['password'];

            try{
                self::$db = pg_connect("host=$db_host port=5432 dbname=$db_name user=$db_user password=$db_pass");
                //self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return self::$db;
            }catch(Exception $e){
                die("Erro de conexão: ".$e->getMessage());
            }
        }else{
            echo 'Arquivo .ini não existe.';
        }
    }

    public function query($sql){
        if(preg_match("/insert\s/i",$sql)===true){
            $rs = pg_prepare(self::$db,$sql);
            $rs = pg_execute(self::$db,$sql);
            return $rs;
        }else{
            $rs = pg_query(self::$db,$sql);
            if(pg_num_rows($rs) > 0){
                $row = pg_fetch_all($rs);
                return $row;
            }else{
                return false;
            }
        }
    }

    public function close(){
        pg_close(self::$db);
    }
}
?>