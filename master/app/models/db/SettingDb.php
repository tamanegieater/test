<?php
/**
 * Created by PhpStorm.
 * User: Yoshi
 * Date: 2014/12/11
 * Time: 14:57
 */

class SettingDb{

	protected static $table			= 'setting_m';
	protected static $columnList		= array(
		'setting_id',
		'db_name',
		'db_status',
		'create_time',
		'create_user_id',
		'update_time',
		'update_user_id',
		'delete_time',
		'delete_user_id',
		'delete_flg'
	);
	protected static $excludeColumn	= array(
		'delete_flg'
	);
	protected static $pk				= 'setting_id';

	protected static function getColumn(){
		foreach( self::$columnList as $key => $columnName ){
			if( in_array( $columnName, self::$excludeColumn ) ){
				unset( self::$columnList[$key] );
			}
		}
		return self::$columnList;
	}
	
	public static function getData( $dbh = NULL ){
		if( empty( $dbh ) ){
			$dbh	= DB::connection( 'main' );
		}
		$columnList	= self::getColumn();
		$columns	= implode( ', ', $columnList );
		$sql		=	'SELECT ' .
							$columns.' '.
						'FROM ' .
							self::$table.' '.
						'WHERE '.
								'db_status		= ? '.
							'AND delete_flg		= ? ';
		$prm		= array( 1, 0 );
		return AppModel::DbList( $dbh, $sql, $prm );
	}
	
	public static function getOneData( $dbh = NULL ){
		if( empty( $dbh ) ){
			$dbh	= DB::connection( 'main' );
		}
		$columnList	= self::getColumn();
		$columns	= implode( ', ', $columnList );
		$sql		=	'SELECT ' .
							$columns.' '.
						'FROM ' .
							self::$table.' '.
						'WHERE '.
								'db_status		= ? '.
							'AND delete_flg		= ? '.
						'LIMIT 1 ';
		$prm		= array( 1, 0 );
		return AppModel::DbRow( $dbh, $sql, $prm );
	}
	
	public static function getCount( $dbh = NULL ){
		if( empty( $dbh ) ){
			$dbh	= DB::connection( 'main' );
		}
		$sql		=	'SELECT '.
							'COUNT(*) '.
						'FROM '.
							self::$table.' '.
						'WHERE '.
								'db_status		= ? '.
							'AND delete_flg		= ? ';
		$prm		= array( 1, 0 );
		return AppModel::DbCnt( $dbh, $sql, $prm );
	}
	
	public static function insert( $dbh = NULL ){
		if( empty( $dbh ) ){
			$dbh	= DB::connection( 'main' );
		}
		$now		= date( 'Y-m-d H:i:s' );
		$sql		= array(
			'db_name'		=> 'test3',
			'db_status'		=> 1,
			'create_time'	=> $now,
			'update_time'	=> $now
		);
		return AppModel::DbInsert( $dbh, self::$table, $sql );
	}
	
	public static function update( $dbh = NULL ){
		if( empty( $dbh ) ){
			$dbh	= DB::connection( 'main' );
		}
		$now	= date( 'Y-m-d H:i:s' );
		$sql	=	'UPDATE '.
						'setting_m '.
					'SET '.
						'update_time		= ? '.
					'WHERE '.
							' setting_id	= ? '.
						'AND delete_flg		= ? ';
		$prm	= array( $now, 1, 0 );
		return AppModel::DbUpdate( $dbh, $sql, $prm );
	}
	
	public static function delete( $dbh = NULL ){
		if( empty( $dbh ) ){
			$dbh	= DB::connection( 'main' );
		}
		$sql	=	'DELETE '.
					'FROM '.
						'setting_m '.
					'WHERE '.
						'delete_flg		= ? ';
		$prm	= array( 1 );
		return AppModel::DbDelete( $dbh, $sql, $prm );
	}

} 