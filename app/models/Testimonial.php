<?php

include_once(__DIR__.'/../config/db.php');

class Testimonial extends Db
{
    public function __construct()
    {
        parent::__construct();
    }


    public function getAllTestimonials() {
        $query = $this->conn->prepare("SELECT p.titre_projet, t.commentaire, t.id_temoignage, o.montant, o.delai, o.id_offre
                                FROM temoignages t
                                JOIN offres o ON t.id_offre = o.id_offre
                                JOIN projets p ON o.id_projet = p.id_projet");
        $query->execute();
        $testimonials = $query->fetchAll(PDO::FETCH_ASSOC);
    
        return $testimonials;
    }

    public function removeTestimonial($id){
        $query = $this->conn->prepare("DELETE FROM temoignages WHERE id_temoignage = :id");
        $stmt = $query->execute([':id' => $id]);
        return $stmt;
    }
}