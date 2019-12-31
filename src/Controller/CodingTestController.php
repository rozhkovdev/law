<?php
namespace App\Controller;


class CodingTestController extends AppController
{
    public function template(){
        $this->viewBuilder()->setLayout('document');
        $this->viewBuilder()->setHelpers(array('Document'));

        $plaintiffs = [
            'Jesse Seale',
            'Nils Coleman',
            'Brad Daw',
            'Yon Beny',
            'Tom Lew',
            'Sara Kall'
        ];

        $defendants = [
            'GoSmith, Inc',
            'Bret Merreli',
            'Sam Guru',
            'Tony Lee',
        ];

        $dncrViolation = true;
        $idnclViolation = true;
        $tiaaViolation = true;

        $this->set(compact(
            'plaintiffs',
            'defendants',
            'dncrViolation',
            'idnclViolation',
            'tiaaViolation'
        ));
    }

}
