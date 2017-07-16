<?php

namespace App\Model;

use App\Config\DataBase as DB;

/**
* 
*/
class PerformanceModel extends DB
{
	
	function __construct($db='')
	{	
		if(!$db)
			throw new \Exception("La clase ".get_class($this)." no encontro la base de datos", 1);
		else
			parent::__construct($db);
	}	

	/**
	 *
	 *
	 *
	*/
	public function getPerformances($id_grade, $id_asignature, $category, $period)
	{
		$g=$id_grade==-1?'<>':'=';
		$a=$id_asignature==-1?'<>':'=';
		$c=$category==-1?'<>':'=';
		$p=$period==-1?'<>':'=';

		$this->query = "SELECT superior, codigo,  periodos FROM desempeno
		WHERE id_grado $g {$id_grade} AND id_asignatura $a {$id_asignature}	and periodos $p '{$period}'	AND id_clas_chs $c '{$category}'";

		return $this->getResultsFromQuery();
	}

	/**
	 *
	 *	@param
	 *  @return
	*/ 
	public function getPerformanceIndicators($id_performance)
	{
		$this->query = "SELECT *
						FROM new_indicadores_desempeno
						WHERE id_parametro_evaluacion={$id_performance} ";

		return $this->getResultsFromQuery();
	}

	/**
	 *
	 *	@param
	 *  @return
	*/ 
	public function getEvaluationParameters()
	{
		$this->query = "SELECT * FROM new_parametro_evaluacion";

		return $this->getResultsFromQuery();
	}

	/**
	 * 
	 *	@param
	 *  @return
	*/ 
	public function getCriterions()
	{
		$this->query = "SELECT  * FROM criterios_evaluacion";

		return $this->getResultsFromQuery();
	}

	/**
	 * 
	 *	@param
	 *  @return
	*/ 
	public function getIndicators() //Porcentaje definidos
	{
		$this->query = "SELECT *
						FROM new_indicadores_desempeno";

		return $this->getResultsFromQuery();
	}

	/**
	 *
	 *
	 *
	*/
	public function getExpression()
	{
		$this->query = "SELECT * FROM desem_expres";

		return $this->getResultsFromQuery();
	}

	/**
	 *
	 *
	 *
	*/
	public function allCategories()
	{
		$this->query = "SELECT * FROM saber_chs";

		return $this->getResultsFromQuery();
	}

	/**
	 *
	 *
	 *
	*/
	public function getPercentage()
	{
		$this->query = "SELECT  porcentaje_efp, etiqueta_grupo_1, etiqueta_grupo_2, etiqueta_grupo_3, porcentaje_grupo1, porcentaje_grupo2,  porcentaje_grupo3, porcentaje_autoevaluacion FROM parametros_evaluacion";

		return $this->getResultsFromQuery();
	}

	/**
	 *
	 *
	 *
	*/
	public function getCodes($id_group, $id_asignature, $period)
	{
		$this->query = "SELECT cod_desemp, posicion 
						FROM rel_desemp_posicion 
						WHERE id_grupo = {$id_group} AND id_asign = {$id_asignature} AND periodo ={$period}";

		return $this->getResultsFromQuery();
	}

	/**
	 *
	 *
	 *
	*/
	public function getCodesByPosition($position, $id_group, $id_asignature, $period)
	{
		$this->query = "SELECT cod_desemp 
						FROM rel_desemp_posicion 
						WHERE id_grupo = {$id_group} AND id_asign = {$id_asignature}  AND periodo = {$period} AND posicion = '{$position}'";
		return $this->getResultsFromQuery();
	}
}
?>