
-- --------------------------------------------------------

--
-- Table structure for table `readings__notes`
--

CREATE TABLE `readings__notes` (
  `dayID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notesPos` float NOT NULL DEFAULT '0',
  `Content` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `readings__notes`
--

INSERT INTO `readings__notes` (`dayID`, `notesPos`, `Content`) VALUES
('AW05-Dec24', 0, 'இன்று மாலையில் நடைபெறும் திருப்பலியில் கிறிஸ்து பிறப்பு திருவிழிப்புத் திருப்பலி வாசகங்களைப் பயன்படுத்தவும்.'),
('Dedication of the basilicas of Saints Peter and Paul, Apostles', 0, 'இன்றைய வாசகங்கள் இந்த நினைவுக்கு உரியவை.'),
('EW07-6Sat', 0, 'இன்று மாலையில் நடைபெறும் திருப்பலியில் தூய ஆவி ஞாயிறு திருவிழிப்புத் திருப்பலி வாசகங்களைப் பயன்படுத்தவும்.'),
('LW06-0Sun', -6, 'ஆண்டவருடைய திருப்பாடுகளின் வரலாறு, எரியும் திரிகளும் தூபமும் இன்றி, வாழ்த்துரை கூறாமலும் திருநூலில் சிலுவை அடையாளம் வரையாமலும் வாசிக்கப்படும்.'),
('LW06-0Sun', -1, 'திருப்பலி இந்த ஞாயிற்றுக்கிழமையில் தரப்பட்ட மூன்று வாசகங்களையும் வாசிப்பது நலம். ஆனால் ஆண்டவருடைய திருப்பாடுகளின் வரலாறு முக்கியமானதால், அதை ஒருபோதும் விட்டுவிடக் கூடாது. திருக்கூட்டத்தின் நிலைக்கு ஏற்றபடி, நற்செய்திக்கு முன் வரும் வாசகங்களில், ஒரு வாசகத்தை மட்டும் வாசிக்கலாம். அல்லது, தேவையானால் இரு வாசகங்களையும் விட்டுவிடலாம். மேலும் தேவையானால், திருப்பாடுகளின் குறுகிய வாசகத்தைப் பயன்படுத்தலாம். <br/> மேற்கூறியவை மக்களோடு சேர்ந்து நிறைவேற்றப்படும் திருப்பலிக்கே பொருந்தும்.'),
('LW06-6Sat', 0, 'பாஸ்கா திருவிழிப்புக்கென்று, பழைய ஏற்பாட்டிலிருந்து ஏழும் புதிய ஏற்பாட்டிலிருந்து இரண்டும் ஆக ஒன்பது வாசகங்கள் தரப்பட்டுள்ளன. தனிப்பட்ட சூழ்நிலைகளின் காரணமாக, இவ்வாசகங்களின் எண்ணிக்கையைக் குறைத்துக்கொள்ளலாம். என்றாலும் பழைய ஏற்பாட்டிலிருந்து மூன்று வாசகங்களாவது இருக்கவேண்டும்; ஆனால் மிக முக்கியமான காரணங்கள் இருந்தாலும்கூட, “செங்கடலைக் கடத்தல்” பற்றிய விடுதலைப் பயண நூல் வாசகம் (3ஆம் வாசகம்) ஒருபோதும் விடப்படலாகாது. இவற்றிற்குப் பின் திருமுகமும், நற்செய்தி வாசகமும் வாசிக்கப்படும்.'),
('LW06-6Sat', 2.72, 'இத்திருவிழிப்பின்போது திருமுழுக்கு நடைபெறுமானால், ஐந்தாம் வாசகத்துக்குப் பின்னர் வரும் பதிலுரைப் பாடலைப் பயன்படுத்தவும். அல்லது கீழே கொடுக்கப்பட்டுள்ள திருப்பாடல் 51ஐப் பயன்படுத்தவும்.'),
('Nativity of the Lord', 0, 'கிறிஸ்து பிறப்புப் பெருவிழாவின் மூன்று திருப்பலிகளிலும் அதற்குள்ள பாடங்களைப் பயன்படுத்தவும். ஆனாலும், மக்கள் நலனுக்காக இவற்றுள் ஏதாவது ஒரு திருப்பலியிலிருந்து பொருத்தமான வாசகங்களை மற்றொரு திருப்பலிக்கும் கூடத் தேர்ந்தெடுக்கலாம்.'),
('Nativity of the Lord 1', 0, 'டிசம்பர் 24ஆம் நாள் மாலையில் நடைபெறும் திருவிழிப்புத் திருப்பலியில் கீழ்க்கண்ட வாசகங்களைப் பயன்படுத்தவும்.');