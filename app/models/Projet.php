<?php

    require_once(__DIR__.'/../config/db.php');

    class Projet extends Db{

        public function __construct(){
            parent::__construct();
        }

        
        public function getAllProjects($filter_by_cat, $filter_by_sub_cat,$filter_by_status, $projectToSearch = ''){

            $query = "SELECT p.id_projet, p.titre_projet, p.description,
                             p.id_categorie, p.id_sous_categorie, p.id_utilisateur,
                             p.project_status, c.nom_categorie AS nom_categorie,
                             sc.nom_sous_categorie AS nom_sous_categorie
                    FROM projets p
                    JOIN categories c ON c.id_categorie = p.id_categorie
                    JOIN sous_categories sc ON sc.id_sous_categorie = p.id_sous_categorie
                    WHERE 1=1";

            $params = [];

            // Add filter by category if not 'all'
            if ($filter_by_cat !== 'all') {
                $query .= " AND c.nom_categorie = :filter_by_cat";
                $params['filter_by_cat'] = $filter_by_cat;
            }

            // Add filter by subcategory if not 'all'
            if ($filter_by_sub_cat !== 'all') {
                $query .= " AND sc.nom_sous_categorie = :filter_by_sub_cat";
                $params['filter_by_sub_cat'] = $filter_by_sub_cat;
            }

            // Add filter by status if not 'all'
            if (!empty($filter_by_status) && $filter_by_status !== 'all') {
                $query .= " AND p.project_status = :filter_by_status";
                $params['filter_by_status'] = $filter_by_status;
            }

            // Add search condition if a search term is provided
            if ($projectToSearch) {
                $query .= " AND p.titre_projet LIKE :search_term";
                $params['search_term'] = "%$projectToSearch%";
            }

            // Prepare and execute the query
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);

            // Fetch and return results
            $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $projects;
        }
    }