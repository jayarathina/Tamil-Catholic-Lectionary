
--
-- Indexes for dumped tables
--

--
-- Indexes for table `generalcalendar`
--
ALTER TABLE `generalcalendar`
  ADD PRIMARY KEY (`feast_month`,`feast_date`,`feast_code`),
  ADD UNIQUE KEY `feast_en` (`feast_code`);

--
-- Indexes for table `generalcalendar__india`
--
ALTER TABLE `generalcalendar__india`
  ADD PRIMARY KEY (`feast_month`,`feast_date`);

--
-- Indexes for table `readings__list`
--
ALTER TABLE `readings__list`
  ADD PRIMARY KEY (`dayID`);

--
-- Indexes for table `readings__list_multiple`
--
ALTER TABLE `readings__list_multiple`
  ADD PRIMARY KEY (`dayID`,`name`);

--
-- Indexes for table `readings__saintscommon`
--
ALTER TABLE `readings__saintscommon`
  ADD PRIMARY KEY (`dayID`);

--
-- Indexes for table `readings__text`
--
ALTER TABLE `readings__text`
  ADD PRIMARY KEY (`refKey`,`usedBy`);

--
-- Indexes for table `readings__text__psalms`
--
ALTER TABLE `readings__text__psalms`
  ADD PRIMARY KEY (`refKey`,`usedBy`);
