<?php
/**
 * Created by PhpStorm.
 * User: Yoshi
 * Date: 2014/12/12
 * Time: 17:37
 */

class Index extends \BaseController{
	protected $settingModel;
	public function execute(){
		$view			= new MySmarty();
		$this->settingModel	= new SettingModel();
		$view->assign('test','テスト');
		$dbh	= DB::connection( 'main' );
		try{
			$dbh->beginTransaction();

			$data			= self::getData( $dbh );
			$oneData		= self::getOneData( $dbh );
			$dataCnt		= self::getCount( $dbh );
			$insert			= self::insert( $dbh );
			$update			= self::update( $dbh );
			$delete			= self::delete( $dbh );

			$dbh->commit();
		}catch( Exception $e ){
			$dbh->rollBack();
		}
		var_dump($insert);
		return $view->fetch( 'top/Top.tpl' );
	}

	private function getData(){
		return $this->settingModel->getData();
	}

	private function getOneData(){
		return $this->settingModel->getOneData();
	}

	private function getCount(){
		return $this->settingModel->getCount();
	}

	private function insert(){
		return $this->settingModel->insert();
	}

	private function update(){
		return $this->settingModel->update();
	}

	private function delete(){
		return $this->settingModel->delete();
	}
} 