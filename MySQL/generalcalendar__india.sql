
-- --------------------------------------------------------

--
-- Table structure for table `generalcalendar__india`
--

CREATE TABLE `generalcalendar__india` (
  `Common` text COLLATE utf8_unicode_ci NOT NULL,
  `Mnth` tinyint(2) NOT NULL,
  `Dt` tinyint(2) NOT NULL,
  `dayID` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `DayTitle` text COLLATE utf8_unicode_ci NOT NULL,
  `FeastType` enum('Solemnity','LordFeast','Feast','Mem','OpMem') COLLATE utf8_unicode_ci NOT NULL,
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

INSERT INTO `generalcalendar__india` (`Common`, `Mnth`, `Dt`, `dayID`, `DayTitle`, `FeastType`, `reading1`, `psalms`, `response`, `responseVs`, `reading2`, `alleluia`, `gospel`) VALUES
('	\r\nகன்னியர்', 6, 8, 'Bl. Mariya Theresa Chiramel, Virgin', 'முத்தி. மரிய தெரேசா சிராமெல் - கன்னியர்', 'OpMem', 'தொநூ12:1-4a', 'திபா45:10-11.13-14.15-16', '', '10,11 காண்க', 'கலா2:19-21', 'யோவா12:26', 'யோவா12:20-26'),
('கன்னியர்', 9, 5, 'Bl. Mother Theresa, Virgin', 'முத். அன்னை தெரேசா - கன்னியர்', 'OpMem', 'இபா8:6-7', 'திபா148:1-2.11-13ab.13c-14', 'இளைஞரே, கன்னியரே, ஆண்டவரின் பெயரைப் போற்றுங்கள்.', '12a,13a காண்க', '1கொரி13:1-13', 'மத்5:16', 'மத்5:1-16 அல்லது மத்25:31-46'),
('மேய்ப்பர் (மறைபரப்புப் பணியாளர்)', 12, 3, 'Francis Xavier, Priest', 'புனித பிரான்சிஸ் சவேரியார் - மறைப்பணியாளர், இந்தியாவின் பாதுகாவலர்', 'Solemnity', 'எசா61:1-3', 'திபா117:1.2', '', '', '1கொரி9:16-19,22-23', 'மத்28:19a,20b', 'மாற்16:15-20'),
('கன்னியர்', 7, 28, 'St. Alphonsa Muttathupadathu', 'புனித அல்போன்சா முட்டாத்துபாடாத் - கன்னியர்', 'OpMem', 'இணை28:8-12', 'திபா45:10-11.13-14.15-16', '', 'மத்15:6', 'கலா2:19-21', 'யோவா12:26', 'யோவா12:20-26'),
('மேய்ப்பர்', 2, 6, 'St. Gonsalo Garcia, martyr', 'புனித கொன்சாலோ கார்சியா - மறைச்சாட்சி', 'Feast', 'சீரா51:1-8', 'திபா126:1-2ab.2cd-3.4-5.6', '', '5', '2கொரி6:4-10', 'மத்28:19a,20b', 'மத்28:16-20'),
('மேய்ப்பர்', 2, 4, 'St. John De Britto, martyr', 'புனித ஜான் தெ பிரிட்டோ (அருளானந்தர்) - மறைப்பணியாளர், மறைச்சாட்சி', 'Feast', 'எபி13:15-17,20-21', 'திபா23:1-3.4.5.6', '', '1', '', 'யாக்1:12காண்க', 'யோவா12:24-26'),
('மேய்ப்பர்', 1, 16, 'St. Joseph Vas', 'புனித ஜோசப் வாஸ் - மறைப்பணியாளர்', 'OpMem', 'எரே1:1,4-10', 'திபா96:1-2a.2b-3.7-8a.10', '', '3', '1கொரி9:19-23', 'மத்23:11,12ab', 'லூக்10:1-9'),
('மேய்ப்பர்', 1, 3, 'St. Kuriakose Elias Chavara', 'புனித குரியாக்கோஸ் எலியாஸ் சவரா - மறைப்பணியாளர்', 'OpMem', 'தொநூ12:1-4aஅ அல்லது எசா44:1-4', 'திபா63:1.2-3.4-5.7-8', '', '1a', '1பேது4:12-19', 'AW01-2Tue', 'லூக்10:21-24'),
('PROPER', 7, 3, 'Thomas, Apostle of India', 'புனித தோமா - இந்தியாவின் திருத்தூதர்', 'Solemnity', 'எசா52:7-10', 'திபா117:1.2', '', '', 'எபே:19-22', 'யோவா20:29', 'யோவா20:24-29');
