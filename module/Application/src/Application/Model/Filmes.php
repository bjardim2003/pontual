<?php

namespace Application\Module;

use Zend\InputFilter\InputFilterAwareInterface;

class Filmes implements InputFilterAwareInterface {

	public $filmes_id;
	public $filmes_nome;
	public $filmes_descricao;
	public $filmes_preco;
	public $filmes_status;
	public $filmes_foto;

	protected $inputFilter;

	public function exchangeArray($data) {

		$this->$filmes_id        = (isset($data['filmes_id'])) ? $data['filmes_id'] : null;
		$this->$filmes_nome      = (isset($data['filmes_nome'])) ? $data['filmes_nome'] : null;
		$this->$filmes_descricao = (isset($data['filmes_descricao'])) ? $data['filmes_descricao'] : null;
		$this->$filmes_preco 	 = (isset($data['filmes_preco'])) ? $data['filmes_preco'] : null;
		$this->$filmes_status    = (isset($data['filmes_status'])) ? $data['filmes_status'] : null;
		$this->$filmes_foto      = (isset($data['filmes_foto'])) ? $data['filmes_foto'] : null;
	}
}