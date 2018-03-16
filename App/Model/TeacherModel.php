<?php

namespace App\Model;

use App\Config\DataBase as DB;
/**
* 
*/
class TeacherModel extends DB
{
	private $table = 'docentes';
	private $table_auth = 'sec_users';
	
	function __construct($db='')
	{	
		if(!$db)
			throw new \Exception("La clase ".get_class($this)." no encontro la base de datos", 1);
		else
			parent::__construct($db);
	}

	/**
	 *
	 * @param
	 * @return
	*/
	public function find($id)
	{
		$this->query = "SELECT * FROM {$this->table} WHERE id_docente={$id}";

		return $this->getResultsFromQuery();
	}

	/**
	 *
	 * @param
	 * @return
	*/
	public function findBy($field, $value)
	{
		$this->query = "SELECT * FROM {$this->table} WHERE {$field}='{$value}'";

		return $this->getResultsFromQuery();
	}

	/**
	 *
	 * @param
	 * @return
	*/
	public function login($username, $password)
	{
		$this->query = "SELECT * FROM {$this->table} WHERE login='{$username}' AND pswd='{$password}'";

		return $this->getResultsFromQuery();
	}

	/**
	 *
	 * @param
	 * @return
	*/
	public function update($id, $field, $value)
	{
		$this->query = "UPDATE {$this->table}
						SET {$field}='{$value}'
						WHERE id_docente={$id}";

		return $this->executeQuerySingle();
	}

	/**
	 *
	 * @param
	 * @return
	*/
	public function checkPassword($document, $password)
	{
		$this->query = "SELECT *
						FROM {$this->table_auth}
						WHERE login='{$document}' AND pswd='{$password}'";

		return $this->getResultsFromQuery();
	}

	/**
	 *
	 * @param
	 * @return
	*/
	public function updatePassword($document, $password)
	{
		$this->query = "UPDATE {$this->table_auth}
						SET pswd='{$password}'
						WHERE login='{$document}'";

		return $this->executeQuerySingle();
	}

	/**
	 *	Funcion para obtener las asignturas y grupos que dictan un profesor
	 *
	 *	@param $id_teacher
	 *  @return query results
	*/
	public function getAsignaturesAndGroups($id_teacher)
	{

		$this->query = "SELECT g.id_grupo, g.nombre_grupo, a.id_asignatura, a.asignatura, g.id_grado
						FROM t_asignaturas a
						INNER JOIN grupo_x_asig_x_doce ad ON a.id_asignatura=ad.id_asignatura
						INNER JOIN t_grupos g ON ad.id_grupo=g.id_grupo
						WHERE ad.id_docente = '{$id_teacher}' 
						ORDER BY g.id_grado";

		return $this->getResultsFromQuery();

	}

	/**
	 *	Funcion para obtener las asignturas y subgrupos que dictan un profesor
	 *
	 *	@param $id_teacher
	 *  @return query results
	*/
	public function getAsignaturesAndSubGroups($id_teacher)
	{
		$this->query = "SELECT g.id_subgrupo, g.nombre_subgrupo, a.id_asignatura, a.asignatura, g.id_grado
						FROM t_asignaturas a
						INNER JOIN sub_grupo_x_asig_x_doce ad ON a.id_asignatura=ad.id_asignatura
						INNER JOIN t_subgrupos g ON ad.id_subgrupo=g.id_subgrupo
						WHERE ad.id_docente = {$id_teacher}
						ORDER BY g.id_grado";

		return $this->getResultsFromQuery();
	}


	/**
	 * Funcion que obtiene todos los grupos de un director de curso
	 *
	 * @param $id_teacher
	 * @return query results
	*/
	public function getGroupByDirector($id_teacher)
	{
		$this->query = "SELECT *
						FROM t_grupos g
						WHERE g.id_director_grupo = '{$id_teacher}' 
						ORDER BY g.nombre_grupo";

		return $this->getResultsFromQuery();
	}

	/**
	 *	Funcion que determina si un profesor es director de grupo
	 *
	 * @param $id_teacher
	 * @return boolean
	*/
	public function isDirector($id_teacher)
	{
		return $this->getGroupByDirector($id_teacher)['state'];
			
	}


	/**
	 *	Funcion que devuelve las observaciones generales
	 *
	 * @param $id_teacher
	 * @return result query
	*/
	public function getGeneralObservations($id_teacher)
	{

		$this->query = "SELECT ogp.id_observ_generales_periodo AS id_observacion, s.idstudents, s.primer_apellido AS p_a_alu, s.segundo_apellido AS s_a_alu, s.primer_nombre AS p_n_alu, s.segundo_nombre AS s_n_alu, ogp.id_periodo, ogp.observaciones,g.nombre_grupo 
						FROM observ_generales_periodo ogp 
						INNER JOIN students s ON ogp.id_estudiante=s.idstudents 
						INNER JOIN t_grupos g ON ogp.id_grupo=g.id_grupo 
						WHERE ogp.id_director_grupo={$id_teacher}
						ORDER BY p_a_alu";

		return $this->getResultsFromQuery();
	}

	/**
	 *
	 * @param
	 * @return
	 *
	*/
	public function getInfoAsignatureAndGroup($id_asignature, $id_group){
		$this->query = "SELECT d.primer_apellido AS doc_primer_ape, d.segundo_apellido AS doc_segundo_ape, d.primer_nombre AS doc_primer_nomb, d.segundo_nombre AS doc_segundo_nomb, dir.primer_apellido AS dir_primer_ape, dir.segundo_apellido AS dir_segundo_ape, dir.primer_nombre AS dir_primer_nomb, dir.segundo_nombre AS dir_segundo_nomb, a.id_asignatura, a.asignatura, g.id_grupo, g.nombre_grupo, s.sede, j.jornada
						FROM docentes d
						INNER JOIN grupo_x_asig_x_doce ad ON d.id_docente=ad.id_docente
						INNER JOIN t_asignaturas a ON ad.id_asignatura=a.id_asignatura
						INNER JOIN t_grupos g ON ad.id_grupo=g.id_grupo
						INNER JOIN docentes dir ON g.id_director_grupo=dir.id_docente
						INNER JOIN sedes s ON g.id_sede=s.id_sede
						INNER JOIN jornadas j on g.jornada=j.id_jornada
						WHERE a.id_asignatura={$id_asignature} AND g.id_grupo={$id_group}";

		return $this->getResultsFromQuery();
	}
}
?>