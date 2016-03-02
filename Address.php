<?php

/***
 * Class Address
 *
 * mySQL Enabled
 *
 * This is a mySQL enabled container for collecting and storing Address Data
 *
 *
 *
 */
class Address
{
    /***
     * Id for the address data, this is the primary key
     */
    private $addressId;
    /***
     * Id for the city from the foreign key table - city
     */
    private $cityId;
    /***
     * Id for the zipcode from the foreign key table - zipcode
     */
    private $zipId;
    /**
     * field for address data - address apt# etc.
     */
    private $addressLine;
    /**
     * place holder for the state information - always set to New Mexico
     */
    private $state;

    /**
     * constructor for Address
     *
     * @param mixed  $newAddressId address id (or null if a new object)
     * @param string $newAddressLine address data
     * @param int    $newCityId city id from city table;
     * @param int    $newZipId zipcode id from zipcode table;
     * @param string $newState state information always set to NM
     */
    public function __construct($newAddressId, $newAddressLine, $newCityId, $newZipId, $newState = "NM"){
        try{
            $this->setAddressId($newAddressId);
            $this->setAddressLine($newAddressLine);
            $this->setCityId($newCityId);
            $this->setZipId($newZipId);
            $this->setState($newState);
        }catch(UnexpectedValueException $unexpectedValue){
            throw (new UnexpectedValueException("Unable to construct Address - unexpected value", 0, $unexpectedValue));
        }catch(RangeException $range){
            throw (new RangeException("Unable to construct Address - range exception", 0, $range));
        }

    }

    /**
     * gets the value of addressId
     *
     * @return mixed address id (or null if new object)
     */
    public function getAddressId(){
        return $this->addressId;
    }

    /**
     * gets the value of addressLine
     *
     * @return string address info
     */
    public function getAddressLine(){
        return $this->addressLine;
    }

    /**
     * gets the value of cityId
     *
     * @return int city id
     */
    public function getCityId(){
        return $this->cityId;
    }

    /**
     * gets the value of zipId
     *
     * @return int zipId;
     */
    public function getZipId(){
        return $this->zipId;
    }

    /**
     * gets the value of state
     *
     * @return string state info
     */
    public function getState(){
        return $this->state;
    }

    /**
     * sets the value of address id
     *
     * @param mixed $newAddressId (or null if new object);
     * @throws UnexpectedValueException if not an integer or null
     * @throws RangeException if addressId is not positive
     */
    public function setAddressId($newAddressId){
        //allow address id to be null
        if($newAddressId === null){
            $this->addressId = null;
            return;
        }

        //ensure it is an integer
        if(filter_var($newAddressId, FILTER_VALIDATE_INT) === false){
            throw (new UnexpectedValueException("address Id $newAddressId is not numeric"));

        }

        //conver to integer and enforce that its positive
        $newAddressId = intval($newAddressId);
        if($newAddressId <= 0){
            throw (new RangeException("address id $newAddressId is not positive"));
        }

        //take out of quarantine and assign
        $this->addressId = $newAddressId;
    }

    /**
     * set the value of address line
     *
     * @param string $newAddressLine address info
     * @throws UnexpectedValueException if the input is not a string
     *
     *
     */

    public function setAddressLine($newAddressLine){
        //trim the string
        $newAddressLine = trim($newAddressLine);

        //enforce its a string
        if($newAddressLine = filter_var($newAddressLine, FILTER_SANITIZE_STRING) == false){
            throw (new UnexpectedValueException("address line $newAddressLine is not a string"));
        }

        //take out of quarantine and assign
        $this->addressLine = $newAddressLine;


    }

    /**
     * sets the value city Id
     *
     * @param mixed $newCityId
     * @throws UnexpectedValueException if not an integer or null
     * @throws RangeException if not positive
     */

    public function setCityId($newCityId){
        //allow to be set to null
        if($newCityId === null){
            $this->cityId = null;
            return;
        }

        //ensure it is an integer
        if(filter_var($newCityId, FILTER_VALIDATE_INT) === false){
            throw (new UnexpectedValueException("city id $newCityId is not an integer"));
        }

        //enforce that it is positive
        $newCityId = intval($newCityId);
        if($newCityId <= 0){
            throw (new RangeException("city id $newCityId is not positive"));
        }

        //take out of quarantine and assign
        $this->cityId = $newCityId;
    }

    /**
     * sets the value of zipId
     *
     * @param mixed $newZipId zip id (or null if new object)
     * @throws UnexpectedValueException if not an integer or null
     * @throws RangeException if not positive
     */

    public function setZipId($newZipId){
        //allow to be null
        if($newZipId === null){
            $this->zipId = null;
            return;
        }

        //ensure it is an integer
        if(filter_var($newZipId,FILTER_VALIDATE_INT) === false){
            throw (new UnexpectedValueException("zip id $newZipId is not an integer"));

        }

        //enforce that it is positive
        $newZipId = intval($newZipId);
        if($newZipId <= 0){
            throw (new RangeException("zip id $newZipId is not positive"));

        }

        //remove from quarantine and assign
        $this->zipId = $newZipId;
    }

    /**
     * sets the value of state
     *
     * @param string $newState
     * @throws UnexpectedValueException if not a string
     */

    public function setState($newState){
        //trim the string
        $newState = trim($newState);

        //sanitize the string
        if($newState = filter_var($newState,FILTER_SANITIZE_STRING) == false){
            thrown (new UnexpectedValueException("state $newState is not a string"));
        }

        //remove from quarantine and assign
        $this->state = $newState;
    }

    /**
     * inserts this Address into mySQL
     *
     * @param resource $mysqli pointer to mySQL connection, by reference
     * @throws mysqli_sql_exception when mySQL related errors occur
     *
     */

    public function insert(&$mysqli){
        //handle degernate cases
        if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli"){
            throw(new mysqli_sql_exception("input is not a mysqli object"));
        }

        //enforce the addressId is null (don't insert preexisting address)
        if($this->addressId !== null){
            throw(new mysqli_sql_exception("not a new address"));
        }

        try{
            //create query template
            $query = "INSERT INTO address(addressLine, state, cityId, zipId) VALUES(?,?,?,?)";
            $statement = $mysqli->prepare($query);
        }catch(Exception $e){
            $e->getMessage()."Unable to Prepare Statement";
        }

        //bind the member variables to the place holders in the template
        $wasClean = $statement->bind_param("ssii",$this->addressLine, $this->state, $this->cityId, $this->zipId);
        if($wasClean === false){
            throw (new mysqli_sql_exception("Unable to Bind Parameters"));
        }

        //execute the statement
        try{
            if($statement->execute() === false){
                throw(new mysqli_sql_exception("Unable to Execute mySQL statement"));
            }
        }catch(Exception $exception){
            $exception->getMessage();
        }

        $this->addressId = $mysqli->insert_id;
    }

    /**
     * deletes the address from mySQL
     *
     * @param resource $mysqli ponter to mySQL connection, by reference
     * @throws mysqli_sql_exception when mySQL related errors occur
     *
     */

    public function delete(&$mysqli){
        //handle degenerate cases
        if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli"){
            throw(new mysqli_sql_exception("input is not a mysqli object"));

        }

        //enforce the addressId is not null ( don't delete an address that hasnt been inserted)
        if($this->addressId === null){
            throw(new mysqli_sql_exception("Unable to delete a user that does not exist"));
        }

        //create query template
        $query = "DELETE FROM address WHERE addressId = ?";
        $statement = $mysqli->prepare($query);

        if($statement === false){
            throw(new mysqli_sql_exception("Unable to Prepare Statement"));
        }

        $wasClean = $statement->bind_param("i",$this->addressId);
        if($wasClean === false){
            throw(new mysqli_sql_exception("Unable to bind parameters"));
        }

        if($statement->execute() === false){
            throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
        }

    }

    /**
     * updates this address in mySQL
     *
     * @param resource $mysqli pointer to mySQL connection, by reference
     * @throws mysqli_sql_exception when mySQL related error occurs
     */
    public function update(&$mysqli){
        //handle degenerate cases
        if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli"){
            throw(new mysqli_sql_exception("input is not a mysqli object"));
        }

        //enforce that the id is not null (don't update an address that hasn't been inserted)
        if($this->addressId === null){
            throw(new mysqli_sql_exception("Unable to update an address that doesn't exist"));
        }

        //create query template
        $query = "UPDATE address SET addressLine = ?, cityId = ?, state = ?, zipId = ? WHERE addressId = ?";
        $statement = $mysqli->prepare($query);
        if($statement === false){
            throw(new mysqli_sql_exception("Unable to prepare statement"));

        }

        //bind the member variables to the place holders in the template
        $wasClean = $statement->bind_param("sisii", $this->addressLine, $this->cityId, $this->state, $this->zipId, $this->addressId);
        if($wasClean === false){
            throw(new mysqli_sql_exception("Unable to bind parameters"));
        }

        //execute the statement
        if($statement->execute() === false){
            throw(new mysqli_sql_exception("Unable to execute mySQL statment"));
        }
    }
}