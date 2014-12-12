<?php
/**
 * Created by PhpStorm.
 * User: Yoshi
 * Date: 2014/12/12
 * Time: 17:25
 */

class MySmarty extends Smarty{
	function __construct(){
		parent::__construct();
		$this->caching		= 1;
		//Laravelのキャッシュ置き場に合わせる
		$this->setCacheDir( '../storage/views/cache/' );
		$this->setCompileDir( '../storage/views/compile/' );
		//[app/views]wpテンプレート置き場に指定
		$this->setTemplateDir( dirname( realpath( __FILE__ ) ) );
	}
} 