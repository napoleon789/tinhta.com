<?php
class DB 
{
	static $db_connect_id=false;				// connection id of this database
	static $db_result=false;				// current result of an query
	function DB($sqlserver, $sqluser, $sqlpassword, $dbname)
	{
		DB::$db_connect_id = @mysql_connect($sqlserver, $sqluser, $sqlpassword, true);
        mysql_query("SET NAMES utf8");
		if (isset(DB::$db_connect_id) and DB::$db_connect_id)
		{
			if (!$dbselect = @mysql_select_db($dbname))
			{
				@mysql_close(DB::$db_connect_id);
				DB::$db_connect_id = $dbselect;
			}else{
				$table_db=mysql_query('select 1 from news');
              mysql_query("SET NAMES utf8");
				if($table_db===false){
					die('Error: Database is not install');
				}
			}
		}
		if(!DB::$db_connect_id)
		{
			die('Error: Could not connect to the database');
		}
		return DB::$db_connect_id;
	}
	// function close
	// Close SQL connection
	// should be called at very end of all scripts
	// ------------------------------------------------------------------------------------------

	static function close()
	{
		if (isset(DB::$db_connect_id) and DB::$db_connect_id)
		{
			if (isset(DB::$db_result) and DB::$db_result)
			{
				@mysql_free_result(DB::$db_result);
			}

			$result = mysql_close(DB::$db_connect_id);

			return $result;
		}
		else
		{
			return false;
		}

	}
	// function query
	// Run an sql command
	// Parameters:
	//		$query:		the command to run
	// ------------------------------------------------------------------------------------------

	static function query($query)
	{
		// Clear old query result
		DB::$db_result=false;
		if (!empty($query))
		{
			if(!(DB::$db_result = @mysql_query($query, DB::$db_connect_id)))
			{
				echo '<p><font face="Courier New,Courier" size=3><b>'.mysql_error(DB::$db_connect_id).'</b></font></p>';
			}
		}
		return DB::$db_result;
	}
	static function insert($table, $values, $replace=false)
	{

		if($replace)
		{
			$query='replace';
		}
		else
		{
			$query='insert into';
		}
		$query.=' `'.$table.'`(';

		$i=0;
		if(is_array($values))
		{
			foreach($values as $key=>$value)
			{
				if($key)
				{
					if($i<>0)
					{
						$query.=',';
					}
					$query.='`'.$key.'`';
					$i++;
				}
			}
			$query.=') values(';
			$i=0;
			foreach($values as $key=>$value)
			{
				if($i<>0)
				{
					$query.=',';
				}

				if($value==='NULL')
				{
					$query.='NULL';
				}
				else
				{
					$query.='\''.DB::escape($value).'\'';
				}
				$i++;
			}
			$query.=')';
          mysql_query("SET NAMES utf8");
			if(DB::query($query))
			{
				return DB::insert_id();		
			}
		}
	}
	static function delete($table, $condition)
	{
		$query='delete from `'.$table.'` where '.$condition;
		if(DB::query($query))
		{		
			return true;
		}
	}
	static function fetch($sql = false, $field = false, $default = false)
	{
		if($sql)
		{
			DB::query($sql);

		}
		$query_id = DB::$db_result;
		if ($query_id)
		{
			if($result = @mysql_fetch_assoc($query_id))
			{
				if($field)
				{
					return $result[$field];
				}
				return $result;
			}
			return $default;
		}
		else
		{
			return false;
		}
	}
	static function fetch_all($sql=false)
	{
		if($sql)
		{
			DB::query($sql);
		}
		$query_id = DB::$db_result;

		if ($query_id)
		{
			$result=array();
			while($row = @mysql_fetch_assoc($query_id))
			{
				$result[$row['id']] = $row;
			}

			return $result;
		}
		else
		{
			return false;
		}
	}
	static function insert_id()
	{
		if (DB::$db_connect_id)
		{
			$result = mysql_insert_id(DB::$db_connect_id);

			return $result;
		}
		else
		{
			return false;
		}
	}
	static function update($table, $values, $condition)
	{
		$query='update `'.$table.'` set ';
		$i=0;
		if($values)
		{
			foreach($values as $key=>$value)
			{
				if($i<>0)
				{
					$query.=',';
				}
				if($key)
				{
					if($value=='NULL')
					{
						$query.='`'.$key.'`=NULL';
					}
					else
					{
						$query.='`'.$key.'`=\''.DB::escape($value).'\'';
					}
					$i++;
				}
			}
			$query.=' where '.$condition;
			if(DB::query($query))
			{
				return true;
			}
		}
	}
	static function escape($sql)
	{
		return mysql_real_escape_string($sql);
	}
}
if(file_exists('lib/db_info.php')){
	require_once 'lib/db_info.php';
}
$sqlserver=(isset($sqlserver) and $sqlserver)?$sqlserver:'';
$sqluser=(isset($sqluser) and $sqluser)?$sqluser:'';
$sqlpassword=(isset($sqlpassword) and $sqlpassword)?$sqlpassword:'';
$dbname=(isset($dbname) and $dbname)?$dbname:'';
$db = new DB($sqlserver, $sqluser, $sqlpassword, $dbname);
?>