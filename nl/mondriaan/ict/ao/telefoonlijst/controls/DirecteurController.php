<?php
    namespace nl\mondriaan\ict\ao\telefoonlijst\controls;
    use nl\mondriaan\ict\ao\telefoonlijst\models as MODELS;
    use nl\mondriaan\ict\ao\telefoonlijst\view as VIEW;

    class DirecteurController
    {
        private $action;
        private $control;

        private $view;
        private $model;   
        
        public function __construct($control,$action)
        {
            $this->action = $action;
            $this->control = $control;
            $this->view = new VIEW\view();
            $this->model = new MODELS\DirecteurModel($control,$action);  
            $isGerechtigd = $this->model->isGerechtigd();
            if($isGerechtigd !== true)
            {
                $this->model->uitloggen();
                $this->forward('default','bezoeker');
            }
            
        }
        
        public function execute()
        {
            $opdracht = $this->action."Action";
            if(!method_exists($this,$opdracht))
            {
                $opdracht = "defaultAction";
                $this->action = "default";
            }
            $this->$opdracht();
            $this->view->setAction($this->action);
            $this->view->setControl($this->control);
            $this->view->toon();
        }
        private function forward($action, $control= null)
        {
            if($control !==null)
            {
                $klasseNaam = __NAMESPACE__. '\\'.ucfirst($control).'Controller';
                $controller = new $klasseNaam($action,$control);
            }
            else
            {
                $this->action = $action;
                $controller = $this;// als parameter wordt $ control null
            }
            $controller->execute();
            exit;
        }
        
        private function uitloggen()
        {
            $this->model->uitloggen();
            $this->forward('bezoeker','default');
        }
        
        private function defaultAction()
        {
             $gebruiker=$this->model->getGebruiker();
             $this->view->set('gebruiker',$gebruiker);
             $contacten = $this->model->getContacten();
             if($contacten !==REQUEST_FAILURE_DATA_INVALID)
             {
                 $this->view->set('contacten',$contacten);
             }
             $afdelingen = $this->model->getAfdelingen();
             if($afdelingen !== REQUEST_FAILURE_DATA_INVALID)
             {
                 $this->view->set('afdelingen',$afdelingen);
             }
        }
        
    }
?>
