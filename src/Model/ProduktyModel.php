<?php
    
    namespace App\Model;

    class ProduktyModel{
        private $limitCount = 10;
        
        public function ProductList($conn,$vyrobce_id,$typ_produktu_id,$from,$order){
            $return = Array();
            $sql = "SELECT COUNT(produkt_id) AS pocet FROM produkty WHERE typ_produktu_id = ? AND vyrobce_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1, $vyrobce_id);
            $stmt->bindValue(2, $typ_produktu_id);
            $dbData = $stmt->executeQuery()->fetchAll();
            $return[] = $dbData[0]['pocet'];
            $sql = "SELECT produkt_id,UPPER(produkt_nazev) AS produkt_nazev,produkt_cena FROM produkty WHERE typ_produktu_id = ? AND vyrobce_id = ? ORDER BY $order ASC LIMIT ?,?";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1, $vyrobce_id);
            $stmt->bindValue(2, $typ_produktu_id);
            $stmt->bindValue(3, $from,\PDO::PARAM_INT);
            $stmt->bindValue(4, $this->limitCount,\PDO::PARAM_INT);
            $dbData = $stmt->executeQuery()->fetchAllAssociative();
            $return[] = $dbData;
            return $return;
        }

        public function ProduktEditForm($conn,$produkt_id){
            $sql = "SELECT * FROM produkty WHERE produkt_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1, $produkt_id);
            $dbData = $stmt->executeQuery()->fetchAllAssociative();
            return $dbData;
        }

        public function ProduktEdit($conn,$produkt_id,$produkt_cena, $produkt_nazev,$typ_produktu_id,$vyrobce_id,$from)
        {
            $return = Array();
            $sql0 = "UPDATE produkty SET produkt_nazev = '$produkt_nazev',produkt_cena = '$produkt_cena' WHERE produkt_id = $produkt_id";
            $stmt0 = $conn->query($sql0);
            $sql = "SELECT produkt_id,UPPER(produkt_nazev) AS produkt_nazev,produkt_cena FROM produkty WHERE produkt_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1, $produkt_id);
            $dbData = $stmt->executeQuery()->fetchAllAssociative();
            $return[] = $dbData;
            return $return;
        }
    }

?>