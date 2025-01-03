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

        public function addModifySubcategory($name,$id,$parent_category_id){                    
        
          
                        // create a new subcategory if id not gived
        if($id==0){
            try {
                $AddSubCategoryQuery = $this->conn->prepare("INSERT INTO sous_categories (nom_sous_categorie, id_categorie) VALUES (:subcategory_name, :category_id)");
                $AddSubCategoryQuery->execute([':subcategory_name' => $name,':category_id' => $parent_category_id]);
            } catch (PDOException $e) {
                echo "Database Error: " . $e->getMessage();
            }
        }else{// modify subcategory if id gived
            try {
                $modifySubCategoryQuery = $this->conn->prepare("UPDATE sous_categories SET nom_sous_categorie = ? WHERE id_sous_categorie = ?");
                $modifySubCategoryQuery->execute([$id]);
            } catch (PDOException $e) {
                echo "Database Error: " . $e->getMessage();
            }
        }
                        
    
             
        
        }
        public function addModifyCategory($name,$id){
            //add or modify a category based on the id if the id is not empty we will modify the category else we will add a new category
  
            $category_name = trim($_POST["category_name_input"]);
            $category_id = isset($_POST["category_id_input"]) ? trim($_POST["category_id_input"]) : '';
        
            if (!empty($category_name)) {
                // create a new category if id not gived
                if($category_id==0){
                    try {
                        $AddCategoryQuery = $this->conn->prepare("INSERT INTO categories (nom_categorie) VALUES (:category_name)");
                        $AddCategoryQuery->execute([':category_name' => $category_name]);
    
                    } catch (PDOException $e) {
                        echo "Database Error: " . $e->getMessage();
                    }
                }else{ // modify category if id gived
                    try {
                        $modifyCategoryQuery = $this->conn->prepare("UPDATE categories SET nom_categorie = ? WHERE id_categorie = ?");
                        $modifyCategoryQuery->execute([$category_name,$category_id]);
    
                    } catch (PDOException $e) {
                        echo "Database Error: " . $e->getMessage();
                    }
                }
                        
            } 
            
        }

    }




?>