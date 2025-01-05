<?php

    include_once __DIR__.'/../config/db.php';

    class Client extends Db{

        public function __construct(){
            parent:: __construct();
        }

        public function getStatistics(){

                $statistics = [];
        
                // Total number of users
                $query = $this->conn->prepare("SELECT COUNT(*) AS total_users FROM utilisateurs");
                $query->execute();
                $statistics['total_users'] = $query->fetch(PDO::FETCH_ASSOC)['total_users'];
        
                // Total number of published projects
                $query = $this->conn->prepare("SELECT COUNT(*) AS total_projects FROM projets");
                $query->execute();
                $statistics['total_projects'] = $query->fetch(PDO::FETCH_ASSOC)['total_projects'];
        
                // Total number of freelancers
                $query = $this->conn->prepare("SELECT COUNT(*) AS total_freelancers FROM utilisateurs WHERE role = '3'");
                $query->execute();
                $statistics['total_freelancers'] = $query->fetch(PDO::FETCH_ASSOC)['total_freelancers'];
        
                // Number of ongoing offers (status = 2)
                $query = $this->conn->prepare("SELECT COUNT(*) AS ongoing_offers FROM offres WHERE status = 2");
                $query->execute();
                $statistics['ongoing_offers'] = $query->fetch(PDO::FETCH_ASSOC)['ongoing_offers'];
        
                return $statistics;
        
        }
    }


?>