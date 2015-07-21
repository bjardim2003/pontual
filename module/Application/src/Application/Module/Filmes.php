<?php

namespace Application\Module;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as inputFactory;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterAwareInterface;

class Filmes implements InputFilterAwareInterface {

	public $filmes_id;
	public $filmes_nome;
	public $filmes_descricao;
	public $filmes_preco;
	public $filmes_status;
	public $filmes_foto;
	public $categoria_id;

	protected $inputFilter;

	public function exchangeArray($data) {

		$this->filmes_id = (isset($data['filmes_id'])) ? $data['filmes_id'] : null;
		$this->filmes_nome = (isset($data['filmes_nome'])) ? $data['filmes_nome'] : null;
		$this->filmes_descricao = (isset($data['filmes_descricao'])) ? $data['filmes_descricao'] : null;
		$this->filmes_preco = (isset($data['filmes_preco'])) ? $data['filmes_preco'] : null;
		$this->filmes_status = (isset($data['filmes_status'])) ? $data['filmes_status'] : null;
		$this->filmes_foto = (isset($data['filmes_foto'])) ? $data['filmes_foto'] : null;
		$this->categoria_id = (isset($data['categoria_id'])) ? $data['categoria_id'] : null;
	}

	public function getArrayCopy () {
		return get_object_vars($this);
	}

	public function setInputFilter(InputFilterInterface $inputFilter) {
		throw new \Exception('Not used');
	}

	public function getInputFilter() {
		if(!$this->inputFilter) {
			$inputFilter = new InputFilter();

			$factory = new inputFactory();

			$inputFilter->add($factory->createInput(array(
					'name' => 'filmes_foto',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim')
					)
			)));


			$inputFilter->add($factory->createInput(array(
				'name' => 'filmes_nome',
				'required' => true,
				'filters' => array(
						array('name' => 'StripTags'),
						array('name' => 'StringTrim')
				),
				'validators' => array(
						array(
							'name' => 'NotEmpty',
							'options' => array(
								'messages' => array(
									'isEmpty' => 'Nome deve ser diferente de branco.'
								)
							)
						)
				)
			)));

			$inputFilter->add($factory->createInput(array(
				'name' => 'filmes_preco',
				'required' => true,
				'filters' => array(
						array('name' => 'StripTags'),
						array('name' => 'StringTrim')
				),
				'validators' => array(
					array(
						'name' => 'NotEmpty',
						'options' => array(
							'messages' => array(
								'isEmpty' => 'Valor do Aluguel deve ser diferente de branco.'
							)
						)
					)
				)

			)));

			$inputFilter->add($factory->createInput(array(
				'name' => 'categoria_id',
				'required' => true,
				'filters' => array(
						array('name' => 'Digits'),
				),
				'validators' => array(
					array(
						'name' => 'NotEmpty',
						'options' => array(
							'messages' => array(
								'isEmpty' => 'Categoria deve ser setada',
							)
						)
					)
				)

			)));

			$inputFilter->add($factory->createInput(array(
				'name' => 'filmes_descricao',
				'required' => true,
				'filters' => array(
						array('name' => 'StripTags'),
						array('name' => 'StringTrim')
				),
				'validators' => array(
						array(
							'name' => 'NotEmpty',
							'options' => array(
								'messages' => array(
									'isEmpty' => 'Descrição deve ser diferente de branco.'
								)
							)
						),
						array(
								'name' => 'StringLength',
								true,
								'options' => array(
										'ecoding' => 'UTF-8',
										'min' => 10,
										'max' => 500,
										'message' => 'Descrição deve conter entre 10 e 500 caracteres.'
								)
						)
				)
			)));

			$this->inputFilter = $inputFilter;
		}

		return $this->inputFilter;
	}
}