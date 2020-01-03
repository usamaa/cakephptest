<?php

namespace App\Controller;

use Cake\View\View;
use http\Env\Request;
use App\Utility\CaseMessage;
class HomeController extends AppController
{
    public function view(){
        $this->viewBuilder()->setLayout('home');
        if($this->request->is('post'))
        {
            $data = new \stdClass();
            $data->dc = $this->request->getData('defendent');
            $data->pc = $this->request->getData('plaintiff');
            $data->dncr = $this->request->getData('dncr') == 'on';
            $data->idncr = $this->request->getData('idncl') == 'on';
            $data->tiaa = $this->request->getData('tiaa') == 'on';
            $process = new CaseMessage($data);
            $this->set('message', $process->getMessage());
        }else
            $this->set('message', 'No message yet.');
        $this->render();
    }

}
