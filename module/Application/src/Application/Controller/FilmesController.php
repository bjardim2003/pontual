<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Application\Form\FilmesForm;
use Application\Module\Filmes;
use Zend\Validator\File\Size;
use Zend\File\Transfer\Adapter\Http;

class FilmesController extends AbstractActionController {

	protected $filmesTable;
	protected $categoryTable;

	public function getFilmesTable() {
		if (!$this->filmesTable) {
			$sm = $this->getServiceLocator();
			$this->filmesTable = $sm->get('filmes_table');
		}
		return $this->filmesTable;
	}

	public function getCategoryTable() {
		if (!$this->categoryTable) {
			$sm = $this->getServiceLocator();
			$this->categoryTable = $sm->get('categoria_table');
		}
		return $this->categoryTable;
	}

	public function indexAction() {
		$messages = $this->flashMessenger()->getMessages();

		$pageNumber = (int) $this->params()->fromQuery('pagina');
		if ($pageNumber == 0) {
			$pageNumber = 1;
		}

		$filmes = $this->getFilmesTable()->fetchAll($pageNumber, 10);

		return new ViewModel(array(
			'messages' => $messages,
			'filmes' => $filmes,
			'title' => 'Filmes'
		));
	}

	public function novoAction() {
		$form = new FilmesForm();

		$request = $this->getRequest();

		if ($request->isPost()) {

			$filmes = new Filmes();

			$nonFile = $request->getPost()->toArray();
			$File = $this->params()->fromFiles('filmes_foto');
			if ($File['name'] == "") {
				$name_file = null;
			} else {
				$name_file = $File['name'];
			}
			$data = array_merge($nonFile, array('filmes_foto' => $name_file));

			$form->setInputFilter($filmes->getInputFilter());
			$form->setData($data);
			if ($form->isValid()) {

				if ($File['name'] != "") {
					$size = new Size(array('max' => 2000000));
					$adapter = new Http();
					$adapter->setValidators(array($size), $File['name']);

					if (!$adapter->isValid()){
						$dataError = $adapter->getMessages();
						$erro = array();
						foreach ($dataError as $row) {
							$erro[] = $row;
						}
						$form->setMessages(array('filmes_foto' => $erro));
					} else {

						$diretorio = $request->getServer()->DOCUMENT_ROOT . '/conteudo/filmes';
						$adapter->setDestination($diretorio);
						if ($adapter->receive($File['name'])) {
							$this->flashMessenger()->addMessage(array('success' => 'A foto foi enviada com sucesso!'));
						} else {
							$this->flashMessenger()->addMessage(array('danger' => 'A foto não foi enviada!'));
						}

					}
				}

				$filmes->exchangeArray($data);
				$this->getFilmesTable()->saveFilmes($filmes);

				$this->flashMessenger()->addMessage(array('success' => 'Cadastro efetuado com sucesso!'));
				$this->redirect()->toUrl("/filmes");

			}

		}

		$categories = $this->getCategoryTable()->getAllFormArray();
		$form->get('categoria_id')->setValueOptions($categories);

		$view = new ViewModel(array(
				'form' => $form
		));

		$view->setTemplate('application/filmes/form.phtml');

		return $view;
	}

	public function editarAction() {
		$id = $this->params('id');

		$filme = $this->getFilmesTable()->getFilmes($id);
		$form = new FilmesForm();
		$form->setBindOnValidate(false);
		$form->get('submit')->setLabel('Alterar');

		$categories = $this->getCategoryTable()->getAllFormArray();
		$form->get('categoria_id')->setValueOptions($categories);

		$form->bind($filme);

		$request = $this->getRequest();

		if ($request->isPost()) {

			$nonFile = $request->getPost()->toArray();
			$File = $this->params()->fromFiles('filmes_foto');
			if ($File['name'] == "") {
				$name_file = $filme->filmes_foto;
			} else {
				$name_file = $File['name'];
			}
			$data = array_merge($nonFile, array('filmes_foto' => $name_file));


			$form->setData($data);

			if ($form->isValid()) {
				$form->bindValues();
				if ($File['name'] != "") {
					$size = new Size(array('max' => 2000000));
					$adapter = new Http();
					$adapter->setValidators(array($size), $File['name']);

					if (!$adapter->isValid()){
						$dataError = $adapter->getMessages();
						$erro = array();
						foreach ($dataError as $row) {
							$erro[] = $row;
						}
						$form->setMessages(array('filmes_foto' => $erro));
					} else {

						$diretorio = $request->getServer()->DOCUMENT_ROOT . '/conteudo/filmes';
						$adapter->setDestination($diretorio);
						if ($adapter->receive($File['name'])) {
							$this->flashMessenger()->addMessage(array('success' => 'A foto foi enviada com sucesso!'));
						} else {
							$this->flashMessenger()->addMessage(array('danger' => 'A foto não foi enviada!'));
						}

						$this->getFilmesTable()->saveFilmes($filme);
						$this->flashMessenger()->addMessage(array('success' => 'Registro alterado com sucesso!'));
						$this->redirect()->toUrl("/filmes");
					}
				}

			}

		}

		$view = new ViewModel(array(
			'form' => $form
		));
		$view->setTemplate('application/filmes/form.phtml');

		return $view;
	}

	public function removeAction() {
		$id = $this->params('id');

		$this->getFilmesTable()->removeFilmes($id);
		$this->flashMessenger()->addMessage(array('success' => 'Registro removido com sucesso!'));
		$this->redirect()->toUrl("/categoria");

	}
}