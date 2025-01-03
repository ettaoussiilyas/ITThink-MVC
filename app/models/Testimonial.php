<?php

include_once(__DIR__.'/../config/db.php');

class Testimonial extends Db
{
    public function __construct()
    {
        parent::__construct();
    }

    // public function getAllTestimonials(){

    //     $query = $this->conn->prepare("SELECT p.titre_projet,t.commentaire,t.id_temoignage,o.montant,o.delai,o.id_offre
    //     FROM temoignages t
    //     RIGHT JOIN offres o ON t.id_offre=o.id_offre
    //     JOIN projets p ON o.id_projet=p.id_projet);
    //     WHERE o.id_utilisateur=p.id_utilisateur");
    //     // WHERE o.id_utilisateur=?");
    //     $query->execute();
    //     // $query->execute([$_SESSION['user_loged_in_id']]);
    //     $clientTestimonials = $query->fetchAll(PDO::FETCH_ASSOC);

    //     return $clientTestimonials;
    // }
    function getAllTestimonials() {
        $query = $this->conn->prepare("SELECT p.titre_projet, t.commentaire, t.id_temoignage, o.montant, o.delai, o.id_offre
                                FROM temoignages t
                                JOIN offres o ON t.id_offre = o.id_offre
                                JOIN projets p ON o.id_projet = p.id_projet");
        $query->execute();
        $testimonials = $query->fetchAll(PDO::FETCH_ASSOC);
    
        return $testimonials;
    }
}