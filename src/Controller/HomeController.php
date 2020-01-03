<?php

namespace App\Controller;

use Cake\View\View;
use http\Env\Request;
use App\Utility\Process;
class HomeController extends AppController
{
    public function view(){
        $this->viewBuilder()->setLayout('home');
        if($this->request->is('post'))
        {
            $process = new Process();
            $process->prd($this->request);
            die();
        }else
        $this->render();
    }

}
