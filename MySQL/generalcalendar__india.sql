
-- --------------------------------------------------------

--
-- Table structure for table `generalcalendar__india`
--

CREATE TABLE `generalcalendar__india` (
  `mnth` tinyint(2) NOT NULL,
  `dt` tinyint(2) NOT NULL,
  `dayID` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `dayTitle` text COLLATE utf8_unicode_ci NOT NULL,
  `feastType` enum('Solemnity','LordFeast','Feast','Mem','OpMem') COLLATE utf8_unicode_ci NOT NULL,
  `common` text COLLATE utf8_unicode_ci NOT NULL,
  `reading1` text COLLATE utf8_unicode_ci NOT NULL,
  `psalms` text COLLATE utf8_unicode_ci NOT NULL,
  `response` text COLLATE utf8_unicode_ci NOT NULL,
  `responseVs` text COLLATE utf8_unicode_ci NOT NULL,
  `reading2` text COLLATE utf8_unicode_ci NOT NULL,
  `alleluia` text COLLATE utf8_unicode_ci NOT NULL,
  `gospel` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `generalcalendar__india`
--

INSERT INTO `generalcalendar__india` (`mnth`, `dt`, `dayID`, `dayTitle`, `feastType`, `common`, `reading1`, `psalms`, `response`, `responseVs`, `reading2`, `alleluia`, `gospel`) VALUES
(7, 28, 'Alphonsa Muttathupadathu', 'புனித அல்போன்சா முட்டாத்துபாடாத் - கன்னியர்', 'OpMem', 'கன்னியர்', 'இணை28:8-12', 'திபா45:10-11.13-14.15-16', '', 'மத்15:6', 'கலா2:19-21', 'யோவா12:26', 'யோவா12:20-26'),
(12, 3, 'Francis Xavier', 'புனித பிரான்சிஸ் சவேரியார் - மறைப்பணியாளர், இந்தியாவின் பாதுகாவலர்', 'Solemnity', 'மேய்ப்பர் (மறைபரப்புப் பணியாளர்)', 'எசா61:1-3', 'திபா117:1.2', '', '', '1கொரி9:16-19,22-23', 'மத்28:19a,20b', 'மாற்16:15-20'),
(2, 6, 'Gonsalo Garcia', 'புனித கொன்சாலோ கார்சியா - மறைச்சாட்சி', 'Feast', 'மேய்ப்பர்', 'சீரா51:1-8', 'திபா126:1-2ab.2cd-3.4-5.6', '', '5', '2கொரி6:4-10', 'மத்28:19a,20b', 'மத்28:16-20'),
(2, 4, 'John De Britto', 'புனித ஜான் தெ பிரிட்டோ (அருளானந்தர்) - மறைப்பணியாளர், மறைச்சாட்சி', 'Feast', 'மேய்ப்பர்', 'எபி13:15-17,20-21', 'திபா23:1-3.4.5.6', '', '1', '', 'யாக்1:12காண்க', 'யோவா12:24-26'),
(1, 16, 'Joseph Vas', 'புனித ஜோசப் வாஸ் - மறைப்பணியாளர்', 'OpMem', 'மேய்ப்பர்', 'எரே1:1,4-10', 'திபா96:1-2a.2b-3.7-8a.10', '', '3', '1கொரி9:19-23', 'மத்23:11,12ab', 'லூக்10:1-9'),
(1, 3, 'Kuriakose Elias Chavara', 'புனித குரியாக்கோஸ் எலியாஸ் சவரா - மறைப்பணியாளர்', 'OpMem', 'மேய்ப்பர்', 'தொநூ12:1-4aஅ அல்லது எசா44:1-4', 'திபா63:1.2-3.4-5.7-8', '', '1a', '1பேது4:12-19', 'AW01-2Tue', 'லூக்10:21-24'),
(6, 8, 'Mariya Theresa Chiramel', 'முத்தி. மரிய தெரேசா சிராமெல் - கன்னியர்', 'OpMem', '	\r\nகன்னியர்', 'தொநூ12:1-4a', 'திபா45:10-11.13-14.15-16', '', '10,11 காண்க', 'கலா2:19-21', 'யோவா12:26', 'யோவா12:20-26'),
(9, 5, 'Mother Theresa', 'முத். அன்னை தெரேசா - கன்னியர்', 'OpMem', 'கன்னியர்', 'இபா8:6-7', 'திபா148:1-2.11-13ab.13c-14', 'இளைஞரே, கன்னியரே, ஆண்டவரின் பெயரைப் போற்றுங்கள்.', '12a,13a காண்க', '1கொரி13:1-13', 'மத்5:16', 'மத்5:1-16 அல்லது மத்25:31-46'),
(7, 3, 'Thomas, Apostle', 'புனித தோமா - இந்தியாவின் திருத்தூதர்', 'Solemnity', 'PROPER', 'எசா52:7-10', 'திபா117:1.2', '', '', 'எபே:19-22', 'யோவா20:29', 'யோவா20:24-29');
