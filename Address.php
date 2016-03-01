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
}