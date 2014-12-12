<?php
/**
 * Created by PhpStorm.
 * User: Yoshi
 * Date: 2014/12/11
 * Time: 14:57
 */

class SettingModel{
	
	public function getData( $dbh = NULL ){
		return SettingDb::getData( $dbh );
	}
	
	public function getOneData( $dbh = NULL ){
		return SettingDb::getOneData( $dbh );
	}
	
	public function getCount( $dbh = NULL ){
		return SettingDb::getCount( $dbh );
	}

	public function insert( $dbh = NULL ){
		return SettingDb::insert( $dbh );
	}
	
	public function update( $dbh = NULL ){
		return SettingDb::update( $dbh );
	}
	public function delete( $dbh = NULL ){
		return SettingDb::delete( $dbh );
	}
} 