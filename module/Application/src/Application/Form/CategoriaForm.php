<?php

namespace Application\Form;

use Zend\Form\Form;

use Zend\Form\Element;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Text;
use Zend\Form\Element\Button;


class CategoriaForm extends Form {

	public function __construct($name = null) {

		parent::__construct('categoria');

		$id   = new Hidden('categoria_id');

		$nome = new Text('categoria_nome');
		$nome->setLabel('Nome: ');
		$nome->setAttributes(array(
				'class' => 'form-control',
				'id'    => 'categoria_nome'
		));

		$submit = new Button('submit');
		$submit->setLabel('Cadastrar');
		$submit->setAttributes(array(
				'type' => 'submit',
				'class' => 'btn btn-success'
		));

		$cancel = new Button('cancel');
		$cancel->setLabel('Cancelar');
		$cancel->setAttributes(array(
				'type' => 'button',
				'class' => 'btn btn-default',
				'onclick' => 'javascript:history.go(-1)'
		));

		$this->add($id);
		$this->add($nome);
		$this->add($submit);
		$this->add($cancel);

	}
}