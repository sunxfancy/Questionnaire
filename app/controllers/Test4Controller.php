<?php
class Test4Controller extends \Phalcon\Mvc\Controller{
	public function indexAction(){
		// $examinee_id = 12;
		// $basic_score = new BasicScoreOne();
		// try{
		// $answers_df = $basic_score->getPapersByExamineeId($examinee_id);
		// }catch(Exception $e){
		// 	echo $e->getMessage();
		// }
		// echo "<pre>";
		// print_r($answers_df);
		// echo "</pre>";

		for($xuanhuan1 = 1; $xuanhuan1 <= 5; $xuanhuan1 ++ ){
			//A B C D E
			if ($xuanhuan1 <= 2 ){
				//A B
				for($tihao = 1; $tihao<=12; $tihao++){
					//1 ~ 12
					for( $xuanxiang = 1; $xuanxiang <=6; $xuanxiang++ ){
						//1~6
						echo 
					}
				}
			}else{
				//C D E
				for($tihao =1; $tihao<=12; $tihao++){
					//1 ~ 12
					for($xuanxiang = 1; $xuanxiang <=8 ; $xuangxiang++ ){

					}
				}

			}

		}
	}
}