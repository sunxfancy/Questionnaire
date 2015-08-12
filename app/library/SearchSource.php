<?php


	class SearchSource
	{
		public $project;
		public $modules;
		public $indexs;
		public $factors;
		public $questions;

		public $modules_id;
		public $indexs_id;
		public $factors_id;
		public $questions_id;
		
		function __construct($project_id)
		{
			# code...
		}



		public function getProject($project_id){
			$project_l = Project::findFirst($project_id);
            return $project_l;
		}

		public function getModules_id($project_id)
	    {	

	    	$pmrels = Pmrel::find(array(
            "project_id = ?1",
            "bind"=>array(1=>$project_id)
            ));
	    	$modules_ids=array();
	    	
	        foreach ($pmrels as $pmrel) {
	            $modules_l[] = Module::findFirst($pmrel->module_id);
	        }
	        $modules_l[]= $modules_l[1];
	        $modules_l[]=$modules_l[2];
	        $modules_l[2]=$modules_l[1];
	        return $modules_l;
	    }



	    public function getIndexs($module_id){

	    }
	}
?>