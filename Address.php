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


}