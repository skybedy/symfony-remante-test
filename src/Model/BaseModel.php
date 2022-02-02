<?php
    namespace App\Model;
    
    use Doctrine\DBAL\Connection;

    class BaseModel{
        
        public function VyrobceList($conn){
            $sql1 = "SELECT * FROM vyrobce ORDER BY vyrobce_nazev ASC";
            $dbData = $conn->fetchAllAssociative($sql1);
            if(count($dbData) > 0){
                return $dbData;
            }
        }
    
        public function TypProduktuList(Connection $conn){
            $sql1 = "SELECT * FROM typ_produktu ORDER BY typ_produktu_nazev ASC";
            $dbData = $conn->fetchAllAssociative($sql1);
            if(count($dbData) > 0){
                return $dbData;
            }
        }
    
    }

?>