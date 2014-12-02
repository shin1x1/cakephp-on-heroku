<?php
App::uses('AppController', 'Controller');

class SampleController extends AppController {
    /**
     * session counter
     */
    public function counter(){
        $this->autoRender = false;

        var_dump(Configure::read('Session'));
        $counter = $this->Session->read('counter');
        if (empty($counter)) {
            $counter = 0;
        }
        var_dump($_SESSION);

        $counter++;
        $this->Session->write('counter', $counter);

        var_dump($counter);
    }

}