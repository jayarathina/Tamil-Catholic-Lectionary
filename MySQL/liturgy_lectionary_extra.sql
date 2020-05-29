
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
  ADD PRIMARY KEY (`dayID`,`type`);

--
-- Indexes for table `readings__notes`
--
ALTER TABLE `readings__notes`
  ADD PRIMARY KEY (`dayID`,`notesPos`);

--
-- Indexes for table `readings__text`
--
ALTER TABLE `readings__text`
  ADD PRIMARY KEY (`refKey`,`usedBy`);
