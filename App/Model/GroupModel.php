<?php

namespace App\Model;

use App\Config\DataBase as DB;
/**
* 
*/
class GroupModel extends DB
{
	
	private $table = 't_grupos';
	private $table_subgroup = 't_subgrupos';

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
	public function find($id_group)
	{
		$this->query = "SELECT * 
						FROM {$this->table}
						WHERE id_grupo={$id_group}";

		return $this->getResultsFromQuery();
	}

	/**
	*
	*
	*/
	public function findSubGroup($id_subgroup)
	{
		$this->query = "SELECT *
						FROM {$this->table_subgroup}
						WHERE id_subgrupo={$id_subgroup}";

		return $this->getResultsFromQuery();
	}

	/**
	 *
	 * @param
	 * @return
	*/
	public function getInfo($id_group){
		$this->query = "SELECT g.id_grupo, g.nombre_grupo, d.primer_apellido AS doc_primer_ape, d.segundo_apellido AS doc_segundo_ape, d.primer_nombre AS doc_primer_nomb, d.segundo_nombre AS doc_segundo_nomb, j.jornada, s.sede, gra.id_grado
						FROM docentes d
						INNER JOIN t_grupos g ON g.id_director_grupo=d.id_docente AND g.id_grupo={$id_group}
						INNER JOIN jornadas j on g.jornada=j.id_jornada
						INNER JOIN sedes s ON g.id_sede=s.id_sede
						INNER JOIN t_grados gra ON g.id_grado=gra.id_grado";
		return $this->getResultsFromQuery();
	}

	/**
	 *
	 *	@param
	 *  @return
	*/ 
	public function getClassRoomList($id_group)
	{
		$this->query = "SELECT e.idstudents, e.primer_apellido AS primer_ape_alu, e.segundo_apellido AS segundo_ape_alu, e.primer_nombre AS primer_nom_alu, e.segundo_nombre AS segundo_nom_alu, e.estatus 
						FROM t_estudiante_grupo eg 
						INNER JOIN students e ON eg.idstudent=e.idstudents AND eg.id_grupo ={$id_group} 
						ORDER BY e.primer_apellido";

		return $this->getResultsFromQuery();
	}

	/**
	 *
	 *	@param
	 *  @return
	*/ 
	public function groupAndAsign($id_asignature, $id_group, $groupType = 'group')
	{
		$column_group = ($groupType== 'group') ? 'id_grupo' : 'id_subgrupo';
		$table_group  = ($groupType== 'group') ? 't_grupos' : 't_subgrupos';
		$column_nameGroup = ($groupType == 'group') ? 'nombre_grupo' : 'nombre_subgrupo';

		$this->query = "SELECT {$column_nameGroup}, asignatura, {$table_group}.id_grado FROM {$table_group}, t_asignaturas 
						WHERE {$column_group} = {$id_group} AND id_asignatura = {$id_asignature}";
		return	$this->getResultsFromQuery();
	}

	public function getGradeByGroup($id_group, $groupType = 'group'){

		$column_group = ($groupType== 'group') ? 'id_grupo' : 'id_subgrupo';
		$table_group  = ($groupType== 'group') ? 't_grupos' : 't_subgrupos';

        $this->query = "SELECT id_grado
						FROM {$table_group}
						WHERE {$column_group}={$id_group}";
        return $this->getResultsFromQuery();
    }
}
?>