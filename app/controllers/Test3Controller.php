<?php
/**
	* 
	*/
class Test3Controller extends Base
{		
    public function indexAction(){
    	$project_id = 1502;
        $wordExport = new ProjectComExport();
        $wordExport->report($project_id);
    }
    
    public function testAction(){
    	$project_id = 1502;
    	$data = new ProjectComData();
    	echo '职业素质综合评价相关数据<h2>获取到排序数据后，在显示时按照正常出现的顺序进行排列，减少多次的搜索</h2>一个指标只对应一个模块，所以不用再提取评语时注意了';
    	echo '<pre>';
    	print_r($data->getComprehensiveData($project_id));
    	echo '<pre>';
    	
    }
    
    public function test1Action(){
    	$project_id = 1502;
    	$data = new ProjectComData();
//     	echo '项目总体指标排序';
    	echo '<pre>';
//     	print_r($data->getProjectIndexDesc($project_id));
//     	echo '<hr />';
    	echo '优势指标排序以及指标下属因子得分详情罗列';
    	print_r($data->getProjectAdvantages($project_id));
    	
    	//$re = $data->getChildrenOfProjectIndex('zb_gzzf', 'X4,zb_rjgxtjsp,chg,Y3,Q3,spmabc,aff', $project_id);
//     	print_r($re);
		echo '<hr />';
		echo '劣势指标排序以及指标下属因子得分详情罗列';
		print_r($data->getProjectDisadvantages($project_id));
    	echo '</pre>';
    	
    }
    
    public function test2Action(){
    	$project_id = 1502;
        $data = new ProjectComData();
        echo '<pre>';

        $levels_array = $data->getBaseLevels($project_id);
    	print_r($levels_array);
        // echo '<hr />';
        // $factor_id = 160;
        // $factor_chs_name = '感情用事';
        // $rt = $data->getFactorGrideByLevel($factor_id, $factor_chs_name, $levels_array,$project_id);

        // print_r($rt);
        // echo '<hr />';
        //  $factor_id = 2;
        // $factor_chs_name = '领导能力';
        // $rt = $data->getFactorGrideByLevel($factor_id, $factor_chs_name, $levels_array,$project_id);
        // print_r($rt);
        // asort($rt);
        // echo '<hr />';
        // print_r($rt);
    	echo '</pre>';
    }

    public function test3Action(){
        $project_id = 1502;
        $data = new ProjectComData();
        echo '<pre>';
        print_r($data->getInqueryAnsDetail($project_id));
        echo '</pre>';
    }


    public function test4Action() {
        $project_id = 1502;
        $data = new ProjectComData();
        echo '<pre>';
        print_r($data->getInqueryDetail($project_id) );
        echo '</pre>';
    }
 
	public function test5Action(){
		$project_id = 1502;
		$data = new ProjectComData();
		echo '<pre>';
		print_r($data->getInqueryAnsComDetail($project_id) );
		echo '</pre>';
	}
}