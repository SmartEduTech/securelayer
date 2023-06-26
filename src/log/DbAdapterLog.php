<?php
//include_once dirname(__FILE__)."/mvc/Configuration.php";

namespace Smartedutech\Securelayer\Log;
//use lib\mvc\Configuration;


abstract class DbAdapterLog
{
    public static $dbh;

    public static function connect($_config){
        if(!self::$dbh){
            try { 
                self::$dbh = new \PDO('mysql:host='.$_config['host'].';dbname='.$_config['DBName'], $_config['USER'] , $_config['PASSWORD']);
            self::$dbh->exec("set names utf8");
			} catch (\PDOException $e) {
                print "Erreur !: " . $e->getMessage() . "<br/>";
                die();
            }
        }
    }

    public static function beginTransaction(){
       // self::connect();
        try {
            self::$dbh->beginTransaction();
        } catch (\PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
    }
    public static function Commit(){
        //self::connect();
        try {
            self::$dbh->commit();
        } catch (\PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
    }
    public static function Rolback(){
        //self::connect();
        try {
            self::$dbh->rollBack();
        } catch (\PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
    }
    public static function SelectSQL($Sql){
        //self::connect();
        try {
            $data=array();

        $req=self::$dbh->query($Sql);
        if($req){
            foreach($req as $row) {
                $data[]=$row;
            }
        }

            return $data;
        } catch (\PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public static function Select($table,$where=null){
        //self::connect();
        try {
            $data=false;
            $query="SELECT * FROM $table ";
            $query.=!empty($where) ? " where ".$where :'';

            foreach(self::$dbh->query($query,\PDO::FETCH_ASSOC) as $row) {
                $data[]=$row;
            }
            return $data;
        } catch (\PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public static function SelectWithPrepare($table,$where=null){
        //self::connect();
        try {
            $data=false;
            $query="SELECT * FROM $table ";
             $WhereParam="";
            if(!empty($where)){

                foreach ($where as $Cond){
                    if(isset($Cond->OR)){
                        $AttributsWhereOR= self::AttributeExtractor($Cond->OR);
                        foreach ($AttributsWhereOR as $Attrib=>$ValueAttrib){
                            $WhereParam.=empty($WhereParam) ? "$Attrib=:$Attrib" : " OR $Attrib=:$Attrib";
                        }
                    }elseif(isset($Cond->AND)){
                        $AttributsWhereAnd= self::AttributeExtractor($Cond->AND);

                        foreach ($AttributsWhereAnd as $Attrib=>$ValueAttrib){
                            $WhereParam.=empty($WhereParam) ? "$Attrib=:$Attrib" : " AND $Attrib=:$Attrib";
                        }
                    }
                }


                $stmt=self::$dbh->prepare("$query WHERE $WhereParam");

            }else{
                $stmt=self::$dbh->prepare($query);
            }


            $res= $stmt->execute();

            foreach($res as $row) {
                $data[]=$row;
            }
            return $data;
        } catch (\PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
    }


    private static function AttributeExtractor($record){
        if($record && $record instanceof \stdClass){
            $ListeOfAttribut=get_object_vars($record);
            if($ListeOfAttribut){
                return $ListeOfAttribut;
            }else{
                return array();
            }
        }else{
            return array();
        }
    }

    public static function Insert($table,$record){
        //self::connect();
        try {

            $Attributs=self::AttributeExtractor($record);
            $datatoInsert=$valueParam="";
            foreach ($Attributs as $Attrib=>$ValueAttrib){
                $datatoInsert.=empty($datatoInsert) ? $Attrib : ",$Attrib";
                $valueParam.=empty($valueParam) ? ":$Attrib" : ",:$Attrib";
            }

            $stmt = self::$dbh->prepare("INSERT INTO $table ($datatoInsert) VALUES ($valueParam)");
               //echo "INSERT INTO $table ($datatoInsert) VALUES ($valueParam)";
            foreach ($Attributs as $Attribi=>$ValueAttribi){
                //echo ":$Attribi=> $ValueAttribi<br>";
              //  $stmt->bindValue( ':'.$Attribi , $ValueAttribi);
			  
			   if(is_int($ValueAttribi))
                    $param = \PDO::PARAM_INT;
                //si le champs est un boolean
                elseif(is_bool($ValueAttribi))
                    $param = \PDO::PARAM_BOOL;
                //si le champs est un NULL
                elseif(is_null($ValueAttribi))
                    $param = \PDO::PARAM_NULL;
                //si le champs est un string
                elseif(is_string($ValueAttribi))
                    $param = \PDO::PARAM_STR;
                //sinon
                else
                    $param = FALSE;
			  
			  
				$stmt->bindValue( ':'.$Attribi , $ValueAttribi,$param);
				
            }

             $res= $stmt->execute();
			 if(!$res){
				 throw new \Exception("Erreur d'execution de requette : ".$stmt->errorInfo());
				return  false;
			 }
			  
             return self::$dbh->lastInsertId();;
        } catch (\PDOException $e) {
            throw new \Exception("Erreur ! prepare data to insert $table : " . $e->getMessage());

        }
    }


    public static function delete($table,$whereAnd,$whereOR=null){
       // self::connect();
        try {
            $AttributsWhere= self::AttributeExtractor($whereAnd);
            $WhereParam="";

            foreach ($AttributsWhere as $Attrib=>$ValueAttrib){
                $WhereParam.=empty($WhereParam) ? "$Attrib=:$Attrib" : " AND $Attrib=:$Attrib";
            }
            $AttributsWhereOR= self::AttributeExtractor($whereOR);
            foreach ($AttributsWhereOR as $Attrib=>$ValueAttrib){
                $WhereParam.=empty($WhereParam) ? "$Attrib=:$Attrib" : " OR $Attrib=:$Attrib";
            }

            $stmt=self::$dbh->prepare("DELETE FROM $table WHERE $WhereParam");
$datas=[];
            foreach ($AttributsWhere as $Attrib=>$ValueAttrib){
              //  $stmt->bindValue( ":$Attrib" , $ValueAttrib);
                $datas[":$Attrib"]=$ValueAttrib;
            }

            foreach ($AttributsWhereOR as $Attrib=>$ValueAttrib){
              //  $stmt->bindValue( ":$Attrib" , $ValueAttrib);
                $datas[":$Attrib"]=$ValueAttrib;
            }

            $res= $stmt->execute($datas);
            return $res;
        } catch (\PDOException $e) {
            throw new \Exception("Erreur ! prepare data to insert $table : " . $e->getMessage());
        }
    }

    public static function Update($table,$record,$where){
        //self::connect();
        try {

            //construct data to update
            $Attributs= self::AttributeExtractor($record);
            $valueParam="";
            foreach ($Attributs as $Attrib=>$ValueAttrib){
                $valueParam.=empty($valueParam) ? "$Attrib=:$Attrib" : ",$Attrib=:$Attrib";
            }
            ///construct where data
            $AttributsWhere= self::AttributeExtractor($where);
            $WhereParam="";
            foreach ($AttributsWhere as $Attrib=>$ValueAttrib){
                $WhereParam.=empty($WhereParam) ? "$Attrib=:$Attrib" : " AND $Attrib=:$Attrib";
            }

            $stmt=self::$dbh->prepare("UPDATE $table SET $valueParam WHERE $WhereParam");
//echo "UPDATE $table SET $valueParam WHERE $WhereParam";
            foreach ($Attributs as $Attrib=>$ValueAttrib){
                $stmt->bindValue( ":$Attrib" , $ValueAttrib);
            }

            foreach ($AttributsWhere as $Attrib=>$ValueAttrib){
                $stmt->bindValue( ":$Attrib" , $ValueAttrib);
            }

            $res= $stmt->execute();
            return $res;
        } catch (\PDOException $e) {
            throw new \Exception("Erreur ! prepare data to insert $table : " . $e->getMessage());

        }
    }
    public static function DeleteSQL($Sql){
        //self::connect();
        try {
            $data=array();

        $req=self::$dbh->query($Sql);

            return $req;
        } catch (\PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}
