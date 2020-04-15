
-- --------------------------------------------------------

--
-- Table structure for table `readings__list_multiple`
--

CREATE TABLE `readings__list_multiple` (
  `dayID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reading1` text COLLATE utf8_unicode_ci NOT NULL,
  `psalms` text COLLATE utf8_unicode_ci NOT NULL,
  `reading2` text COLLATE utf8_unicode_ci NOT NULL,
  `alleluia` text COLLATE utf8_unicode_ci NOT NULL,
  `gospel` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `readings__list_multiple`
--

INSERT INTO `readings__list_multiple` (`dayID`, `name`, `reading1`, `psalms`, `reading2`, `alleluia`, `gospel`) VALUES
('LW06-0Sun', 'ஆண்டவருடைய திருப்பாடுகளின் குருத்து ஞாயிறு', 'எசா50:4-7', 'திபா22:7-8.16-17.18-19.22-23', 'பிலி2:6-11', 'பிலி2:8-9', '<yeartype=\'a\'>பவனியில்: மத்21:1-11; திருப்பலியில்: மத்26:14-27:66 or மத்27:11-54</year>\n<yeartype=\'b\'>பவனியில்: மாற்11:1-10 or யோவா12:12-16; திருப்பலியில்: மாற்14:1-15:47 ors மாற்15:1-39</year>\n<yeartype=\'c\'>பவனியில்: லூக்19:28-40; திருப்பலியில்: லூக்22:14-23:56 ors லூக்23:1-49</year>'),
('LW06-6Sat', 'பாஸ்கா திருவிழிப்பு', '<ol><li>தொநூ1:1-2:2 ors தொநூ1:1,26-31a\n<ul><li>திபா104:1-2a.5-6.10,12.13-14.24,35c or திபா33:4-5,6-7,12-13,20+22</li></ul>\n</li>\n<li>தொநூ22:1-18 ors 22:1-2,9-13,15-18\n<ul><li>திபா16:5,8.9-10.11</li></ul>\n</li>\n<li>விப14:15-15:9\n<ul><li>விப15:1-2.3-4.5-6.17-18</li></ul>\n</li>\n<li>எசா54:5-14\n<ul><li>திபா30:1,3.4-5.10,11a,12b</li></ul>\n</li>\n<li>எசா55:1-11\n<ul><li>எசா12:2-3.4bcd.5-6</li></ul>\n</li>\n<li>பாரூ3:9-15,32-4:4\n<ul><li>திபா19:7.8.9.10</li></ul>\n</li>\n<li>எசே36:16-17a,18-28\n<ul><li>திபா42:2,4bcd;43:3,4 or திபா51:10-11,12-13,16-17</li></ul>\n</li>\n</ol>', 'திபா118:1-2.16-17.22-23', 'உரோ6:3-11', '', '<yeartype=\'a\'>மத்28:1-10</year>\n<yeartype=\'b\'>மாற்16:1-8</year>\n<yeartype=\'c\'>லூக்24:1-12</year>');
