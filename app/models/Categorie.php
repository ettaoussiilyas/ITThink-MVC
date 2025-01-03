<?php
    require_once(__DIR__.'/../config/db.php');
    class Categorie extends Db{

        public function __construct(){
            parent::__construct();
        }
        
        public function getAllCategories(){

            try {
                $query = $this->conn->prepare("
                    SELECT 
                        c.id_categorie,
                        c.nom_categorie,
                        sc.id_sous_categorie,
                        sc.nom_sous_categorie
                    FROM 
                        categories c
                    LEFT JOIN 
                        sous_categories sc ON c.id_categorie = sc.id_categorie
                ");
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_ASSOC);
        
                $categories = [];
                foreach ($results as $row) {
                    $id_categorie = $row['id_categorie'];
        
                    // Initialize category if not present
                    if (!isset($categories[$id_categorie])) {
                        $categories[$id_categorie] = [
                            'id_categorie' => $id_categorie,
                            'nom_categorie' => $row['nom_categorie'],
                            'sous_categories' => []
                        ];
                    }
        
                    // Add subcategories
                    if (!empty($row['id_sous_categorie'])) {
                        $categories[$id_categorie]['sous_categories'][] = [
                            'id_sous_categorie' => $row['id_sous_categorie'],
                            'nom_sous_categorie' => $row['nom_sous_categorie']
                        ];
                    }
                }
        
                return $categories;
        
            } catch (PDOException $e) {
                echo "Database Error: " . $e->getMessage();
                return [];
            }

        }


        public function removeCatAndSubcat($id , $type){
            //remove the category or subcategory base on the type if the type is category we well remove the category and all its subcategories

            if($type == 'category'){
                $query = $this->conn->prepare("DELETE FROM categories WHERE id_categorie =?");
                $query->execute([$id]);
            }

            if($type == 'sub_category'){
                $query = $this->conn->prepare("DELETE FROM sous_categories WHERE id_sous_categorie =?");
                $query->execute([$id]); 
            }

        }

    }




?>