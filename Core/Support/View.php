<?php
namespace App\Core\Support;

use App\Core\Foundation\Support\Tent as SupportTent;
use App\Core\Support\Facades\App;
use App\Core\Support\Tent;


class View {

    protected ?string $view;



    public function __construct()
    {
        $this->view = null;
    }

    public static function render(string $viewPath) {

        $view = new self();
        //App:: register global view files for certain views

        App::instance('view', $view); //binds a singleton

        echo $view->renderView($viewPath);

        return $view;
    }

    protected function renderView($viewPath) {
    
        return Tent::putUp($viewPath);
    }


}