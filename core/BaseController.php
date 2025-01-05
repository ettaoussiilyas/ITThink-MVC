<?php 

class BaseController
{
    // Render a view
    public function render($view, $data = [])
    {
        
        extract($data);
        include __DIR__ . '/../app/views/' . $view . '.php';
    }
    public function renderDashboard($view, $data = [])
    {
        extract($data);
        include __DIR__ . '/../app/views/dashboard/' . $view . '.php';
    }

    public function renderClient($view, $data = [])
    {
        // echo 'base';
        // print_r($data);
        // die();
        extract($data);
        include __DIR__ . '/../app/views/client/' . $view . '.php';
    }
   
   
}
