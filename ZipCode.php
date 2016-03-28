<?php

class ZipCode{

    /**
     *zip id for ZipCode, primary key
     */

    private $zipId;

    /**
     *zipCode field
     *
     */

    private $zipCode;

    /**
     * ZipCode constructor.
     * @param mixed $newZipId or null if new object
     * @param string $newZipCode
     * @throws UnexpectedValueException when a parameter is the wrong type
     *
     */

    public function __construct($newZipId, $newZipCode){
        try{
            $this->setZipId($newZipId);
            $this->setZipCode($newZipCode);

        }catch(UnexpectedValueException $unexpectedValue){
            throw(new UnexpectedValueException("Unable to Construct ZipCode",0,$unexpectedValue));
        }
    }

    /***
     * gets the value of zipId
     *
     * @return mixed int or null
     */
    public function getZipId(){
        return $this->zipId;
    }

    /**
     * gets the value of zipCode
     *
     * @return string
     */
    public function getZipCode(){
        return $this->zipCode;
    }
    /*****
     * sets the value of zidId
     * @param $newZipId null or int
     * @throws UnexpectedValueException if $newZipId is not an int or null
     * @throws RangeException if $newZipId is not positive
     *
     */
    public function setZipId($newZipId){
        if($newZipId === null){
            $this->zipId = null;
            return;
        }

        if(filter_var($newZipId, FILTER_VALIDATE_INT) === false){
            throw(new UnexpectedValueException("zipId $newZipId is not an integer"));
        }

        $newZipId = intval($newZipId);

        if($newZipId <= 0){
            throw(new RangeException("zipId $newZipId is not positive"));
        }

        $this->zipId = $newZipId;
    }
    /***
     * sets the value of zipCode
     *
     * @param $newZipCode string
     *
     * @throws UnexpectedValueException if not a string
     *
     */

      public function setZipCode($newZipCode){
          $newZipCode = trim($newZipCode);
          if(filter_var($newZipCode, FILTER_SANITIZE_STRING)){
              throw(new UnexpectedValueException("zipCode $newZipCode is not a string"));
          }
          $this->zipCode = $newZipCode;
      }
    /**insert MySQLI enabled function - inserts into the zipcode database
     * @param $mysqli resource by reference
     *
     * @throws mysqli_sql_exception if cannot prepare statement, bind param, or execute statement
     *
     */

    public function insert(&$mysqli)
    {
        // handle degenerate cases
        if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
            throw(new mysqli_sql_exception("input is not a mysqli object"));
        }
        // enforce the zipId is null (i.e., don't insert a zip that already exists)
        if($this->zipId !== null) {
            throw(new mysqli_sql_exception("not a new zipcode"));
        }
        try {
            // create query template
            $query = "INSERT INTO zipcode(zipCode) VALUES(?)";
            $statement = $mysqli->prepare($query);
        } catch(Exception $e){
            $e->getMessage()."Unable to Prepare Statement";
        }
        // bind the member variables to the place holders in the template
        $wasClean = $statement->bind_param("s", $this->zipCode);
        if($wasClean === false) {
            throw(new mysqli_sql_exception("Unable to bind parameters"));
        }
        // execute the statement
        try {
            if($statement->execute() === false) {
                //throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
            }
        }catch(Exception $exception){
            $exception->getMessage();
        }
        // update the null userId with what mySQL just gave us
        $this->zipId = $mysqli->insert_id;

    }
    /***
     * delete MYSQLI enabled function - deletes value by id from zipcode table
     * @param $mysqli resource by reference
     * @throws  mysqli_sql_exception when SQL related error occurs
     */
    public function delete(&$mysqli) {
        // handle degenerate cases
        if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
            throw(new mysqli_sql_exception("input is not a mysqli object"));
        }
        // enforce the zipId is not null (i.e., don't delete a zip that hasn't been inserted)
        if($this->zipId === null) {
            throw(new mysqli_sql_exception("Unable to delete a profile that does not exist"));
        }
        // create query template
        $query     = "DELETE FROM zipcode WHERE zipId = ?";
        $statement = $mysqli->prepare($query);
        if($statement === false) {
            throw(new mysqli_sql_exception("Unable to prepare statement"));
        }
        // bind the member variables to the place holder in the template
        $wasClean = $statement->bind_param("i", $this->zipId);
        if($wasClean === false) {
            throw(new mysqli_sql_exception("Unable to bind parameters"));
        }
        // execute the statement
        if($statement->execute() === false) {
            throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
        }
    }

    /*
     * update MYSQLI enabled function - updates zipcode table
     * @param $mysqli resource by reference
     * @throw mysqli_sql_exception when mysql related error occurs
     */

    public function update(&$mysqli) {
        // handle degenerate cases
        if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
            throw(new mysqli_sql_exception("input is not a mysqli object"));
        }
        // enforce the zipdId is not null (i.e., don't update a zipcode that hasn't been inserted)
        if($this->zipId === null) {
            throw(new mysqli_sql_exception("Unable to update a zipcode that does not exist"));
        }
        // create query template
        $query     = "UPDATE zipcode SET zipCode = ? WHERE zipId = ?";
        $statement = $mysqli->prepare($query);
        if($statement === false) {
            throw(new mysqli_sql_exception("Unable to prepare statement"));
        }

        // bind the member variables to the place holders in the template
        $wasClean = $statement->bind_param("s",$this->zipCode);
        if($wasClean === false) {
            throw(new mysqli_sql_exception("Unable to bind parameters"));
        }
        // execute the statement
        if($statement->execute() === false) {
            throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
        }
    }




}



?>