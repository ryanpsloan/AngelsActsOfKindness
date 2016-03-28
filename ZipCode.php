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


}



?>