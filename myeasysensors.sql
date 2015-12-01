-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2015 at 08:00 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `myeasysensors`
--

-- --------------------------------------------------------

--
-- Table structure for table `node_sensors`
--

CREATE TABLE IF NOT EXISTS `node_sensors` (
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
-- Dumping data for table `node_sensors`
--

INSERT INTO `node_sensors` (`UserID`, `NodeID`, `SensorID`, `ChildID`, `Note`) VALUES
(1, 10, 3, 0, ''),
(1, 10, 2, 1, NULL),
(1, 10, 3, 2, 'gfgfgfdg'),
(1, 10, 1, 3, ''),
(1, 10, 1, 4, ''),
(1, 15, 2, 12, '');

-- --------------------------------------------------------

--
-- Table structure for table `pins`
--

CREATE TABLE IF NOT EXISTS `pins` (
  `PinID` int(11) NOT NULL AUTO_INCREMENT,
  `Address` varchar(2) NOT NULL,
  `Mode` varchar(10) NOT NULL,
  `Type` varchar(10) NOT NULL,
  PRIMARY KEY (`PinID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;

--
-- Dumping data for table `pins`
--

INSERT INTO `pins` (`PinID`, `Address`, `Mode`, `Type`) VALUES
(2, '0', 'INPUT', 'DIGITAL'),
(3, '0', 'OUTPUT', 'DIGITAL'),
(4, '0', 'INPUT', 'SERIAL'),
(5, '1', 'INPUT', 'DIGITAL'),
(6, '1', 'OUTPUT', 'DIGITAL'),
(7, '1', 'OUTPUT', 'SERIAL'),
(8, '2', 'INPUT', 'DIGITAL'),
(9, '2', 'OUTPUT', 'DIGITAL'),
(10, '2', 'INPUT', 'IRQ0'),
(11, '3', 'INPUT', 'DIGITAL'),
(12, '3', 'OUTPUT', 'DIGITAL'),
(13, '3', 'OUTPUT', 'ANALOG'),
(14, '3', 'OUTPUT', 'PWM2'),
(15, '3', 'INPUT', 'IRQ1'),
(16, '4', 'INPUT', 'DIGITAL'),
(17, '4', 'OUTPUT', 'DIGITAL'),
(18, '5', 'INPUT', 'DIGITAL'),
(19, '5', 'OUTPUT', 'DIGITAL'),
(20, '5', 'OUTPUT', 'PWM0'),
(21, '6', 'INPUT', 'DIGITAL'),
(22, '6', 'OUTPUT', 'DIGITAL'),
(23, '6', 'OUTPUT', 'PWM0'),
(24, '7', 'INPUT', 'DIGITAL'),
(25, '7', 'OUTPUT', 'DIGITAL'),
(26, '8', 'INPUT', 'DIGITAL'),
(27, '8', 'OUTPUT', 'DIGITAL'),
(28, '9', 'INPUT', 'DIGITAL'),
(29, '9', 'OUTPUT', 'DIGITAL'),
(30, '9', 'OUTPUT', 'PWM1'),
(31, '10', 'INPUT', 'DIGITAL'),
(32, '10', 'OUTPUT', 'DIGITAL'),
(33, '10', 'OUTPUT', 'PWM1'),
(34, '10', 'OUTPUT', 'SS'),
(35, '11', 'INPUT', 'DIGITAL'),
(36, '11', 'OUTPUT', 'DIGITAL'),
(37, '11', 'OUTPUT', 'PWM2'),
(38, '11', 'INPUT', 'MOSI'),
(39, '12', 'INPUT', 'DIGITAL'),
(40, '12', 'OUTPUT', 'DIGITAL'),
(41, '12', 'OUTPUT', 'MISO'),
(42, '13', 'INPUT', 'DIGITAL'),
(43, '13', 'OUTPUT', 'DIGITAL'),
(44, '13', 'OUTPUT', 'SCK'),
(45, 'A0', 'INPUT', 'DIGITAL'),
(46, 'A0', 'OUTPUT', 'DIGITAL'),
(47, 'A0', 'INPUT', 'ANALOG'),
(48, 'A1', 'INPUT', 'DIGITAL'),
(49, 'A1', 'OUTPUT', 'DIGITAL'),
(50, 'A1', 'INPUT', 'ANALOG'),
(51, 'A2', 'INPUT', 'DIGITAL'),
(52, 'A2', 'OUTPUT', 'DIGITAL'),
(53, 'A2', 'INPUT', 'ANALOG'),
(54, 'A3', 'INPUT', 'DIGITAL'),
(55, 'A3', 'OUTPUT', 'DIGITAL'),
(56, 'A3', 'INPUT', 'ANALOG'),
(57, 'A4', 'INPUT', 'DIGITAL'),
(58, 'A4', 'OUTPUT', 'DIGITAL'),
(59, 'A4', 'INPUT', 'ANALOG'),
(60, 'A4', 'INPUT', 'SDA'),
(61, 'A5', 'INPUT', 'DIGITAL'),
(62, 'A5', 'OUTPUT', 'DIGITAL'),
(63, 'A5', 'INPUT', 'ANALOG'),
(64, 'A5', 'OUTPUT', 'SDL');

-- --------------------------------------------------------

--
-- Table structure for table `sensors`
--

CREATE TABLE IF NOT EXISTS `sensors` (
  `SensorID` int(11) NOT NULL AUTO_INCREMENT,
  `SensorName` varchar(30) NOT NULL,
  `VType` varchar(20) NOT NULL,
  `SType` varchar(20) NOT NULL,
  PRIMARY KEY (`SensorID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `sensors`
--

INSERT INTO `sensors` (`SensorID`, `SensorName`, `VType`, `SType`) VALUES
(0, 'ALL SENSORS', '', ''),
(1, 'Dallas Temperature Sensor', 'V_TEMP', 'S_TEMP'),
(2, 'DHT Temperature Sensor', 'V_TEMP', 'S_TEMP'),
(3, 'DHT Humidity Sensor', 'V_HUM', 'S_HUM');

-- --------------------------------------------------------

--
-- Table structure for table `sensor_pins`
--

CREATE TABLE IF NOT EXISTS `sensor_pins` (
  `SensorPinID` int(11) NOT NULL AUTO_INCREMENT,
  `SensorID` int(11) NOT NULL,
  `PinNumber` int(11) NOT NULL,
  `PinID` int(11) NOT NULL,
  PRIMARY KEY (`SensorPinID`),
  KEY `SensorID` (`SensorID`),
  KEY `PinID` (`PinID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sensor_pins`
--

INSERT INTO `sensor_pins` (`SensorPinID`, `SensorID`, `PinNumber`, `PinID`) VALUES
(0, 1, 0, 10),
(1, 1, 0, 11),
(2, 1, 0, 12),
(3, 1, 0, 13),
(4, 2, 0, 17),
(5, 2, 1, 21);

-- --------------------------------------------------------

--
-- Table structure for table `sensor_snippet`
--

CREATE TABLE IF NOT EXISTS `sensor_snippet` (
  `SensorID` int(11) NOT NULL,
  `SnippetID` int(11) NOT NULL,
  PRIMARY KEY (`SensorID`,`SnippetID`),
  KEY `SnippetID` (`SnippetID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sensor_snippet`
--

INSERT INTO `sensor_snippet` (`SensorID`, `SnippetID`) VALUES
(0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `set_pins`
--

CREATE TABLE IF NOT EXISTS `set_pins` (
  `UserID` int(11) NOT NULL,
  `NodeID` int(11) NOT NULL,
  `ChildID` int(11) NOT NULL,
  `SensorPinID` int(11) NOT NULL,
  PRIMARY KEY (`UserID`,`NodeID`,`ChildID`,`SensorPinID`),
  KEY `ChildID` (`ChildID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `snippets`
--

CREATE TABLE IF NOT EXISTS `snippets` (
  `SnippetID` int(11) NOT NULL AUTO_INCREMENT,
  `Type` varchar(20) NOT NULL,
  `CodeSnippet` text NOT NULL,
  `Weight` int(11) NOT NULL,
  PRIMARY KEY (`SnippetID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `snippets`
--

INSERT INTO `snippets` (`SnippetID`, `Type`, `CodeSnippet`, `Weight`) VALUES
(1, 'INCLUDE', '#include <SPI.h>\r\n#include <MySensor.h>', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `UserName`, `Password`, `FirstName`, `LastName`, `Email`) VALUES
(1, 'test', '*94BDCEBE19083CE2A1F959FD02F964C7AF4CFC29', 'test', 'test', 'test@test.com');

-- --------------------------------------------------------

--
-- Table structure for table `user_nodes`
--

CREATE TABLE IF NOT EXISTS `user_nodes` (
  `UserID` int(11) NOT NULL,
  `NodeID` int(11) NOT NULL,
  `Note` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`UserID`,`NodeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_nodes`
--

INSERT INTO `user_nodes` (`UserID`, `NodeID`, `Note`) VALUES
(1, 10, NULL),
(1, 15, 'gfgdf'),
(1, 200, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `node_sensors`
--
ALTER TABLE `node_sensors`
  ADD CONSTRAINT `FK_NODE_SENS_USR_NOD` FOREIGN KEY (`UserID`, `NodeID`) REFERENCES `user_nodes` (`UserID`, `NodeID`),
  ADD CONSTRAINT `Node_Sensors_ibfk_1` FOREIGN KEY (`SensorID`) REFERENCES `sensors` (`SensorID`);

--
-- Constraints for table `sensor_pins`
--
ALTER TABLE `sensor_pins`
  ADD CONSTRAINT `FK_SEN_REQ_PIN_PIN` FOREIGN KEY (`PinID`) REFERENCES `pins` (`PinID`),
  ADD CONSTRAINT `FK_SEN_REQ_PIN_SEN` FOREIGN KEY (`SensorID`) REFERENCES `sensors` (`SensorID`);

--
-- Constraints for table `sensor_snippet`
--
ALTER TABLE `sensor_snippet`
  ADD CONSTRAINT `FK_SEN_SNI_SEN` FOREIGN KEY (`SensorID`) REFERENCES `sensors` (`SensorID`),
  ADD CONSTRAINT `FK_SEN_SNI_SNI` FOREIGN KEY (`SnippetID`) REFERENCES `snippets` (`SnippetID`);

--
-- Constraints for table `set_pins`
--
ALTER TABLE `set_pins`
  ADD CONSTRAINT `FK_USR_NOD_SET_PIN_NOD_SEN` FOREIGN KEY (`UserID`, `NodeID`, `ChildID`) REFERENCES `node_sensors` (`UserID`, `NodeID`, `ChildID`),
  ADD CONSTRAINT `FK_USR_NOD_SET_PIN_PIN` FOREIGN KEY (`SensorPinID`) REFERENCES `sensor_pins` (`SensorPinID`);

--
-- Constraints for table `user_nodes`
--
ALTER TABLE `user_nodes`
  ADD CONSTRAINT `FK_USR_NODES_USRID` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
