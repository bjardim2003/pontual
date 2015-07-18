<?php

namespace Application\Form;

use Zend\Form\Form;

use Zend\Form\Element;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Element\File;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Button;


class FilmesForm extends Form {
	
	public function __construct($name = null) {
		
		parent::__construct('filmes');
	
		$id   = new Hidden('filmes_id');
		
		$nome = new Text('filmes_nome');
		$nome->setLabel('Nome: ');
		$nome->setAttributes(array(
				'class' => 'form-control',
				'id'    => 'filmes_nome'
		));

		$preco = new Text('filmes_preco');
		$preco->setLabel('Valor Aluguel: ');
		$preco->setAttributes(array(
				'class' => 'form-control',
				'id'    => 'filmes_preco'
		));	
		
		$foto = new File('filmes_foto');
		$foto->setLabel('Cartaz: ');
		$foto->setAttributes(array(
				'class' => 'form-control'
		));		

		$descricao = new Textarea('filmes_descricao');
		$descricao->setLabel('Dados do Filme: ');
		$descricao->setAttributes(array(
				'style' => 'height: 100px;',
				'class' => 'form-control',
				'id'    => 'filmes_descricao'
		));		
	
		$status = new Checkbox('filmes_status');
		$status->setLabel("Mostrar?");
		$status->setValue(1);
		
		$submit = new Button('submit');
		$submit->setLabel('Cadastrar');
		$submit->setAttributes(array(
				'type' => 'submit',
				'class' => 'btn btn-default',
		));
		
		$this->add($id);
		$this->add($nome);
		$this->add($preco);
		$this->add($foto);
		$this->add($descricao);
		$this->add($status);
		$this->add($submit);
		
	}
	
}