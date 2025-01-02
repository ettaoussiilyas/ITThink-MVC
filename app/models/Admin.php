<?php 
require_once(__DIR__.'/../config/db.php');
class Admin extends Db {
    
    public function __construct()
    {
        parent::__construct();
    }

    public function removeUser($idUser){
        
        $removeProject = $this->conn->prepare('DELETE FROM projets WHERE id_utilisateur = :id_utilisateur');
        $removeProject->execute(['id_utilisateur' => $idUser]);

        $removeUser = $this->conn->prepare("DELETE FROM utilisateurs WHERE id_utilisateur=?");
        $removeUser->execute([$idUser]);

    }


}




