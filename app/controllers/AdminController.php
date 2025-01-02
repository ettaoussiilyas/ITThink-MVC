<?php 
require_once (__DIR__.'/../models/User.php');

class AdminController extends BaseController {
    private $UserModel ;
    public function __construct(){

        $this->UserModel = new User();
  
        
     }

   public function index() {
      
      if(!isset($_SESSION['user_loged_in_id'])){
         header("Location: /login ");
         exit;
      }
     $statistics =  $this->UserModel->getStatistics();
    $this->renderDashboard('admin/index', ["statistics" => $statistics]);
   }
   public function users() {
    //   // var_dump($_SESSION['user_loged_in_id']);die();
    //   if(!isset($_SESSION['user_loged_in_id'])){
    //      header("Location: /login ");
    //      exit;
    //   }
    //  $statistics =  $this->UserModel->getStatistics();
    $this->renderDashboard('admin/users');
   }



 

}