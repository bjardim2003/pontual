<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Application\Form\CategoriaForm;
use Application\Module\Categoria;
use Zend\Validator\File\Size;
use Zend\File\Transfer\Adapter\Http;

class CategoriaController extends AbstractActionController {

	protected $categoriaTable;

	public function getCategoriaTable() {
		if (!$this->categoriaTable) {
			$sm = $this->getServiceLocator();
			$this->categoriaTable = $sm->get('categoria_table');
		}
		return $this->categoriaTable;
	}

	public function indexAction() {
		$messages = $this->flashMessenger()->getMessages();

		$pageNumber = (int) $this->params()->fromQuery('pagina');
		if ($pageNumber == 0) {
			$pageNumber = 1;
		}

		$categoria = $this->getCategoriaTable()->fetchAll($pageNumber, 10);		
		
		return new ViewModel(array(
			'messages' => $messages,
			'categoria' => $categoria,
			'title' => 'Categoria'
		));
	}
	
	public function novoAction() {
		$form = new CategoriaForm();

		$request = $this->getRequest();

		if ($request->isPost()) {

			$categoria = new Categoria();

			$data = $request->getPost()->toArray();

			$form->setInputFilter($categoria->getInputFilter());
			$form->setData($data);
			
			if ($form->isValid()) {

				$categoria->exchangeArray($data);
				$this->getCategoriaTable()->saveCategoria($categoria);

				$this->flashMessenger()->addMessage(array('success' => 'Cadastro efetuado com sucesso!'));
				$this->redirect()->toUrl("/categoria");

			}

		}

		$view = new ViewModel(array(
				'form' => $form
		));

		$view->setTemplate('application/categoria/form.phtml');

		return $view;
	}

	public function editarAction() {
		$id = $this->params('id');

		$filme = $this->getCategoriaTable()->getCategoria($id);
		$form = new CategoriaForm();
		$form->setBindOnValidate(false);
		$form->bind($filme);
		$form->get('submit')->setLabel('Alterar');

		$request = $this->getRequest();

		if ($request->isPost()) {
			$data = $request->getPost()->toArray();

			$form->setData($data);

			if ($form->isValid()) {
				$form->bindValues();

				$this->getCategoriaTable()->saveCategoria($filme);
				$this->flashMessenger()->addMessage(array('success' => 'Registro alterado com sucesso!'));
				$this->redirect()->toUrl("/categoria");

			}

		}

		$view = new ViewModel(array(
			'form' => $form
		));
		$view->setTemplate('application/categoria/form.phtml');

		return $view;
	}

	public function removeAction() {
		$id = $this->params('id');

		$this->getCategoriaTable()->removeCategoria($id);
		$this->flashMessenger()->addMessage(array('success' => 'Registro removido com sucesso!'));
		$this->redirect()->toUrl("/categoria");

	}
}