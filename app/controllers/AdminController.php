<?php 
require_once (__DIR__.'/../models/User.php');
require_once (__DIR__.'/../models/Admin.php');
require_once (__DIR__.'/../models/Categorie.php');
require_once (__DIR__.'/../models/Projet.php');

class AdminController extends BaseController {
    private $UserModel ;
    private $AdminModel ;
    private $CategorieModel;
    private $ProjetModel;
    public function __construct(){

        $this->UserModel = new User();
        $this->AdminModel = new Admin();
        $this->CategorieModel = new Categorie();
        $this->ProjetModel = new Projet();
  
        
     }

   public function index() {
      
      if(!isset($_SESSION['user_loged_in_id'])){
         header("Location: /login ");
         exit;
      }
     $statistics =  $this->UserModel->getStatistics();
    $this->renderDashboard('admin/index', ["statistics" => $statistics]);
   }
   
   public function categories() {

    $this->renderDashboard('admin/categories');
   }
   public function testimonials() {
 
    $this->renderDashboard('admin/testimonials');
   }
   public function projects() {
  
    $this->renderDashboard('admin/projects');
   }

   public function handleUsers(){
  


    
    // Get filter and search values from GET
    $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all'; // Default to 'all' if no filter is selected
    $userToSearch = isset($_GET['userToSearch']) ? $_GET['userToSearch'] : ''; // Default to empty if no search term is provided
    // var_dump($userToSearch);die();

    // Call showUsers with both filter and search term
    $users = $this->UserModel->getAllUsers($filter, $userToSearch);
    $this->renderDashboard('admin/users',["users"=> $users]);
   }

    
   public function removeUser(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
   
            $idUser = $_POST['remove_user'];
            $this->AdminModel->removeUser($idUser);
            header('Location: /admin/users');
            
        }
    }
   public function statuUser(){

        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_statu_id'])){
            
            $idUser = $_POST['user_statu_id'];
            $this->AdminModel->statuUser($idUser);
            header('Location: /admin/users');
            
        }
    }


    public function getAllCategories(){
        // var_dump($userToSearch);die();
    
        // Call showUsers with both filter and search term
        $categories = $this->CategorieModel->getAllCategories();
        $this->renderDashboard('admin/categories',["categories"=> $categories]);
    }

    //remove categorie or subcategorie
    public function removeCatAndSubcat(){
        if ($_SERVER["REQUEST_METHOD"] == "POST"&& isset($_POST["delete"])){

            $id = $_POST['id_type'];
            $type = $_POST['delete'];
            $this->CategorieModel->removeCatAndSubcat($id , $type);
            header('Location: /admin/categories');
            
        }
    }
    

    public function addModifySubcategory(){
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["add-modify-subcategory"])){
            
            $name = $_POST['subcategory_name_input'];
            $id = $_POST['subcategory_id_input'];
            $parent_category_id = $_POST['category_parent_id_input'];
            $this->CategorieModel->addModifySubcategory($name,$id,$parent_category_id);
            header('Location: /admin/categories');
        }
        
    }
    public function addModifyCategory(){

        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["add-modify-category"])){
            
            $name = $_POST['category_name_input'];
            $id = $_POST['category_id_input'];
            $this->CategorieModel->addModifyCategory($name,$id);
            header('Location: /admin/categories');
        }
        
    }

    public function getProjets() {
        $filter_by_cat = isset($_GET['filter_by_cat']) ? $_GET['filter_by_cat'] : 'all';
        $filter_by_sub_cat = isset($_GET['filter_by_sub_cat']) ? $_GET['filter_by_sub_cat'] : 'all';
        $projectToSearch = isset($_GET['projectToSearch']) ? $_GET['projectToSearch'] : '';
        $filter_by_status = isset($_GET['filter_by_status']) ? $_GET['filter_by_status'] : '';
        $projects = $this->ProjetModel->getAllProjects($filter_by_cat, $filter_by_sub_cat,$filter_by_status, $projectToSearch);
        $categories = $this->CategorieModel->getAllCategories();
        $this->renderDashboard('admin/projects',["projects" => $projects,"categories" => $categories]);
     }


    public function removeProjet(){
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_project'])){
            
            $idProject = $_POST['id_projet'];
            $this->ProjetModel->removeProject($idProject);
            header('Location: /admin/projects');
            
        }
    }

}
 

