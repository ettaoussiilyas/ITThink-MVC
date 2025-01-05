<?php

    require_once (__DIR__.'/../models/Client.php');
    // require_once (__DIR__.'/../core/BaseController.php');

    class ClientController extends BaseController {

        private $ClientModel;

        public function __construct()
        {
            $this->ClientModel = new Client();
        }

        public function index() {
            $statistics  = $this->ClientModel->getStatistics();
            $this->renderClient('index' , $statistics);
        }
        public function testimonials() {

            $this->renderClient('testimonials');
        }
        public function offers() {

            $this->renderClient('offers');
        }
        public function projects() {

            $this->renderClient('offers');
        }
    }
















?>