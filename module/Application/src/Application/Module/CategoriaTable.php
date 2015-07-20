<?php

namespace Application\Module;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class CategoriaTable extends AbstractTableGateway {

	protected $table = 'fil_categoria';

	public function __construct(Adapter $adapter){
		$this->adapter = $adapter;
		$this->resultSetPrototype = new ResultSet();
		$this->resultSetPrototype->setArrayObjectPrototype(new Categoria());
		$this->initialize();
	}

	public function fetchAll ($pageNumber = 1, $countPerPage = 2) {
		$select = new Select();
		$select->from($this->table)->order('categoria_nome');

		$adapter = new DbSelect($select, $this->adapter, $this->resultSetPrototype);
		$paginator = new Paginator($adapter);
		$paginator->setCurrentPageNumber($pageNumber);
		$paginator->setItemCountPerPage($countPerPage);

		return $paginator;
	}

	public function getCategoria ($idCategoria) {
		$idCategoria = (int) $idCategoria;

		$rowSet = $this->select(array('categoria_id' => $idCategoria));
		$row = $rowSet->current();

		if (!$row) {
			throw new \Exception('Registro id '.$idCategoria.' não encontrado!');
		}
		return $row;
	}

	public function saveCategoria (Categoria $categoria) {
		$data = array(
			'categoria_nome' => $categoria->categoria_nome
		);

		$idCategoria = (int) $categoria->categoria_id;

		if ($idCategoria == 0) {
			$this->insert($data);
		} else {
			if ($this->getCategoria($idCategoria)) {
				$this->update($data, array('categoria_id' => $idCategoria));
			} else {
				throw new \Exception("A categoria não foi encontrada com o id ".$idCategoria);
			}
 		}
	}

	public function removeCategoria($idCategoria) {
		$idCategoria = (int) $idCategoria;

		if ($this->getCategoria($idCategoria)) {
			$this->delete(array('categoria_id' => $idCategoria));
		} else {
			throw new \Exception("A categoria não foi encontrada com o id ".$idCategoria);
		}
	}

}