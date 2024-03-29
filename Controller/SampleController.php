<?php
App::uses('AppController', 'Controller');

class SampleController extends AppController {
    /**
     * session counter
     */
    public function counter(){
        $this->autoRender = false;

        $counter = $this->Session->read('counter');
        if (empty($counter)) {
            $counter = 0;
        }

        $counter++;
        $this->Session->write('counter', $counter);

        var_dump($counter);
    }

}