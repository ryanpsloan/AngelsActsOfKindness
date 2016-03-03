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



}



?>