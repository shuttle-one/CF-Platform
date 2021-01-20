<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<?php
/*
 * @Author Rory Standley <rorystandley@gmail.com>
 * @Version 1.3
 * @Package Database
 */
class DatabaseLog{
	/*
	 * Create variables for credentials to MySQL database
	 * The variables have been declared as private. This
	 * means that they will only be available with the
	 * Database class
	 */
    private $db_host = DB_HOST;  // Change as required
    private $db_user = DB_USER;  // Change as required
    private $db_pass = DB_PASS;  // Change as required
    private $db_name = DB_NAME;   // Change as required

	/*
	 * Extra variables that are required by other function such as boolean con variable
	 */
	private $con = false; // Check to see if the connection is active
	private $result = array(); // Any results from a query will be stored here
    private $myQuery = "";// used for debugging process with SQL return
    private $numResults = "";// used for returning the number of rows
	private $numRow = 0;
    private $myconn;

	// Function to make connection to database
	public function connect(){

		if(!$this->con){

			$myconn = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_name);  // mysql_connect() with variables defined at the start of Database class
			//mysql_set_charset('utf8',$myconn);
			// mysqli_query($myconn, "SET NAMES UTF8");

            if($myconn){
            	//$seldb = @mysql_select_db($this->db_name,$myconn); // Credentials have been pass through mysql_connect() now select the database
                //if($seldb){
                	$this->con = true;
                    $this->myconn = $myconn;

                    return true;  // Connection has been made return TRUE
                //}else{
                	//array_push($this->result,mysql_error());
                //    return false;  // Problem selecting database return FALSE
                // }
            }else{
            	//array_push($this->result,mysql_error());
                echo "Error";
                return false; // Problem connecting return FALSE
            }
        }else{
            return true; // Connection has already been made return TRUE
        }
	}

	// Function to disconnect from the database
    public function disconnect(){
    	// If there is a connection to the database
    	if($this->con){
    		// We have found a connection, try to close it
    		if($this->myconn->close()){
    			// We have successfully closed the connection, set the connection variable to false
    			$this->con = false;
				// Return true tjat we have closed the connection
				return true;
			}else{
				// We could not close the connection, return false
				return false;
			}
		}
    }

	public function sql($sql){

		// $query = @mysql_query($sql);
        $this->myQuery = $sql; // Pass back the SQL
        $query = mysqli_query($this->myconn,$sql);
		if($query){
			// If the query returns >= 1 assign the number of rows to numResults
			$this->numResults = mysqli_num_rows($query);
			// Loop through the query results by the number of rows returned
			//if ($this->numResults > 0)
			//{

				for($i = 0; $i < $this->numResults; $i++){
					$r = mysqli_fetch_array($query);
               		$key = array_keys($r);
               		for($x = 0; $x < count($key); $x++){
               		// Sanitizes keys so only alphavalues are allowed
                   		if(!is_int($key[$x])){
                   			if(mysqli_num_rows($query) >= 1){
                   				$this->result[$i][$key[$x]] = $r[$key[$x]];
							}else{
								$this->result = null;
							}
						}
					}
				}

			//}
			return true; // Query was successful
		}else{
			//echo 'fail';
			//array_push($this->result,mysql_error());
			return false; // No rows where returned
		}
	}

	// Function to SELECT from the database
	public function select($table, $rows = '*', $where = null, $order = null, $limit = null, $join = null){
		// Create query from the variables passed to the function
		$q = 'SELECT '.$rows.' FROM '.$table;
		if($join != null){
			$q .= ' JOIN '.$join;
		}
        if($where != null){
        	$q .= ' WHERE '.$where;
		}
        if($order != null){
            $q .= ' ORDER BY '.$order;
		}
        if($limit != null){
            $q .= ' LIMIT '.$limit;
        }
        $this->myQuery = $q; // Pass back the SQL
		// Check to see if the table exists
        if($this->tableExists($table)){
        	// The table exists, run the query
			//echo $q.'<br>';
        	$query = @mysql_query($q);
			if($query){
				// If the query returns >= 1 assign the number of rows to numResults
				$this->numResults = mysql_num_rows($query);
				// Loop through the query results by the number of rows returned
				for($i = 0; $i < $this->numResults; $i++){
					$r = mysql_fetch_array($query);
                	$key = array_keys($r);
                	for($x = 0; $x < count($key); $x++){
                		// Sanitizes keys so only alphavalues are allowed
                    	if(!is_int($key[$x])){
                    		if(mysql_num_rows($query) >= 1){
                    			$this->result[$i][$key[$x]] = $r[$key[$x]];
							}else{
								$this->result = null;
							}
						}
					}
				}
				return true; // Query was successful
			}else{
				array_push($this->result,mysql_error());
				return false; // No rows where returned
			}
      	}else{
      		return false; // Table does not exist
    	}
    }

	// Function to insert into the database
    public function insert($table,$params=array()){
    	// Check to see if the table exists
    	 // if($this->tableExists($table)){
    	 	$sql='INSERT INTO `'.$table.'` (`'.implode('`, `',array_keys($params)).'`) VALUES (\'' . implode('\', \'', $params) . '\')';

            $this->myQuery = $sql; // Pass back the SQL
            // Make the query to insert to the database
            // if($ins = @mysql_query($sql)){
            // echo $sql;
            if ($ins = mysqli_query($this->myconn,$sql)) {
            	array_push($this->result,mysqli_insert_id($this->myconn));
                return true; // The data has been inserted
            }else{
            	array_push($this->result,mysqli_error());
                return false; // The data has not been inserted
            }
        // }else{
        // 	return false; // Table does not exist
        // }
    }

	//Function to delete table or row(s) from database
    public function delete($table,$where = null){
    	// Check to see if table exists
    	 if($this->tableExists($table)){
    	 	// The table exists check to see if we are deleting rows or table
    	 	if($where == null){
                $delete = 'DELETE '.$table; // Create query to delete table
            }else{
                $delete = 'DELETE FROM '.$table.' WHERE '.$where; // Create query to delete rows
            }
            // Submit query to database
            if ($del = mysqli_query($this->myconn,$delete)) {
            // if($del = @mysql_query($delete)){
            	array_push($this->result,mysqli_affected_rows());
                $this->myQuery = $delete; // Pass back the SQL
                return true; // The query exectued correctly
            }else{
            	array_push($this->result,mysqli_error());
               	return false; // The query did not execute correctly
            }
        }else{
            return false; // The table does not exist
        }
    }

	// Function to update row in database
    public function update($table,$params=array(),$where){

    	// Check to see if table exists
    	if($this->tableExists($table)){
    		// Create Array to hold all the columns to update
            $args=array();
			foreach($params as $field=>$value){
				// Seperate each column out with it's corresponding value
				$args[]=$field.'="'.$value.'"';
			}
			// Create the query
			$sql='UPDATE '.$table.' SET '.implode(',',$args).' WHERE '.$where;
			// Make query to database

            $this->myQuery = $sql; // Pass back the SQL
            // echo $sql;
            if ($query = mysqli_query($this->myconn,$sql)){
            // if($query = @mysql_query($sql)){
            	array_push($this->result,mysqli_affected_rows());
            	return true; // Update has been successful
            }else{
            	array_push($this->result,mysqli_error());
                return false; // Update has not been successful
            }
        }else{
            // echo 'Not found table';
            return false; // The table does not exist
        }
    }

	// Private function to check if table exists for use with queries
	private function tableExists($table){
		$tablesInDb = @mysqli_query($this->myconn,'SHOW TABLES FROM '.$this->db_name.' LIKE "'.$table.'"');
        if($tablesInDb){
        	if(mysqli_num_rows($tablesInDb)==1){
                return true; // The table exists
            }else{
            	array_push($this->result,$table." does not exist in this database");
                return false; // The table does not exist
            }
        }
    }

	// Public function to return the data to the user
    public function getResult(){
        $val = $this->result;
        $this->result = array();
        return $val;
    }

    //Pass the SQL back for debugging
    public function getSql(){
        $val = $this->myQuery;
        $this->myQuery = array();
        return $val;
    }

    //Pass the number of rows back
    public function numRows(){
        $val = $this->numResults;
        //$this->numResults = array();
        return $val;
    }

	public function delResult()
	{
		unset($this->result);
		$this->results = null;
	}
}
