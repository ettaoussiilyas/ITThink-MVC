<?php 
require_once (__DIR__.'/../models/User.php');
require_once (__DIR__.'/../models/Admin.php');
require_once (__DIR__.'/../models/Categorie.php');

class AdminController extends BaseController {
    private $UserModel ;
    private $AdminModel ;
    private $CategorieModel;
    public function __construct(){

        $this->UserModel = new User();
        $this->AdminModel = new Admin();
        $this->CategorieModel = new Categorie();
  
        
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
    

    // // function to block user
    // function changeStatus($idUser){
    //     include '../connection.php';

    //     // get the old status
    //     $stmt = $conn->prepare("SELECT is_active FROM utilisateurs WHERE id_utilisateur = ?");
    //     $stmt->execute([$idUser]);
    //     $currentStatus = $stmt->fetchColumn();

    //     $changeStatus = $conn->prepare("UPDATE utilisateurs SET is_active=? WHERE id_utilisateur=?");
    //     $changeStatus->execute([$currentStatus==0?1:0,$idUser]);
    // }
    // // check the post request to block the user
    // if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['block_user_id'])) {
    //     $idUser = $_POST['block_user_id'];
    //     changeStatus($idUser);
    //     // Redirect to avoid form resubmission after page reload
    //     header("Location: users.php");
    //     exit();
    // }


 

}