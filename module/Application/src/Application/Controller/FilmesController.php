<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Application\Form\FilmesForm;

class FilmesController extends AbstractActionController {
	public function indexAction() {
		
	}
	
	public function novoAction() {
		$form = new FilmesForm();
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$data = $request->getPost();
			
			var_dump($data);
		}
		
		$view = new ViewModel(array(
				'form' => $form
		));
		
		$view->setTemplate('application/filmes/form.phtml');
		
		return $view;
	}
}