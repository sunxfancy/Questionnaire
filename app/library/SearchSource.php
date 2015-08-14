<?php


	class SearchSource
	{
		private $project;
		private $modules;
		private $indexs;
		private $factors;
		private $questions;

		private $project_id;
		private $modules_id;
		private $indexs_id;
		private $factors_id;
		private $questions_id;
		
		function __construct($project_id)
		{
			$this->project_id=$project_id;
		}

		public function getProject($project_id=null){
			if($project_id){
				$project_l = Project::findFirst($project_id);
            	return $project_l;
			}else{
				if($this->project){
					return $this->project;
				}else{
					return $this->getProject($this->project_id);
				}
				}
		}

		public function getModules_id($project_id=null)
	    {	
	    	if($project_id){
	    		$pmrels = Pmrel::find(array(
	            "project_id = ?1",
	            "bind"=>array(1=>$project_id)
	            ));
		    	$modules_id=array();
		        foreach ($pmrels as $pmrel) {
		            $modules_id[] =$pmrel->module_id;
		        }
		        return $modules_id;
	    	}else{
	    		if($this->modules_id){
	    			return $this->modules_id;
	    		}else{
	    			return $this->getModules_id($this->project_id);
	    		}
	    	}
	    }

	    public function getModules($project_id=null){
	    	if($project_id){
	    		$module_ids=$this->getModules_id($project_id);
	    		$modules=array();
	    		foreach($module_ids as $module_id){
	    			$modules[]=Module::findFirst($module_id);
	    		}
		        return $modules;
	    	}else{
	    		if($this->modules){
	    			return $this->modules;
	    		}else{
	    			return $this->getModules($this->project_id);
	    		}
	    	}
	    }

	    public function getIndexs($module_id = null){
	    	if ($module_id) {

	    	} else {

	    	}
	    }
	}
?>