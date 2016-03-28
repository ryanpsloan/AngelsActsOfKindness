
#Drop in reverse order of dependency
DROP TABLE IF EXISTS client;
DROP TABLE IF EXISTS volunteer;
DROP TABLE IF EXISTS service;
DROP TABLE IF EXISTS address;
DROP TABLE IF EXISTS zipcode;
DROP TABLE IF EXISTS city;
DROP TABLE IF EXISTS user;

#Create in order of dependency
CREATE TABLE user (
  userId    INT UNSIGNED NOT NULL AUTO_INCREMENT,
  userName  VARCHAR(64)  NOT NULL,
  password  CHAR(128)    NOT NULL,
  salt      CHAR(64)     NOT NULL,
  authToken CHAR(32),
  PRIMARY KEY (userId),
  UNIQUE (userName),
  INDEX (authToken)
);

CREATE TABLE city (
  cityId INT UNSIGNED NOT NULL AUTO_INCREMENT,
  cityName VARCHAR(128) NOT NULL,
  PRIMARY KEY (cityId),
  INDEX (cityName)

);

CREATE TABLE zipcode (
  zipId INT UNSIGNED NOT NULL AUTO_INCREMENT,
  zipCode VARCHAR(32) NOT NULL,
  PRIMARY KEY(zipId),
  INDEX (zipCode),
  UNIQUE(zipCode)


);

CREATE TABLE address(
  addressId INT UNSIGNED NOT NULL AUTO_INCREMENT,
  addressLine VARCHAR(128) NOT NULL,
  cityId INT UNSIGNED NOT NULL,
  state VARCHAR(16) NOT NULL,
  zipId INT UNSIGNED NOT NULL,
  PRIMARY KEY (addressId),
  FOREIGN KEY (cityId) REFERENCES city(cityId),
  FOREIGN KEY (zipId) REFERENCES zipcode(zipId),
  INDEX (addressLine)
);

CREATE TABLE service(
  serviceId INT UNSIGNED NOT NULL AUTO_INCREMENT,
  serviceName VARCHAR(256) NOT NULL,
  PRIMARY KEY (serviceId),
  INDEX(serviceName)
);

CREATE TABLE volunteer(
  volunteerId INT UNSIGNED NOT NULL AUTO_INCREMENT,
  vFullName VARCHAR(256) NOT NULL,
  vAddressId INT UNSIGNED NOT NULL,
  vTelHome VARCHAR(128) NOT NULL,
  vTelCell VARCHAR(128),
  vTelWork VARCHAR(128),
  vEmail VARCHAR(256) NOT NULL,
  vChurch VARCHAR(256),
  vServiceId INT UNSIGNED NOT NULL,
  vCityArea VARCHAR(128),
  vClientId INT UNSIGNED NOT NULL,
  PRIMARY KEY (volunteerId),
  FOREIGN KEY (vAddressId)REFERENCES address(addressId),
  FOREIGN KEY (vServiceId) REFERENCES service(serviceId),
  UNIQUE(vEmail),
  INDEX (vFullName),
  INDEX (vTelHome),
  INDEX (vTelCell),
  INDEX (vTelWork),
  INDEX (vEmail),
  INDEX (vChurch),
  INDEX (vCityArea)

);

CREATE TABLE client(
  clientId INT UNSIGNED NOT NULL AUTO_INCREMENT,
  fullName VARCHAR(128) NOT NULL,
  addressId INT UNSIGNED NOT NULL,
  telephone1 VARCHAR(128) NOT NULL,
  telephone2 VARCHAR(128) NOT NULL,
  school VARCHAR(64),
  email VARCHAR(256) NOT NULL,
  familySize INT UNSIGNED NOT NULL,
  cityArea VARCHAR(128),
  volunteerId INT UNSIGNED NOT NULL,
  serviceId INT UNSIGNED NOT NULL,
  PRIMARY KEY (clientId),
  FOREIGN KEY (addressId) REFERENCES address(addressId),
  FOREIGN KEY (volunteerId) REFERENCES volunteer(volunteerId),
  FOREIGN KEY (serviceId) REFERENCES service(serviceId),
  UNIQUE (email),
  INDEX (fullName),
  INDEX (telephone1),
  INDEX (telephone2),
  INDEX (school),
  INDEX (email),
  INDEX (cityArea)
);

ALTER TABLE volunteer ADD FOREIGN KEY (vClientId) REFERENCES client(clientId);