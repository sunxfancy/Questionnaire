<?php
	/**
	 * 用于全局的数据库表缓存
	 * @author Wangyaohui
	 *
	 */

class ModelCache {
	
	/**
	 * 缓存
	 * @param string $factor_name
	 */
	public static function getFactorList(){
		return Factor::find(
		array(
			'hydration' => \Phalcon\Mvc\Model\Resultset\Simple::HYDRATE_ARRAYS,
   			'cache' => array('key'=> "factor_paper_id_$paper_id")
		)
		);
	}
}