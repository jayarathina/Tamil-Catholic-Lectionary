
-- --------------------------------------------------------

--
-- Table structure for table `generalcalendar__india`
--

CREATE TABLE `generalcalendar__india` (
  `feast_month` tinyint(2) NOT NULL,
  `feast_date` tinyint(2) NOT NULL,
  `feast_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `feast_ta` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `feast_type` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `common` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `generalcalendar__india`
--

INSERT INTO `generalcalendar__india` (`feast_month`, `feast_date`, `feast_code`, `feast_ta`, `feast_type`, `common`) VALUES
(1, 3, 'IN Saint Kuriakose Elias Chavara, priest', 'புனித குரியாக்கோஸ் எலியாஸ் சவரா - மறைப்பணியாளர்', 'OpMem', 'மேய்ப்பர்'),
(1, 14, 'IN Blessed Devasahayam Pillai, martyr', 'முத்தி. தேவசகாயம் பிள்ளை, மறைச்சாட்சி', 'OpMem', 'மறைச்சாட்சியர்'),
(1, 16, 'IN Saint Joseph Vaz, priest', 'புனித ஜோசப் வாஸ் - மறைப்பணியாளர்', 'Mem', 'மேய்ப்பர்'),
(2, 4, 'IN Saint John de Brito, priest and martyr', 'புனித ஜான் தெ பிரிட்டோ (அருளானந்தர்) - மறைப்பணியாளர், மறைச்சாட்சி', 'Mem', 'மேய்ப்பர்'),
(2, 6, 'IN Saint Gonsalo Garcia, martyr', 'புனித கொன்சாலோ கார்சியா - மறைச்சாட்சி', 'Mem', 'மறைச்சாட்சியர்'),
(2, 25, 'IN Blessed Rani Maria, virgin, martyr', 'முத்தி. இராணி மரியா, கன்னியர், மறைச்சாட்சி', 'OpMem', 'மறைச்சாட்சியர்'),
(6, 8, 'IN Blessed Maria Theresa Chiramel, virgin', 'முத்தி. மரிய தெரேசா சிராமெல் - கன்னியர்', 'OpMem', '	\r\nகன்னியர்'),
(7, 3, 'IN Saint Thomas the Apostle', 'புனித தோமா - இந்தியாவின் திருத்தூதர்', 'Solemnity-PrincipalPartron-Place', 'PROPER'),
(7, 28, 'IN Saint Alphonsa of the Immaculate Conception (Alphonsa Muttathupadathu), virgin', 'அமலோற்பவத்தின் புனித அல்போன்சா முட்டாத்துபாடாத் - கன்னியர்', 'Mem', 'கன்னியர்'),
(8, 30, 'IN Saint Euphrasia, virgin', 'புனித யூப்ரேசியா, கன்னியர்', 'OpMem', 'கன்னியர்'),
(9, 5, 'IN Saint Teresa of Calcutta, virgin', 'புனித அன்னை தெரேசா - கன்னியர்', 'Mem', 'கன்னியர்'),
(10, 16, 'IN Blessed Augustine Thevarparambil, priest', 'முத்தி. அகுஸ்தின் தேவர்பரம்பில் - மறைப்பணியாளர்', 'OpMem', 'மேய்ப்பர்'),
(12, 3, 'IN Saint Francis Xavier, priest', 'புனித பிரான்சிஸ் சவேரியார் - மறைப்பணியாளர், இந்தியாவின் பாதுகாவலர்', 'Solemnity-PrincipalPartron-Place', 'மேய்ப்பர் (மறைபரப்புப் பணியாளர்)');
