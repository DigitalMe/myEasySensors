-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 26, 2015 at 06:02 PM
-- Server version: 5.5.46-0ubuntu0.14.04.2
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `Project`
--

-- --------------------------------------------------------

--
-- Table structure for table `Node_Sensors`
--

CREATE TABLE IF NOT EXISTS `Node_Sensors` (
  `UserID` int(11) NOT NULL,
  `NodeID` int(11) NOT NULL,
  `SensorID` int(11) NOT NULL,
  `ChildID` int(11) NOT NULL,
  `Note` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`UserID`,`NodeID`,`ChildID`),
  KEY `SensorID` (`SensorID`),
  KEY `UserID` (`UserID`,`NodeID`,`SensorID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Node_Sensors`
--

INSERT INTO `Node_Sensors` (`UserID`, `NodeID`, `SensorID`, `ChildID`, `Note`) VALUES
(1, 10, 1, 0, NULL),
(1, 10, 2, 1, NULL),
(1, 10, 2, 2, NULL),
(1, 11, 2, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Pins`
--

CREATE TABLE IF NOT EXISTS `Pins` (
  `PinID` int(11) NOT NULL AUTO_INCREMENT,
  `Address` varchar(2) NOT NULL,
  `Mode` varchar(10) NOT NULL,
  `Type` varchar(10) NOT NULL,
  PRIMARY KEY (`PinID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Sensors`
--

CREATE TABLE IF NOT EXISTS `Sensors` (
  `SensorID` int(11) NOT NULL AUTO_INCREMENT,
  `SensorName` varchar(30) NOT NULL,
  `VType` varchar(20) NOT NULL,
  `SType` varchar(20) NOT NULL,
  PRIMARY KEY (`SensorID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `Sensors`
--

INSERT INTO `Sensors` (`SensorID`, `SensorName`, `VType`, `SType`) VALUES
(0, 'ALL SENSORS', '', ''),
(1, 'Dallas Temperature Sensor', 'V_TEMP', 'S_TEMP'),
(2, 'DHT Temperature Sensor', 'V_TEMP', 'S_TEMP'),
(3, 'DHT Humidity Sensor', 'V_HUM', 'S_HUM');

-- --------------------------------------------------------

--
-- Table structure for table `Sensor_Pins`
--

CREATE TABLE IF NOT EXISTS `Sensor_Pins` (
  `SensorID` int(11) NOT NULL,
  `PinNumber` int(11) NOT NULL,
  `PinID` int(11) NOT NULL,
  PRIMARY KEY (`SensorID`,`PinNumber`,`PinID`),
  KEY `PinID` (`PinID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Sensor_Snippet`
--

CREATE TABLE IF NOT EXISTS `Sensor_Snippet` (
  `SensorID` int(11) NOT NULL,
  `SnippetID` int(11) NOT NULL,
  PRIMARY KEY (`SensorID`,`SnippetID`),
  KEY `SnippetID` (`SnippetID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Sensor_Snippet`
--

INSERT INTO `Sensor_Snippet` (`SensorID`, `SnippetID`) VALUES
(0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Snippets`
--

CREATE TABLE IF NOT EXISTS `Snippets` (
  `SnippetID` int(11) NOT NULL AUTO_INCREMENT,
  `Type` varchar(20) NOT NULL,
  `CodeSnippet` text NOT NULL,
  `Weight` int(11) NOT NULL,
  PRIMARY KEY (`SnippetID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `Snippets`
--

INSERT INTO `Snippets` (`SnippetID`, `Type`, `CodeSnippet`, `Weight`) VALUES
(1, 'INCLUDE', '#include <SPI.h>\r\n#include <MySensor.h>', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`UserID`, `UserName`, `Password`, `FirstName`, `LastName`, `Email`) VALUES
(1, 'test', '*94BDCEBE19083CE2A1F959FD02F964C7AF4CFC29', 'test', 'test', 'test@test.com');

-- --------------------------------------------------------

--
-- Table structure for table `User_Nodes`
--

CREATE TABLE IF NOT EXISTS `User_Nodes` (
  `UserID` int(11) NOT NULL,
  `NodeID` int(11) NOT NULL,
  `Note` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`UserID`,`NodeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `User_Nodes`
--

INSERT INTO `User_Nodes` (`UserID`, `NodeID`, `Note`) VALUES
(1, 10, NULL),
(1, 11, NULL),
(1, 200, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `User_Node_Set_Pins`
--

CREATE TABLE IF NOT EXISTS `User_Node_Set_Pins` (
  `UserID` int(11) NOT NULL,
  `NodeID` int(11) NOT NULL,
  `SensorID` int(11) NOT NULL,
  `PinID` int(11) NOT NULL,
  `PinNumber` int(11) NOT NULL,
  PRIMARY KEY (`UserID`,`NodeID`,`SensorID`,`PinNumber`),
  KEY `PinID` (`PinID`),
  KEY `SensorID` (`SensorID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Node_Sensors`
--
ALTER TABLE `Node_Sensors`
  ADD CONSTRAINT `Node_Sensors_ibfk_1` FOREIGN KEY (`SensorID`) REFERENCES `Sensors` (`SensorID`),
  ADD CONSTRAINT `FK_NODE_SENS_USR_NOD` FOREIGN KEY (`UserID`, `NodeID`) REFERENCES `User_Nodes` (`UserID`, `NodeID`);

--
-- Constraints for table `Sensor_Pins`
--
ALTER TABLE `Sensor_Pins`
  ADD CONSTRAINT `FK_SEN_REQ_PIN_PIN` FOREIGN KEY (`PinID`) REFERENCES `Pins` (`PinID`),
  ADD CONSTRAINT `FK_SEN_REQ_PIN_SEN` FOREIGN KEY (`SensorID`) REFERENCES `Sensors` (`SensorID`);

--
-- Constraints for table `Sensor_Snippet`
--
ALTER TABLE `Sensor_Snippet`
  ADD CONSTRAINT `FK_SEN_SNI_SEN` FOREIGN KEY (`SensorID`) REFERENCES `Sensors` (`SensorID`),
  ADD CONSTRAINT `FK_SEN_SNI_SNI` FOREIGN KEY (`SnippetID`) REFERENCES `Snippets` (`SnippetID`);

--
-- Constraints for table `User_Nodes`
--
ALTER TABLE `User_Nodes`
  ADD CONSTRAINT `FK_USR_NODES_USRID` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`);

--
-- Constraints for table `User_Node_Set_Pins`
--
ALTER TABLE `User_Node_Set_Pins`
  ADD CONSTRAINT `FK_USR_NOD_SET_PIN_NOD_SEN` FOREIGN KEY (`UserID`, `NodeID`, `SensorID`) REFERENCES `Node_Sensors` (`UserID`, `NodeID`, `SensorID`),
  ADD CONSTRAINT `FK_USR_NOD_SET_PIN_PIN` FOREIGN KEY (`PinID`) REFERENCES `Pins` (`PinID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
