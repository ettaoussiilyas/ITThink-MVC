<?php

    require_once (__DIR__.'/../models/Client.php');

    class ClientController extends BaseController {

        public function index() {

            $this->renderClient('index');
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