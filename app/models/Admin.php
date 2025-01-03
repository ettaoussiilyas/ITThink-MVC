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
    public function statuUser($idUser){
        // var_dump($idUser);
        // echo "admin model";
        // die();
        $checkUserStatus = $this->conn->prepare('SELECT * FROM utilisateurs WHERE id_utilisateur = :id_utilisateur');
        $checkUserStatus->execute(['id_utilisateur' => $idUser]);
        $user = $checkUserStatus->fetch(PDO::FETCH_ASSOC);

        if($user['is_active'] == 1){
            $updateStatus = $this->conn->prepare('UPDATE utilisateurs SET is_active = 2 WHERE id_utilisateur = :id_utilisateur');
            $updateStatus->execute(['id_utilisateur' => $idUser]);
        }else{
            $updateStatus = $this->conn->prepare('UPDATE utilisateurs SET is_active = 1 WHERE id_utilisateur = :id_utilisateur');
            $updateStatus->execute(['id_utilisateur' => $idUser]);
        }

    }


}




