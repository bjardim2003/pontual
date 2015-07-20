<?php

namespace Application\Module;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class FilmesTable extends AbstractTableGateway {

	protected $table = 'fil_filmes';

	public function __construct(Adapter $adapter){
		$this->adapter = $adapter;
		$this->resultSetPrototype = new ResultSet();
		$this->resultSetPrototype->setArrayObjectPrototype(new Filmes());
		$this->initialize();
	}

	public function fetchAll ($pageNumber = 1, $countPerPage = 2) {
		$select = new Select();
		$select->from($this->table)->order('filmes_nome');

		$adapter = new DbSelect($select, $this->adapter, $this->resultSetPrototype);
		$paginator = new Paginator($adapter);
		$paginator->setCurrentPageNumber($pageNumber);
		$paginator->setItemCountPerPage($countPerPage);

		return $paginator;
	}

	public function getFilmes ($idFilmes) {
		$idFilmes = (int) $idFilmes;

		$rowSet = $this->select(array('filmes_id' => $idFilmes));
		$row = $rowSet->current();

		if (!$row) {
			throw new \Exception('Registro id '.$idFilmes.' não encontrado!');
		}
		return $row;
	}

	public function saveFilmes (Filmes $filmes) {
		$data = array(
			'filmes_nome' => $filmes->filmes_nome,
			'filmes_foto' => $filmes->filmes_foto,
			'filmes_preco' => $filmes->filmes_preco,
			'filmes_status' => $filmes->filmes_status,
			'filmes_descricao' => $filmes->filmes_descricao
		);

		$idFilmes = (int) $filmes->filmes_id;

		if ($idFilmes == 0) {
			$this->insert($data);
		} else {
			if ($this->getFilmes($idFilmes)) {
				$this->update($data, array('filmes_id' => $idFilmes));
			} else {
				throw new \Exception("O filme não foi encontrado com o id ".$idFilmes);
			}
 		}
	}
	
	public function removeFilmes($idFilmes) {
		$idFilmes = (int) $idFilmes;
		
		if ($this->getFilmes($idFilmes)) {
			$this->delete(array('filmes_id' => $idFilmes));
		} else {
			throw new \Exception("O filme não foi encontrado com o id ".$idFilmes);
		}		
	}

}