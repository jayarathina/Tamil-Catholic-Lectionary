
-- --------------------------------------------------------

--
-- Table structure for table `readings__ow`
--

CREATE TABLE `readings__ow` (
  `dayID` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `YearCycle` tinyint(4) NOT NULL,
  `dayTitle` text CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `reading1` text COLLATE utf8_unicode_ci NOT NULL,
  `psalms` text CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `Response` text COLLATE utf8_unicode_ci NOT NULL,
  `ResponseVs` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Single Reading';

--
-- Dumping data for table `readings__ow`
--

INSERT INTO `readings__ow` (`dayID`, `YearCycle`, `dayTitle`, `reading1`, `psalms`, `Response`, `ResponseVs`) VALUES
('OW01-1Mon', 1, '', 'எபி1:1-6', 'திபா97:1,2b.6,7c.9', '', ''),
('OW01-1Mon', 2, '', '1சாமு1:1-8', 'திபா116:12-13.14-17.18-19', '', ''),
('OW01-2Tue', 1, '', 'எபி2:5-12', 'திபா8:2ab,5.6-7.8-9', '', ''),
('OW01-2Tue', 2, '', '1சாமு1:9-20', '1சாமு2:1.4-5.6-7.8', '', ''),
('OW01-3Wed', 1, '', 'எபி2:14-18', 'திபா105:1-2.3-4.6-7.8-9', '', ''),
('OW01-3Wed', 2, '', '1சாமு3:1-10,19-20', 'திபா40:2,5.7-8a.8b-9.10', '', ''),
('OW01-4Thu', 1, '', 'எபி3:7-14', 'திபா95:6-7c.8-9.10-11', '', ''),
('OW01-4Thu', 2, '', '1சாமு4:1-11', 'திபா44:10-11.14-15.24-25', '', ''),
('OW01-5Fri', 1, '', 'எபி4:1-5,11', 'திபா78:3,4bc.6c-7.8', '', ''),
('OW01-5Fri', 2, '', '1சாமு8:4-7,10-22a', 'திபா89:16-17.18-19', '', ''),
('OW01-6Sat', 1, '', 'எபி4:12-16', 'திபா19:8.9.10.15', '', ''),
('OW01-6Sat', 2, '', '1சாமு9:1-4,17-19;10:1', 'திபா21:2-3.4-5.6-7', '', ''),
('OW02-1Mon', 1, '', 'எபி5:1-10', 'திபா110:1.2.3.4', '', ''),
('OW02-1Mon', 2, '', '1சாமு15:16-23', 'திபா50:8-9.16bc-17.21,23', '', ''),
('OW02-2Tue', 1, '', 'எபி6:10-20', 'திபா111:1-2.4-5.9,10c', '', ''),
('OW02-2Tue', 2, '', '1சாமு16:1-13', 'திபா89:20.21-22.27-28', '', ''),
('OW02-3Wed', 1, '', 'எபி7:1-3,15-17', 'திபா110:1.2.3.4', '', ''),
('OW02-3Wed', 2, '', '1சாமு17:32-33,37,40-51', 'திபா144:1b.2.9-10', '', ''),
('OW02-4Thu', 1, '', 'எபி7:25-8:6', 'திபா40:7-8a.8b-9.10.17', '', ''),
('OW02-4Thu', 2, '', '1சாமு18:6-9;19:1-7', 'திபா56:2-3.9-10a.10b-11.12-13', '', ''),
('OW02-5Fri', 1, '', 'எபி8:6-13', 'திபா85:8,10.11-12.13-14', '', ''),
('OW02-5Fri', 2, '', '1சாமு24:3-21', 'திபா57:2.3-4.6,11', '', ''),
('OW02-6Sat', 1, '', 'எபி9:2-3,11-14', 'திபா47:2-3.6-7.8-9', '', ''),
('OW02-6Sat', 2, '', '2சாமு1:1-4,11-12,19,23-27', 'திபா80:2-3.5-7', '', ''),
('OW03-1Mon', 1, '', 'எபி9:15,24-28', 'திபா98:1.2-3ab.3cd-4.5-6', '', ''),
('OW03-1Mon', 2, '', '2சாமு5:1-7,10', 'திபா89:20.21-22.25-26', '', ''),
('OW03-2Tue', 1, '', 'எபி10:1-10', 'திபா40:2,4ab.7-8a.10.11', '', ''),
('OW03-2Tue', 2, '', '2சாமு6:12b-15,17-19', 'திபா24:7.8.9.10', '', ''),
('OW03-3Wed', 1, '', 'எபி10:11-18', 'திபா110:1.2.3.4', '', ''),
('OW03-3Wed', 2, '', '2சாமு7:4-17', 'திபா89:4-5.27-28.29-30', '', ''),
('OW03-4Thu', 1, '', 'எபி10:19-25', 'திபா24:1-2.3-4ab.5-6', '', ''),
('OW03-4Thu', 2, '', '2சாமு7:18-19,24-29', 'திபா132:1-2.3-5.11.12.13-14', '', ''),
('OW03-5Fri', 1, '', 'எபி10:32-39', 'திபா37:3-4.5-6.23-24.39-40', '', ''),
('OW03-5Fri', 2, '', '2சாமு11:1-4a,5-10a,13-17', 'திபா51:3-4.5-6a.6bcd-7.10-11', '', ''),
('OW03-6Sat', 1, '', 'எபி11:1-2,8-19', 'லூக்1:69-70.71-72.73-75', '', ''),
('OW03-6Sat', 2, '', '2சாமு12:1-7a,10-17', 'திபா51:12-13.14-15.16-17', '', ''),
('OW04-1Mon', 1, '', 'எபி11:32-40', 'திபா31:20.21.22.23.24', '', ''),
('OW04-1Mon', 2, '', '2சாமு15:13-14,30;16:5-13', 'திபா3:2-3.4-5.6-7', '', ''),
('OW04-2Tue', 1, '', 'எபி12:1-4', 'திபா22:26b-27.28,30.31-32', '', ''),
('OW04-2Tue', 2, '', '2சாமு18:9-10,14b,24-25a,30-19:3', 'திபா86:1-2.3-4.5-6', '', ''),
('OW04-3Wed', 1, '', 'எபி12:4-7,11-15', 'திபா103:1-2.13-14.17-18a', '', ''),
('OW04-3Wed', 2, '', '2சாமு24:2,9-17', 'திபா32:1-2.5.6.7', '', ''),
('OW04-4Thu', 1, '', 'எபி12:18-19,21-24', 'திபா48:2-3ab.3cd-4.9.10-11', '', ''),
('OW04-4Thu', 2, '', '1அர2:1-4,10-12', '1குறி29:10b.11ab.11cd-12a.12bcd', '', ''),
('OW04-5Fri', 1, '', 'எபி13:1-8', 'திபா27:1.3.5.8b-9abc', '', ''),
('OW04-5Fri', 2, '', 'சீஞா47:2-11', 'திபா18:31.47,50.51', '', ''),
('OW04-6Sat', 1, '', 'எபி13:15-17,20-21', 'திபா23:1-3a.3b-4.5.6', '', ''),
('OW04-6Sat', 2, '', '1அர3:4-13', 'திபா119:9.10.11.12.13.14', '', ''),
('OW05-1Mon', 1, '', 'தொநூ1:1-19', 'திபா104:1-2a.5-6.10,12.24,35c', '', ''),
('OW05-1Mon', 2, '', '1அர8:1-7,9-13', 'திபா132:6-7.8-10', '', ''),
('OW05-2Tue', 1, '', 'தொநூ1:20-2:4a', 'திபா8:4-5.6-7.8-9', '', ''),
('OW05-2Tue', 2, '', '1அர8:22-23,27-30', 'திபா84:3.4.5,10.11', '', ''),
('OW05-3Wed', 1, '', 'தொநூ2:4b-9,15-17', 'திபா104:1-2a.27-28.29bc-30', '', ''),
('OW05-3Wed', 2, '', '1அர10:1-10', 'திபா37:5-6.30-31.39-40', '', ''),
('OW05-4Thu', 1, '', 'தொநூ2:18-25', 'திபா128:1-2.3.4-5', '', ''),
('OW05-4Thu', 2, '', '1அர11:4-13', 'திபா106:3-4.35-36.37,40', '', ''),
('OW05-5Fri', 1, '', 'தொநூ3:1-8', 'திபா32:1-2.5.6.7', '', ''),
('OW05-5Fri', 2, '', '1அர11:29-32;12:19', 'திபா81:10-11ab.12-13.14-15', '', ''),
('OW05-6Sat', 1, '', 'தொநூ3:9-24', 'திபா90:2.3-4abc.5-6.12-13', '', ''),
('OW05-6Sat', 2, '', '1அர12:26-32;13:33-34', 'திபா106:6-7ab.19-20.21-22', '', ''),
('OW06-1Mon', 1, '', 'தொநூ4:1-15,25', 'திபா50:1,8.16bc-17.20-21', '', ''),
('OW06-1Mon', 2, '', 'யாக்1:1-11', 'திபா119:67.68.71.72.75.76', '', ''),
('OW06-2Tue', 1, '', 'தொநூ6:5-8;7:1-5,10', 'திபா29:1a,2.3ac-4.3b,9c-10', '', ''),
('OW06-2Tue', 2, '', 'யாக்1:12-18', 'திபா94:12-13a.14-15.18-19', '', ''),
('OW06-3Wed', 1, '', 'தொநூ8:6-13,20-22', 'திபா116:12-13.14-15.18-19', '', ''),
('OW06-3Wed', 2, '', 'யாக்1:19-27', 'திபா15:2-3a.3bc-4ab.5', '', ''),
('OW06-4Thu', 1, '', 'தொநூ9:1-13', 'திபா102:16-18.19-21.29,22-23', '', ''),
('OW06-4Thu', 2, '', 'யாக்2:1-9', 'திபா34:2-3.4-5.6-7', '', ''),
('OW06-5Fri', 1, '', 'தொநூ11:1-9', 'திபா33:10-11.12-13.14-15', '', ''),
('OW06-5Fri', 2, '', 'யாக்2:14-24,26', 'திபா112:1-2.3-4.5-6', '', ''),
('OW06-6Sat', 1, '', 'எபி11:1-7', 'திபா145:2-3.4-5.10-11', '', ''),
('OW06-6Sat', 2, '', 'யாக்3:1-10', 'திபா12:2-3.4-5.7-8', '', ''),
('OW07-1Mon', 1, '', 'சீஞா1:1-10', 'திபா93:1ab.1cd-2.5', '', ''),
('OW07-1Mon', 2, '', 'யாக்3:13-18', 'திபா19:8.9.10.15', '', ''),
('OW07-2Tue', 1, '', 'சீஞா2:1-11', 'திபா37:3-4.18-19.27-28.39-40', '', ''),
('OW07-2Tue', 2, '', 'யாக்4:1-10', 'திபா55:7-8.9-10a.10b-11a.23', '', ''),
('OW07-3Wed', 1, '', 'சீஞா4:11-19', 'திபா119:165.168.171.172.174.175', '', ''),
('OW07-3Wed', 2, '', 'யாக்4:13-17', 'திபா49:2-3.6-7.8-10.11', '', ''),
('OW07-4Thu', 1, '', 'சீஞா5:1-8', 'திபா1:1-2.3.4,6', '', ''),
('OW07-4Thu', 2, '', 'யாக்5:1-6', 'திபா49:14-15ab.15cd-16.17-18.19-20', '', ''),
('OW07-5Fri', 1, '', 'சீஞா6:5-17', 'திபா119:12.16.18.27.34.35', '', ''),
('OW07-5Fri', 2, '', 'யாக்5:9-12', 'திபா103:1-2.3-4.8-9.11-12', '', ''),
('OW07-6Sat', 1, '', 'சீஞா17:1-15', 'திபா103:13-14.15-16.17-18a', '', ''),
('OW07-6Sat', 2, '', 'யாக்5:13-20', 'திபா141:1-2.3,8', '', ''),
('OW08-1Mon', 1, '', 'சீஞா17:20-24', 'திபா32:1-2.5.6.7', '', ''),
('OW08-1Mon', 2, '', '1பேது1:3-9', 'திபா111:1-2.5-6.9.,10c', '', ''),
('OW08-2Tue', 1, '', 'சீஞா35:1-12', 'திபா50:5-6.7-8.14,23', '', ''),
('OW08-2Tue', 2, '', '1பேது1:10-16', 'திபா98:1.2-3ab.3cd-4', '', ''),
('OW08-3Wed', 1, '', 'சீஞா36:1,4-5a,10-17', 'திபா79:8.9.11,13', '', ''),
('OW08-3Wed', 2, '', '1பேது1:18-25', 'திபா147:12-13.14-15.19-20', '', ''),
('OW08-4Thu', 1, '', 'சீஞா42:15-25', 'திபா33:2-3.4-5.6-7.8-9', '', ''),
('OW08-4Thu', 2, '', '1பேது2:2-5,9-12', 'திபா100:2.3.4.5', '', ''),
('OW08-5Fri', 1, '', 'சீஞா44:1,9-13', 'திபா149:1b-2.3-4.5-6a,9b', '', ''),
('OW08-5Fri', 2, '', '1பேது4:7-13', 'திபா96:10.11-12.13', '', ''),
('OW08-6Sat', 1, '', 'சீஞா51:12cd-20', 'திபா19:8.9.10.11', '', ''),
('OW08-6Sat', 2, '', 'யூதா17,20b-25', 'திபா63:2.3-4.5-6', '', ''),
('OW09-1Mon', 1, '', 'தோபி1:3;2:1a-8', 'திபா112:1b-2.3b-4.5-6', '', ''),
('OW09-1Mon', 2, '', '2பேது1:2-7', 'திபா91:1-2.14-15ab.15c-16', '', ''),
('OW09-2Tue', 1, '', 'தோபி2:9-14', 'திபா112:1-2.7-8.9', '', ''),
('OW09-2Tue', 2, '', '2பேது3:12-15a,17-18', 'திபா90:2.3-4.10.14,16', '', ''),
('OW09-3Wed', 1, '', 'தோபி3:1-11a,16-17a', 'திபா25:2-3.4-5ab.6,7bc.8-9', '', ''),
('OW09-3Wed', 2, '', '2திமொ1:1-3,6-12', 'திபா123:1b-2ab.2cdef', '', ''),
('OW09-4Thu', 1, '', 'தோபி6:10-11;7:1bcde,9-17;8:4-9a', 'திபா128:1-2.3.4-5', '', ''),
('OW09-4Thu', 2, '', '2திமொ2:8-15', 'திபா25:4-5ab.8-9.10,14', '', ''),
('OW09-5Fri', 1, '', 'தோபி11:5-17', 'திபா146:1b-2.6c-7.8-9a.9bc-10', '', ''),
('OW09-5Fri', 2, '', '2திமொ3:10-17', 'திபா119:157.160.161.165.166.168', '', ''),
('OW09-6Sat', 1, '', 'தோபி12:1,5-15,20', 'தோபி13:2.6.7.8', '', ''),
('OW09-6Sat', 2, '', '2திமொ4:1-8', 'திபா71:8-9.14-15ab.16-17.22', '', ''),
('OW10-1Mon', 1, '', '2கொரி1:1-7', 'திபா34:2-3.4-5.6-7.8-9', '', ''),
('OW10-1Mon', 2, '', '1அர17:1-6', 'திபா121:1bc-2.3-4.5-6.7-8', '', ''),
('OW10-2Tue', 1, '', '2கொரி1:18-22', 'திபா119:129.130.131.132.133.135', '', ''),
('OW10-2Tue', 2, '', '1அர17:7-16', 'திபா4:2-3.4-5.7b-8', '', ''),
('OW10-3Wed', 1, '', '2கொரி3:4-11', 'திபா99:5.6.7.8.9', '', ''),
('OW10-3Wed', 2, '', '1அர18:20-39', 'திபா16:1-2ab.4.5ab,8.11', '', ''),
('OW10-4Thu', 1, '', '2கொரி3:15-4:1,3-6', 'திபா85:9ab,10.11-12.13-14', '', ''),
('OW10-4Thu', 2, '', '1அர18:41-46', 'திபா65:10.11.12-13', '', ''),
('OW10-5Fri', 1, '', '2கொரி4:7-15', 'திபா116:10-11.15-16.17-18', '', ''),
('OW10-5Fri', 2, '', '1அர19:9a,11-16', 'திபா27:7-8a.8b-9abc.13-14', '', ''),
('OW10-6Sat', 1, '', '2கொரி5:14-21', 'திபா103:1-2.3-4.9-10.11-12', '', ''),
('OW10-6Sat', 2, '', '1அர19:19-21', 'திபா16:1b-2a,5.7-8.9-10', '', ''),
('OW11-1Mon', 1, '', '2கொரி6:1-10', 'திபா98:1.2b-3ab.3cd-4', '', ''),
('OW11-1Mon', 2, '', '1அர21:1-16', 'திபா5:2-3ab.4b-6a.6b-7', '', ''),
('OW11-2Tue', 1, '', '2கொரி8:1-9', 'திபா146:2.5-6ab.6c-7.8-9a', '', ''),
('OW11-2Tue', 2, '', '1அர21:17-29', 'திபா51:3-4.5-6ab.11,16', '', ''),
('OW11-3Wed', 1, '', '2கொரி9:6-11', 'திபா112:1bc-2.3-4.9', '', ''),
('OW11-3Wed', 2, '', '2அர2:1,6-14', 'திபா31:20.21.24', '', ''),
('OW11-4Thu', 1, '', '2கொரி11:1-11', 'திபா111:1b-2.3-4.7-8', '', ''),
('OW11-4Thu', 2, '', 'சீஞா48:1-14', 'திபா97:1-2.3-4.5-6.7', '', ''),
('OW11-5Fri', 1, '', '2கொரி11:18,21-30', 'திபா34:2-3.4-5.6-7', '', ''),
('OW11-5Fri', 2, '', '2அர11:1-4,9-18,20', 'திபா132:11.12.13-14.17-18', '', ''),
('OW11-6Sat', 1, '', '2கொரி12:1-10', 'திபா34:8-9.10-11.12-13', '', ''),
('OW11-6Sat', 2, '', '2குறி24:17-25', 'திபா89:4-5.29-30.31-32.33-34', '', ''),
('OW12-1Mon', 1, '', 'தொநூ12:1-9', 'திபா33:12-13.18-19.20,22', '', ''),
('OW12-1Mon', 2, '', '2அர17:5-8,13-15a,18', 'திபா60:3.4-5.12-13', '', ''),
('OW12-2Tue', 1, '', 'தொநூ13:2,5-18', 'திபா15:2-3a.3bc-4ab.5', '', ''),
('OW12-2Tue', 2, '', '2அர19:9b-11,14-21,31-35a,36', 'திபா48:2-3ab.3cd-4.10-11', '', ''),
('OW12-3Wed', 1, '', 'தொநூ15:1-12,17-18', 'திபா105:1-2.3-4.6-7.8-9', '', ''),
('OW12-3Wed', 2, '', '2அர22:8-13;23:1-3', 'திபா119:33.34.35.36.37.40', '', ''),
('OW12-4Thu', 1, '', 'தொநூ16:1-12,15-16அல்லது16:6b-12,15-16', 'திபா106:1b-2.3-4a.4b-5', '', ''),
('OW12-4Thu', 2, '', '2அர24:8-17', 'திபா79:1b-2.3-5.8.9', '', ''),
('OW12-5Fri', 1, '', 'தொநூ17:1,9-10,15-22', 'திபா128:1-2.3.4-5', '', ''),
('OW12-5Fri', 2, '', '2அர25:1-12', 'திபா137:1-2.3.4-5.6', '', ''),
('OW12-6Sat', 1, '', 'தொநூ18:1-15', 'லூக்1:46-47.48-49.50,53.54-55', '', ''),
('OW12-6Sat', 2, '', 'புல2:2,10-14,18-19', 'திபா74:1b-2.3-5.6-7.20-21', '', ''),
('OW13-1Mon', 1, '', 'தொநூ18:16-33', 'திபா103:1b-2.3-4.8-9.10-11', '', ''),
('OW13-1Mon', 2, '', 'ஆமோ2:6-10,13-16', 'திபா50:16bc-17.18-19.20-21.22-23', '', ''),
('OW13-2Tue', 1, '', 'தொநூ19:15-29', 'திபா26:2-3.9-10.11-12', '', ''),
('OW13-2Tue', 2, '', 'ஆமோ3:1-8;4:11-12', 'திபா5:4b-6a.6b-7.8', '', ''),
('OW13-3Wed', 1, '', 'தொநூ21:5,8-20a', 'திபா34:7-8.10-11.12-13', '', ''),
('OW13-3Wed', 2, '', 'ஆமோ5:14-15,21-24', 'திபா50:7.8-9.10-11.12-13.16bc-17', '', ''),
('OW13-4Thu', 1, '', 'தொநூ22:1b-19', 'திபா115:1-2.3-4.5-6.8-9', '', ''),
('OW13-4Thu', 2, '', 'ஆமோ7:10-17', 'திபா19:8.9.10.11', '', ''),
('OW13-5Fri', 1, '', 'தொநூ23:1-4,19;24:1-8,62-67', 'திபா106:1b-2.3-4a.4b-5', '', ''),
('OW13-5Fri', 2, '', 'ஆமோ8:4-6,9-12', 'திபா119:2.10.20.30.40.131', '', ''),
('OW13-6Sat', 1, '', 'தொநூ27:1-5,15-29', 'திபா135:1b-2.3-4.5-6', '', ''),
('OW13-6Sat', 2, '', 'ஆமோ9:11-15', 'திபா85:9ab,10.11-12.13-14', '', ''),
('OW14-1Mon', 1, '', 'தொநூ28:10-22a', 'திபா91:1-2.3-4.14-15ab', '', ''),
('OW14-1Mon', 2, '', 'ஓசே2:16,17c-18,21-22', 'திபா145:2-3.4-5.6-7.8-9', '', ''),
('OW14-2Tue', 1, '', 'தொநூ32:23-33', 'திபா17:1b.2-3.6-7ab.8b,15', '', ''),
('OW14-2Tue', 2, '', 'ஓசே8:4-7,11-13', 'திபா115:3-4.5-6.7ab,8.9-10', '', ''),
('OW14-3Wed', 1, '', 'தொநூ41:55-57;42:5-7a,17-24a', 'திபா33:2-3.10-11.18-19', '', ''),
('OW14-3Wed', 2, '', 'ஓசே10:1-3,7-8,12', 'திபா105:2-3.4-5.6-7', '', ''),
('OW14-4Thu', 1, '', 'தொநூ44:18-21,23b-29;45:1-5', 'திபா105:16-17.18-19.20-21', '', ''),
('OW14-4Thu', 2, '', 'ஓசே11:1-4,8e-9', 'திபா80:2ac,3b.15-16', '', ''),
('OW14-5Fri', 1, '', 'தொநூ46:1-7,28-30', 'திபா37:3-4.18-19.27-28.39-40', '', ''),
('OW14-5Fri', 2, '', 'ஓசே14:2-10', 'திபா51:3-4.8-9.12-13.14,17', '', ''),
('OW14-6Sat', 1, '', 'தொநூ49:29-32;50:15-26a', 'திபா105:1-2.3-4.6-7', '', ''),
('OW14-6Sat', 2, '', 'எசா6:1-8', 'திபா93:1ab.1cd-2.5', '', ''),
('OW15-1Mon', 1, '', 'விப1:8-14,22', 'திபா124:1b-3.4-6.7-8', '', ''),
('OW15-1Mon', 2, '', 'எசா1:10-17', 'திபா50:8-9.16bc-17.21,23', '', ''),
('OW15-2Tue', 1, '', 'விப2:1-15a', 'திபா69:3.14.30-31.33-34', '', ''),
('OW15-2Tue', 2, '', 'எசா7:1-9', 'திபா48:2-3a.3b-4.5-6.7-8', '', ''),
('OW15-3Wed', 1, '', 'விப3:1-6,9-12', 'திபா103:1b-2.3-4.6-7', '', ''),
('OW15-3Wed', 2, '', 'எசா10:5-7,13b-16', 'திபா94:5-6.7-8.9-10.14-15', '', ''),
('OW15-4Thu', 1, '', 'விப3:13-20', 'திபா105:1,5.8-9.24-25.26-27', '', ''),
('OW15-4Thu', 2, '', 'எசா26:7-9,12,16-19', 'திபா102:13-14ab,15.16-18.19-21', '', ''),
('OW15-5Fri', 1, '', 'விப11:10-12:14', 'திபா116:12-13.15,16bc.17-18', '', ''),
('OW15-5Fri', 2, '', 'எசா38:1-6,21-22,7-8', 'எசா38:10.11.12abcd.16', '', ''),
('OW15-6Sat', 1, '', 'விப12:37-42', 'திபா136:1,23-24.10-12.13-15', '', ''),
('OW15-6Sat', 2, '', 'மீக்2:1-5', 'திபா10:1-2.3-4.7-8.14', '', ''),
('OW16-1Mon', 1, '', 'விப14:5-18', 'விப15:1bc-2.3-4.5-6', '', ''),
('OW16-1Mon', 2, '', 'மீக்6:1-4,6-8', 'திபா50:5-6.8-9.16bc-17.21,23', '', ''),
('OW16-2Tue', 1, '', 'விப14:21-15:1', 'விப15:8-9.10,12.17', '', ''),
('OW16-2Tue', 2, '', 'மீக்7:14-15,18-20', 'திபா85:2-4.5-6.7-8', '', ''),
('OW16-3Wed', 1, '', 'விப16:1-5,9-15', 'திபா78:18-19.23-24.25-26.27-28', '', ''),
('OW16-3Wed', 2, '', 'எரே1:1,4-10', 'திபா71:1-2.3-4a.5-6ab.15,17', '', ''),
('OW16-4Thu', 1, '', 'விப19:1-2,9-11,16-20b', 'தானி3:52.53.54.55.56', '', ''),
('OW16-4Thu', 2, '', 'எரே2:1-3,7-8,12-13', 'திபா36:6-7ab.8-9.10-11', '', ''),
('OW16-5Fri', 1, '', 'விப20:1-17', 'திபா19:8.9.10.11', '', ''),
('OW16-5Fri', 2, '', 'எரே3:14-17', 'எரே31:10.11-12abcd.13', '', ''),
('OW16-6Sat', 1, '', 'விப24:3-8', 'திபா50:1b-2.5-6.14-15', '', ''),
('OW16-6Sat', 2, '', 'எரே7:1-11', 'திபா84:3.4.5-6a,8a.11', '', ''),
('OW17-1Mon', 1, '', 'விப32:15-24,30-34', 'திபா106:19-20.21-22.23', '', ''),
('OW17-1Mon', 2, '', 'எரே13:1-11', 'இச32:18-19.20.21', '', ''),
('OW17-2Tue', 1, '', 'விப33:7-11;34:5b-9,28', 'திபா103:6-7.8-9.10-11.12-13', '', ''),
('OW17-2Tue', 2, '', 'எரே14:17-22', 'திபா79:8.9.11,13', '', ''),
('OW17-3Wed', 1, '', 'விப34:29-35', 'திபா99:5.6.7.9', '', ''),
('OW17-3Wed', 2, '', 'எரே15:10,16-21', 'திபா59:2-3.4.10-11.17.18', '', ''),
('OW17-4Thu', 1, '', 'விப40:16-21,34-38', 'திபா84:3.4.5-6a,8a.11', '', ''),
('OW17-4Thu', 2, '', 'எரே18:1-6', 'திபா146:1b-2.3-4.5-6ab', '', ''),
('OW17-5Fri', 1, '', 'லேவி23:1,4-11,15-16,27,34b-37', 'திபா81:3-4.5-6ab.10-11ab', '', ''),
('OW17-5Fri', 2, '', 'எரே26:1-9', 'திபா69:5.8-10.14', '', ''),
('OW17-6Sat', 1, '', 'லேவி25:1,8-17', 'திபா67:2-3.5.7-8', '', ''),
('OW17-6Sat', 2, '', 'எரே26:11-16,24', 'திபா69:15-16.30-31.33-34', '', ''),
('OW18-1Mon', 1, '', 'எண்11:4b-15', 'திபா81:12-13.14-15.16-17', '', ''),
('OW18-1Mon', 2, '', 'எரே28:1-17', 'திபா119:29.43.79.80.95.102', '', ''),
('OW18-2Tue', 1, '', 'எண்12:1-13', 'திபா51:3-4.5-6ab.6cd-7.12-13', '', ''),
('OW18-2Tue', 2, '', 'எரே30:1-2,12-15,18-22', 'திபா102:16-18.19-21.29,22-23', '', ''),
('OW18-3Wed', 1, '', 'எண்13:1-2,25-14:1,26a-29a,34-35', 'திபா106:6-7ab.13-14.21-22.23', '', ''),
('OW18-3Wed', 2, '', 'எரே31:1-7', 'எரே31:10.11-12ab.13', '', ''),
('OW18-4Thu', 1, '', 'எண்20:1-13', 'திபா95:1-2.6-7.8-9', '', ''),
('OW18-4Thu', 2, '', 'எரே31:31-34', 'திபா51:12-13.14-15.18-19', '', ''),
('OW18-5Fri', 1, '', 'இச4:32-40', 'திபா77:12-13.14-15.16,21', '', ''),
('OW18-5Fri', 2, '', 'நாகூ2:1,3;3:1-3,6-7', 'இச32:35cd-36ab.39abcd.41', '', ''),
('OW18-6Sat', 1, '', 'இச6:4-13', 'திபா18:2-3a.3bc-4.47,51', '', ''),
('OW18-6Sat', 2, '', 'அப1:12-2:4', 'திபா9:8-9.10-11.12-13', '', ''),
('OW19-1Mon', 1, '', 'இச10:12-22', 'திபா147:12-13.14-15.19-20', 'எருசலேமே! கடவுளாம் ஆண்டவரைப் புகழ்வாயாக! ', '12'),
('OW19-1Mon', 2, '', 'எசே1:2-5,24-28c', 'திபா148:1-2.11-12.13.14', '', ''),
('OW19-2Tue', 1, '', 'இச31:1-8', 'இச32:3-4ab.7.8.9,12', '', ''),
('OW19-2Tue', 2, '', 'எசே2:8-3:4', 'திபா119:14.24.72.103.111.131', '', ''),
('OW19-3Wed', 1, '', 'இச34:1-12', 'திபா66:1-3a.5,8.16-17', '', ''),
('OW19-3Wed', 2, '', 'எசே9:1-7;10:18-22', 'திபா113:1-2.3-4.5-6', '', ''),
('OW19-4Thu', 1, '', 'யோசு3:7-10a,11,13-17', 'திபா114:1-2.3-4.5-6', '', ''),
('OW19-4Thu', 2, '', 'எசே12:1-12', 'திபா78:56-57.58-59.61-62', '', ''),
('OW19-5Fri', 1, '', 'யோசு24:1-13', 'திபா136:1-3.16-18.21-22,24', '', ''),
('OW19-5Fri', 2, '', 'எசே16:1-15,60,63(அ)16:59-63', 'எசா12:2-3.4bcd.5-6', '', ''),
('OW19-6Sat', 1, '', 'யோசு24:14-29', 'திபா16:1-2a,5.7-8.11', '', ''),
('OW19-6Sat', 2, '', 'எசே18:1-10,13b,30-32', 'திபா51:12-13.14-15.18-19', '', ''),
('OW20-1Mon', 1, '', 'நீத2:11-19', 'திபா106:34-35.36-37.39-40.43ab,44', '', ''),
('OW20-1Mon', 2, '', 'எசே24:15-23', 'இச32:18-19.20.21', '', ''),
('OW20-2Tue', 1, '', 'நீத6:11-24a', 'திபா85:9.11-12.13-14', '', ''),
('OW20-2Tue', 2, '', 'எசே28:1-10', 'இச32:26-27ab.27cd-28.30.35cd-36ab', '', ''),
('OW20-3Wed', 1, '', 'நீத9:6-15', 'திபா21:2-3.4-5.6-7', '', ''),
('OW20-3Wed', 2, '', 'எசே34:1-11', 'திபா23:1-3a.3b-4.5.6', '', ''),
('OW20-4Thu', 1, '', 'நீத11:29-39a', 'திபா40:5.7-8a.8b-9.10', '', ''),
('OW20-4Thu', 2, '', 'எசே36:23-28', 'திபா51:12-13.14-15.18-19', '', ''),
('OW20-5Fri', 1, '', 'ரூத்1:1,3-6,14b-16,22', 'திபா146:5-6ab.6c-7.8-9a.9bc-10', '', ''),
('OW20-5Fri', 2, '', 'எசே37:1-14', 'திபா107:2-3.4-5.6-7.8-9', '', ''),
('OW20-6Sat', 1, '', 'ரூத்2:1-3,8-11;4:13-17', 'திபா128:1b-2.3.4.5', '', ''),
('OW20-6Sat', 2, '', 'எசே43:1-7ab', 'திபா85:9ab,10.11-12.13-14', '', ''),
('OW21-1Mon', 1, '', '1தெச1:1-5,8b-10', 'திபா149:1b-2.3-4.5-6a,9b', '', ''),
('OW21-1Mon', 2, '', '2தெச1:1-5,11-12', 'திபா96:1-2a.2b-3.4-5', '', ''),
('OW21-2Tue', 1, '', '1தெச2:1-8', 'திபா139:1-3.4-6', '', ''),
('OW21-2Tue', 2, '', '2தெச2:1-3a,14-17', 'திபா96:10.11-12.13', '', ''),
('OW21-3Wed', 1, '', '1தெச2:9-13', 'திபா139:7-8.9-10.11-12ab', '', ''),
('OW21-3Wed', 2, '', '2தெச3:6-10,16-18', 'திபா128:1-2.4-5', '', ''),
('OW21-4Thu', 1, '', '1தெச3:7-13', 'திபா90:3-4.12-13.14,17', '', ''),
('OW21-4Thu', 2, '', '1கொரி1:1-9', 'திபா145:2-3.4-5.6-7', '', ''),
('OW21-5Fri', 1, '', '1தெச4:1-8', 'திபா97:1,2b.5-6.10.11-12', '', ''),
('OW21-5Fri', 2, '', '1கொரி1:17-25', 'திபா33:1-2.4-5.10-11', '', ''),
('OW21-6Sat', 1, '', '1தெச4:9-11', 'திபா98:1.7-8.9', '', ''),
('OW21-6Sat', 2, '', '1கொரி1:26-31', 'திபா33:12-13.18-19.20-21', '', ''),
('OW22-1Mon', 1, '', '1தெச4:13-18', 'திபா96:1,3.4-5.11-12.13', '', ''),
('OW22-1Mon', 2, '', '1கொரி2:1-5', 'திபா119:97.98.99.100.101.102', '', ''),
('OW22-2Tue', 1, '', '1தெச5:1-6,9-11', 'திபா27:1.4.13-14', '', ''),
('OW22-2Tue', 2, '', '1கொரி2:10b-16', 'திபா145:8-9.10-11.12-13ab.13cd-14', '', ''),
('OW22-3Wed', 1, '', 'கொலோ1:1-8', 'திபா52:10.11', '', ''),
('OW22-3Wed', 2, '', '1கொரி3:1-9', 'திபா33:12-13.14-15.20-21', '', ''),
('OW22-4Thu', 1, '', 'கொலோ1:9-14', 'திபா98:2-3ab.3cd-4.5-6', '', ''),
('OW22-4Thu', 2, '', '1கொரி3:18-23', 'திபா24:1bc-2.3-4ab.5-6', '', ''),
('OW22-5Fri', 1, '', 'கொலோ1:15-20', 'திபா100:1b-2.3.4.5', '', ''),
('OW22-5Fri', 2, '', '1கொரி4:1-5', 'திபா37:3-4.5-6.27-28.39-40', '', ''),
('OW22-6Sat', 1, '', 'கொலோ1:21-23', 'திபா54:3-4.6,8', '', ''),
('OW22-6Sat', 2, '', '1கொரி4:6b-15', 'திபா145:17-18.19-20.21', '', ''),
('OW23-1Mon', 1, '', 'கொலோ1:24-2:3', 'திபா62:6-7.9', '', ''),
('OW23-1Mon', 2, '', '1கொரி5:1-8', 'திபா5:5-6.7.12', '', ''),
('OW23-2Tue', 1, '', 'கொலோ2:6-15', 'திபா145:1b-2.8-9.10-11', '', ''),
('OW23-2Tue', 2, '', '1கொரி6:1-11', 'திபா149:1b-2.3-4.5-6a,9b', '', ''),
('OW23-3Wed', 1, '', 'கொலோ3:1-11', 'திபா145:2-3.10-11.12-13ab', '', ''),
('OW23-3Wed', 2, '', '1கொரி7:25-31', 'திபா45:11-12.14-15.16-17', '', ''),
('OW23-4Thu', 1, '', 'கொலோ3:12-17', 'திபா150:1b-2.3-4.5-6', '', ''),
('OW23-4Thu', 2, '', '1கொரி8:1b-7,11-13', 'திபா139:1b-3.13-14ab.23-24', '', ''),
('OW23-5Fri', 1, '', '1திமொ1:1-2,12-14', 'திபா16:1b-2a,5.7-8.11', '', ''),
('OW23-5Fri', 2, '', '1கொரி9:16-19,22b-27', 'திபா84:3.4.5-6.12', '', ''),
('OW23-6Sat', 1, '', '1திமொ1:15-17', 'திபா113:1b-2.3-4.5a,6-7', '', ''),
('OW23-6Sat', 2, '', '1கொரி10:14-22', 'திபா116:12-13.17-18', '', ''),
('OW24-1Mon', 1, '', '1திமொ2:1-8', 'திபா28:2.7.8-9', '', ''),
('OW24-1Mon', 2, '', '1கொரி11:17-26,33', 'திபா40:7-8a.8b-9.10.17', '', ''),
('OW24-2Tue', 1, '', '1திமொ3:1-13', 'திபா101:1b-2ab.2cd-3ab.5.6', '', ''),
('OW24-2Tue', 2, '', '1கொரி12:12-14,27-31a', 'திபா100:1b-2.3.4.5', '', ''),
('OW24-3Wed', 1, '', '1திமொ3:14-16', 'திபா111:1-2.3-4.5-6', '', ''),
('OW24-3Wed', 2, '', '1கொரி12:31-13:13', 'திபா33:2-3.4-5.12,22', '', ''),
('OW24-4Thu', 1, '', '1திமொ4:12-16', 'திபா111:7-8.9.10', '', ''),
('OW24-4Thu', 2, '', '1கொரி15:1-11', 'திபா118:1b-2.16ab,17.28', '', ''),
('OW24-5Fri', 1, '', '1திமொ6:2c-12', 'திபா49:6-7.8-10.17-18.19-20', '', ''),
('OW24-5Fri', 2, '', '1கொரி15:12-20', 'திபா17:1bcd.6-7.8b,15', '', ''),
('OW24-6Sat', 1, '', '1திமொ6:13-16', 'திபா100:1b-2.3.4.5', '', ''),
('OW24-6Sat', 2, '', '1கொரி15:35-37,42-49', 'திபா56:10c-12.13-14', '', ''),
('OW25-1Mon', 1, '', 'எஸ்ரா1:1-6', 'திபா126:1b-2ab.2cd-3.4-5.6', '', ''),
('OW25-1Mon', 2, '', 'நீமொ3:27-34', 'திபா15:2-3a.3bc-4ab.5', '', ''),
('OW25-2Tue', 1, '', 'எஸ்ரா6:7-8,12b,14-20', 'திபா122:1-2.3-4ab.4cd-5', '', ''),
('OW25-2Tue', 2, '', 'நீமொ21:1-6,10-13', 'திபா119:1,27.30,34.35,44', '', ''),
('OW25-3Wed', 1, '', 'எஸ்ரா9:5-9', 'தோபி13:2,3.6,7.8', '', ''),
('OW25-3Wed', 2, '', 'நீமொ30:5-9', 'திபா119:29.72.89.101.104.163', '', ''),
('OW25-4Thu', 1, '', 'ஆகா1:1-8', 'திபா149:1b-2.3-4.5-6a,9b', '', ''),
('OW25-4Thu', 2, '', 'சஉ1:2-11', 'திபா90:3-4.5-6.12-13.14,17bc', '', ''),
('OW25-5Fri', 1, '', 'ஆகா2:1-9', 'திபா43:1.2.3.4', '', ''),
('OW25-5Fri', 2, '', 'சஉ3:1-11', 'திபா144:1b,2abc.3-4', '', ''),
('OW25-6Sat', 1, '', 'செக்2:5-9,14-15a', 'எரே31:10.11-12ab.13', '', ''),
('OW25-6Sat', 2, '', 'சஉ11:9-12:8', 'திபா90:3-4.5-6.12-13.14,17', '', ''),
('OW26-1Mon', 1, '', 'செக்8:1-8', 'திபா102:16-18.19-21.29,22-23', '', ''),
('OW26-1Mon', 2, '', 'யோபு1:6-22', 'திபா17:1bcd.2-3.6-7', '', ''),
('OW26-2Tue', 1, '', 'செக்8:20-23', 'திபா87:1b-3.4-5.6-7', '', ''),
('OW26-2Tue', 2, '', 'யோபு3:1-3,11-17,20-23', 'திபா88:2-3.4-5.6.7-8', '', ''),
('OW26-3Wed', 1, '', 'நெகே2:1-8', 'திபா137:1-2.3.4-5.6', '', ''),
('OW26-3Wed', 2, '', 'யோபு9:1-12,14-16', 'திபா88:10bc-11.12-13.14-15', '', ''),
('OW26-4Thu', 1, '', 'நெகே8:1-4a,5-6,7b-12', 'திபா19:8.9.10.11', '', ''),
('OW26-4Thu', 2, '', 'யோபு19:21-27', 'திபா27:7-8a.8b-9abc.13-14', '', ''),
('OW26-5Fri', 1, '', 'பாரூ1:15-22', 'திபா79:1b-2.3-5.8.9', '', ''),
('OW26-5Fri', 2, '', 'யோபு38:1,12-21;40:3-5', 'திபா139:1-3.7-8.9-10.13-14ab', '', ''),
('OW26-6Sat', 1, '', 'பாரூ4:5-12,27-29', 'திபா69:33-35.36-37', '', ''),
('OW26-6Sat', 2, '', 'யோபு42:1-3,5-6,12-17', 'திபா119:66.71.75.91.125.130', '', ''),
('OW27-1Mon', 1, '', 'யோனா1:1-2:2,11', 'யோனா2:3.4.5.8', '', ''),
('OW27-1Mon', 2, '', 'கலா1:6-12', 'திபா111:1b-2.7-8.9,10c', '', ''),
('OW27-2Tue', 1, '', 'யோனா3:1-10', 'திபா130:1b-2.3-4ab.7-8', '', ''),
('OW27-2Tue', 2, '', 'கலா1:13-24', 'திபா139:1b-3.13-14ab.14c-15', '', ''),
('OW27-3Wed', 1, '', 'யோனா4:1-11', 'திபா86:3-4.5-6.9-10', '', ''),
('OW27-3Wed', 2, '', 'கலா2:1-2,7-14', 'திபா117:1bc.2', '', ''),
('OW27-4Thu', 1, '', 'மலா3:13-20b', 'திபா1:1-2.3.4,6', '', ''),
('OW27-4Thu', 2, '', 'கலா3:1-5', 'லூக்1:69-70.71-72.73-75', '', ''),
('OW27-5Fri', 1, '', 'யோவே1:13-15;2:1-2', 'திபா9:2-3.6,16.8-9', '', ''),
('OW27-5Fri', 2, '', 'கலா3:7-14', 'திபா111:1b-2.3-4.5-6', '', ''),
('OW27-6Sat', 1, '', 'யோவே4:12-21', 'திபா97:1-2.5-6.11-12', '', ''),
('OW27-6Sat', 2, '', 'கலா3:22-29', 'திபா105:2-3.4-5.6-7', '', ''),
('OW28-1Mon', 1, '', 'உரோ1:1-7', 'திபா98:1bcde.2-3ab.3cd-4', '', ''),
('OW28-1Mon', 2, '', 'கலா4:22-24,26-27,31-5:1', 'திபா113:1b-2.3-4.5a,6-7', '', ''),
('OW28-2Tue', 1, '', 'உரோ1:16-25', 'திபா19:2-3.4-5', '', ''),
('OW28-2Tue', 2, '', 'கலா5:1-6', 'திபா119:41.43.44.45.47.48', '', ''),
('OW28-3Wed', 1, '', 'உரோ2:1-11', 'திபா62:2-3.6-7.9', '', ''),
('OW28-3Wed', 2, '', 'கலா5:18-25', 'திபா1:1-2.3.4,6', '', ''),
('OW28-4Thu', 1, '', 'உரோ3:21-30', 'திபா130:1b-2.3-4.5-6ab', '', ''),
('OW28-4Thu', 2, '', 'எபே1:1-10', 'திபா98:1.2-3ab.3cd-4.5-6', '', ''),
('OW28-5Fri', 1, '', 'உரோ4:1-8', 'திபா32:1b-2.5.11', '', ''),
('OW28-5Fri', 2, '', 'எபே1:11-14', 'திபா33:1-2.4-5.12-13', '', ''),
('OW28-6Sat', 1, '', 'உரோ4:13,16-18', 'திபா105:6-7.8-9.42-43', '', ''),
('OW28-6Sat', 2, '', 'எபே1:15-23', 'திபா8:2-3ab.4-5.6-7', '', ''),
('OW29-1Mon', 1, '', 'உரோ4:20-25', 'லூக்1:69-70.71-72.73-75', '', ''),
('OW29-1Mon', 2, '', 'எபே2:1-10', 'திபா100:1b-2.3.4ab.4c-5', '', ''),
('OW29-2Tue', 1, '', 'உரோ5:12,15b,17-19,20b-21', 'திபா40:7-8a.8b-9.10.17', '', ''),
('OW29-2Tue', 2, '', 'எபே2:12-22', 'திபா85:9ab,10.11-12.13-14', '', ''),
('OW29-3Wed', 1, '', 'உரோ6:12-18', 'திபா124:1b-3.4-6.7-8', '', ''),
('OW29-3Wed', 2, '', 'எபே3:2-12', 'எசா12:2-3.4bcd.5-6', '', ''),
('OW29-4Thu', 1, '', 'உரோ6:19-23', 'திபா1:1-2.3.4,6', '', ''),
('OW29-4Thu', 2, '', 'எபே3:14-21', 'திபா33:1-2.4-5.11-12.18-19', '', ''),
('OW29-5Fri', 1, '', 'உரோ7:18-25a', 'திபா119:66.68.76.77.93.94', '', ''),
('OW29-5Fri', 2, '', 'எபே4:1-6', 'திபா24:1-2.3-4ab.5-6', '', ''),
('OW29-6Sat', 1, '', 'உரோ8:1-11', 'திபா24:1b-2.3-4ab.5-6', '', ''),
('OW29-6Sat', 2, '', 'எபே4:7-16', 'திபா122:1-2.3-4ab.4cd-5', '', ''),
('OW30-1Mon', 1, '', 'உரோ8:12-17', 'திபா68:2,4.6-7ab.20-21', '', ''),
('OW30-1Mon', 2, '', 'எபே4:32-5:8', 'திபா1:1-2.3.4,6', '', ''),
('OW30-2Tue', 1, '', 'உரோ8:18-25', 'திபா126:1b-2ab.2cd-3.4-5.6', '', ''),
('OW30-2Tue', 2, '', 'எபே5:21-33', 'திபா128:1-2.3.4-5', '', ''),
('OW30-3Wed', 1, '', 'உரோ8:26-30', 'திபா13:4-5.6', '', ''),
('OW30-3Wed', 2, '', 'எபே6:1-9', 'திபா145:10-11.12-13ab.13cd-14', '', ''),
('OW30-4Thu', 1, '', 'உரோ8:31b-39', 'திபா109:21-22.26-27.30-31', '', ''),
('OW30-4Thu', 2, '', 'எபே6:10-20', 'திபா144:1b.2.9-10', '', ''),
('OW30-5Fri', 1, '', 'உரோ9:1-5', 'திபா147:12-13.14-15.19-20', '', ''),
('OW30-5Fri', 2, '', 'பிலி1:1-11', 'திபா111:1-2.3-4.5-6', '', ''),
('OW30-6Sat', 1, '', 'உரோ11:1-2a,11-12,25-29', 'திபா94:12-13a.14-15.17-18', '', ''),
('OW30-6Sat', 2, '', 'பிலி1:18b-26', 'திபா42:2.3.5cdef', '', ''),
('OW31-1Mon', 1, '', 'உரோ11:29-36', 'திபா69:30-31.33-34.36-37', '', ''),
('OW31-1Mon', 2, '', 'பிலி2:1-4', 'திபா131:1bcde.2.3', '', ''),
('OW31-2Tue', 1, '', 'உரோ12:5-16ab', 'திபா131:1bcde.2.3', '', ''),
('OW31-2Tue', 2, '', 'பிலி2:5-11', 'திபா22:26b-27.28-30ab.30e.31-32', '', ''),
('OW31-3Wed', 1, '', 'உரோ13:8-10', 'திபா112:1b-2.4-5.9', '', ''),
('OW31-3Wed', 2, '', 'பிலி2:12-18', 'திபா27:1.4.13-14', '', ''),
('OW31-4Thu', 1, '', 'உரோ14:7-12', 'திபா27:1bcde.4.13-14', '', ''),
('OW31-4Thu', 2, '', 'பிலி3:3-8a', 'திபா105:2-3.4-5.6-7', '', ''),
('OW31-5Fri', 1, '', 'உரோ15:14-21', 'திபா98:1.2-3ab.3cd-4', '', ''),
('OW31-5Fri', 2, '', 'பிலி3:17-4:1', 'திபா122:1-2.3-4ab.4cd-5', '', ''),
('OW31-6Sat', 1, '', 'உரோ16:3-9,16,22-27', 'திபா145:2-3.4-5.10-11', '', ''),
('OW31-6Sat', 2, '', 'பிலி4:10-19', 'திபா112:1b-2.5-6.8a,9', '', ''),
('OW32-1Mon', 1, '', 'சாஞா1:1-7', 'திபா139:1b-3.4-6.7-8.9-10', '', ''),
('OW32-1Mon', 2, '', 'தீத்1:1-9', 'திபா24:1b-2.3-4ab.5-6', '', ''),
('OW32-2Tue', 1, '', 'சாஞா2:23-3:9', 'திபா34:2-3.16-17.18-19', '', ''),
('OW32-2Tue', 2, '', 'தீத்2:1-8,11-14', 'திபா37:3-4.18,23.27,29', '', ''),
('OW32-3Wed', 1, '', 'சாஞா6:1-11', 'திபா82:3-4.6-7', '', ''),
('OW32-3Wed', 2, '', 'தீத்3:1-7', 'திபா23:1b-3a.3bc-4.5.6', '', ''),
('OW32-4Thu', 1, '', 'சாஞா7:22b-8:1', 'திபா119:89.90.91.130.135.175', '', ''),
('OW32-4Thu', 2, '', 'பில7-20', 'திபா146:7.8-9a.9bc-10', '', ''),
('OW32-5Fri', 1, '', 'சாஞா13:1-9', 'திபா19:2-3.4-5ab', '', ''),
('OW32-5Fri', 2, '', '2யோவா4-9', 'திபா119:1.2.10.11.17.18', '', ''),
('OW32-6Sat', 1, '', 'சாஞா18:14-16;19:6-9', 'திபா105:2-3.36-37.42-43', '', ''),
('OW32-6Sat', 2, '', '3யோவா5-8', 'திபா112:1-2.3-4.5-6', '', ''),
('OW33-1Mon', 1, '', '1மக்1:10-15,41-43,54-57,62-63', 'திபா119:53.61.134.150.155.158', '', ''),
('OW33-1Mon', 2, '', 'திவெ1:1-4;2:1-5', 'திபா1:1-2.3.4,6', '', ''),
('OW33-2Tue', 1, '', '2மக்6:18-31', 'திபா3:2-3.4-5.6-7', '', ''),
('OW33-2Tue', 2, '', 'திவெ3:1-6,14-22', 'திபா15:2-3a.3bc-4ab.5', '', ''),
('OW33-3Wed', 1, '', '2மக்7:1,20-31', 'திபா17:1bcd.5-6.8b,15', '', ''),
('OW33-3Wed', 2, '', 'திவெ4:1-11', 'திபா150:1b-2.3-4.5-6', '', ''),
('OW33-4Thu', 1, '', '1மக்2:15-29', 'திபா50:1b-2.5-6.14-15', '', ''),
('OW33-4Thu', 2, '', 'திவெ5:1-10', 'திபா149:1b-2.3-4.5-6a,9b', '', ''),
('OW33-5Fri', 1, '', '1மக்4:36-37,52-59', '1குறி29:10b.11ab.11cd-12a.12bcd', '', ''),
('OW33-5Fri', 2, '', 'திவெ10:8-11', 'திபா119:14.24.72.103.111.131', '', ''),
('OW33-6Sat', 1, '', '1மக்6:1-13', 'திபா9:2-3.4,6.16,19', '', ''),
('OW33-6Sat', 2, '', 'திவெ11:4-12', 'திபா144:1.2.9-10', '', ''),
('OW34-1Mon', 1, '', 'தானி1:1-6,8-20', 'தானி3:52.53.54.55.56', '', ''),
('OW34-1Mon', 2, '', 'திவெ14:1-3,4b-5', 'திபா24:1bc-2.3-4ab.5-6', '', ''),
('OW34-2Tue', 1, '', 'தானி2:31-45', 'தானி3:57.58.59.60.61', '', ''),
('OW34-2Tue', 2, '', 'திவெ14:14-19', 'திபா96:10.11-12.13', '', ''),
('OW34-3Wed', 1, '', 'தானி5:1-6,13-14,16-17,23-28', 'தானி3:62.63.64.65.66.67', '', ''),
('OW34-3Wed', 2, '', 'திவெ15:1-4', 'திபா98:1.2-3ab.7-8.9', '', ''),
('OW34-4Thu', 1, '', 'தானி6:12-28', 'தானி3:68.69.70.71.72.73.74', '', ''),
('OW34-4Thu', 2, '', 'திவெ18:1-2,21-23;19:1-3,9a', 'திபா100:1b-2.3.4.5', '', ''),
('OW34-5Fri', 1, '', 'தானி7:2-14', 'தானி3:75.76.77.78.79.80.81', '', ''),
('OW34-5Fri', 2, '', 'திவெ20:1-4,11-21:2', 'திபா84:3.4.5-6a,8a', '', ''),
('OW34-6Sat', 1, '', 'தானி7:15-27', 'தானி3:82.83.84.85.86.87', '', ''),
('OW34-6Sat', 2, '', 'திவெ22:1-7', 'திபா95:1-2.3-5.6-7ab', '', '');
