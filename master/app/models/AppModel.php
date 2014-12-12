<?php
/**
 * Created by PhpStorm.
 * User: Yoshi
 * Date: 2014/12/11
 * Time: 22:40
 */

class AppModel{
	public static function getQuote( $name ){
		return "`".$name."`";
	}
	
	/**
	 * リスト取得
	 * @param $dbh
	 * @param $sql
	 * @param array $prm
	 * @return null
	 */
	public static function DbList( $dbh, $sql, $prm = array() ){
		if( empty( $dbh ) || empty( $sql ) ){
			return NULL;
		}
		$result		= $dbh->select( $sql, $prm );
		$list		= NULL;
		if( is_array( $result ) ){
			foreach( $result as $key => $value ){
				$list[$key]		= (array)$value;
			}
		}
		return $list;
	}

	/**
	 * 配列から取り出して取得
	 * @param $dbh
	 * @param $sql
	 * @param array $prm
	 * @return array|null
	 */
	public static function DbRow( $dbh, $sql, $prm = array() ){
		if( empty( $dbh ) || empty( $sql ) ){
			return NULL;
		}
		$result		= $dbh->select( $sql, $prm );
		if( empty( $result ) ){
			return NULL;
		}
		$oneData	= (array)reset( $result );
		return $oneData;
	}

	/**
	 * COUNT を数値で返す
	 * @param $dbh
	 * @param $sql
	 * @param array $prm
	 * @return null
	 */
	public static function DbCnt( $dbh, $sql, $prm = array() ){
		if( empty( $dbh ) || empty( $sql ) ){
			return NULL;
		}
		$result		= $dbh->select( $sql, $prm );
		if( empty( $result ) ){
			return NULL;
		}
		$dataCntTmp	= (array)reset( $result );
		$dataCnt	= $dataCntTmp['COUNT(*)'];
		return $dataCnt;
	}

	/**
	 * INSERT
	 * @param $dbh
	 * @param $table
	 * @param $sql
	 * @return mixed
	 */
	public static function DbInsert( $dbh, $table, $sql ){
		$insertValue	= NULL;
		$columnList		= NULL;
		$prm			= NULL;
		if( empty( $dbh ) ){
			throw new LogicException( 'please check setting of dbh' );
		}
		if( empty( $sql ) ){
			throw new LogicException( 'nothing in insert value' );
		}
		foreach( $sql as $columnName => $value ){
			$columnList[]	= $columnName;
			$insertValue[]	= '?';
			$prm[]			= $value;
		}
		$insertSql		=	'INSERT '.
						'INTO '.
							$table.' '.
							'( '.implode( ', ', $columnList ).') '.
						'VALUES '.
							'( '.implode( ', ', $insertValue ).') ';
		$dbh->insert( $insertSql, $prm );
		return self::getPkId( $dbh, $table, $columnList, $prm );
	}

	/**
	 * 対象テーブルのPKの名前取得
	 * PKの値取得
	 * @param $dbh
	 * @param $table
	 * @param $columnList
	 * @param $prm
	 * @return null
	 */
	public static function getPkId( $dbh, $table, $columnList, $prm ){
		$columnData	= self::getColumnData( $dbh, $table );
		if( empty( $columnData ) ){
			return NULL;
		}
		$pkName	= NULL;
		foreach( $columnData as $key => $value ){
			if( $value['Key'] == 'PRI' ){
				$pkName	= $value['Field'];
				break;
			}
		}
		$where	= NULL;
		foreach( $columnList as $columnKey => $columnNameTmp ){
			$columnName		= self::getQuote( $columnNameTmp );
			if( empty( $where ) ){
				$where	= $columnName.'			= ? ';
			}else{
				$where	.= 'AND '.$columnName.'	= ? ';
			}
		}
		$sql	=	'SELECT '.
						$pkName.' '.
					'FROM '.
						$table.' '.
					'WHERE '.
						$where.' '.
					'ORDER BY '.
						$pkName.' '.
					'DESC '.
					'LIMIT 1 ';
		return self::DbValue( $dbh, $sql, $prm, $pkName );
	}

	/**
	 * 対象のカラムの数値だけ取得
	 * @param $dbh
	 * @param $sql
	 * @param $prm
	 * @param $columnName
	 * @return null
	 */
	public static function DbValue( $dbh, $sql, $prm, $columnName ){
		if( empty( $dbh ) || empty( $sql ) ){
			return NULL;
		}
		$value		= NULL;
		$result		= $dbh->select( $sql, $prm );
		if( empty( $result ) ){
			return NULL;
		}
		$oneData	= (array)reset( $result );
		$value		= $oneData[$columnName];
		return $value;
	}

	/**
	 * 対象テーブルのカラムデータ取得
	 * @param $dbh
	 * @param $table
	 * @param array $prm
	 * @return null
	 */
	public static function getColumnData( $dbh, $table, $prm = array() ){
		$sql	=	'SHOW '.
					'COLUMNS '.
					'FROM '.
						$table;
		$result		= $dbh->select( $sql, $prm );
		$list		= NULL;
		if( is_array( $result ) ){
			foreach( $result as $key => $value ){
				$list[$key]		= (array)$value;
			}
		}
		return $list;
	}

	/**
	 * UPDATE
	 * @param $dbh
	 * @param $sql
	 * @param $prm
	 * @return mixed
	 */
	public static function DbUpdate( $dbh, $sql, $prm ){
		if( empty( $dbh ) || empty( $sql ) ){
			throw new LogicException( 'please check setting of dbh and sql' );
		}
		$result		= $dbh->update( $sql, $prm );
		return $result;
	}
	
	public static function DbDelete( $dbh, $sql, $prm ){
		if( empty( $dbh ) || empty( $sql ) ){
			throw new LogicException( 'please check setting of dbh and sql' );
		}
		$result		= $dbh->delete( $sql, $prm );
		return $result;
	}
} 