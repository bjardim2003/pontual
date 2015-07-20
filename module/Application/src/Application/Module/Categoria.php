<?php

namespace Application\Module;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as inputFactory;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterAwareInterface;

class Categoria implements InputFilterAwareInterface {

	public $categoria_id;
	public $categoria_nome;

	protected $inputFilter;

	public function exchangeArray($data) {

		$this->categoria_id = (isset($data['categoria_id'])) ? $data['categoria_id'] : null;
		$this->categoria_nome = (isset($data['categoria_nome'])) ? $data['categoria_nome'] : null;
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
				'name' => 'categoria_nome',
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

			$this->inputFilter = $inputFilter;
		}

		return $this->inputFilter;
	}
}