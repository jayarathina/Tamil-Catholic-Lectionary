# Tamil-Catholic-Lectionary
Generates daily Catholic Mass readings (Lectionary) in Tamil. This is based on my [Roman Catholic Liturgical Calendar Generator](https://github.com/jayarathina/Roman-Calendar).

Currently only the **Logic to display** the calendar and its readings are ready. Readings texts are entered for some. (If you want to help in entering readings please drop me a mail)

## Live Demo
- http://lectionary.madharasan.com/
- http://arulvakku.com/calendar.php
- A sample full year is displayed in  [index.php](index.php)
- A particular day example can be found in [ViewDay.php](ViewDay.php)

## Features of this library include:
- It provides First & Second Readings, Responsorial Psalm, Alleluiya, Gosepl, Sequences (if any) for the day.
- Readings or parts of readings will be automatically substituted. For example, on Sept 15, if it is a ferial day, Gospel alone will be taken from proper of Our Lady of Sorrows.
- Special care is taken to include notices (printed in red color) in the lectionary.
- Vigil mass readings are also displayed.
- It also provides readings proper to Saints found as in`tamil lectionary - III.`
- Exceptional cases like Palm Sunday, Eastre Vigil, Christmas are also dealth with.
- The text is presented as much as possible to look like that of a printed lectionary.
- Verse divisions are like those present in official Tamil Lectionary. (English lectionary and Tamil Lectionary differs in verses sub divisions)

## Requirements
- MySQL, PHP
- The [Medoo library](http://medoo.in) - (Included)

## Technical Details
- The code is completely documented. If you need any help, please let me know.
- There are four table in the database.
- liturgy_lectionary_table_generalcalendar.sql and liturgy_lectionary_table_generalcalendar.sql are from [Roman Catholic Liturgical Calendar Generator](https://github.com/jayarathina/Roman-Calendar).
  - `readings__list` - Contains reading lists for each day
  - `readings__notes` - Contains notices to be displayed in certain days
  - `readings__text` - Actual texts of the readings
### The Type Field
- Each readings are marked with a number (in column `type`). It normally denoes the type of the reading. Except for commons `Type` represents:
    1 - First Reading
    2 - Responsorial Psalm
    3 - Second Reading
    4 - Sequence
    5 - Alleluia
    6 - Gospel
    0 - Gospel During Procession (Only for Palm Sunday)
    9 - Saints Commons
- When the type contains fractional part it means:
    - _.1, _.2 etc are alternatives of the given reading. 
    - _.11, _.12 are _short_ alternatives of reading.
    - For example consider the following reading types: 1.1, 1.2, 1.31 and 1.32
        - First digit (1) show that they belong to First reading
        - 1.1, 1.2, 1.3* are alternative options available for first readings wherein 1.32 is a shorter alternative of 1.31
#### For commons `Type` represents:
- The above has a change when it comes to Commons (All commons readings have a refID that starts with `_` underscore) For commons the type number denotes the following:
    - 1 - OT First Readings
    - 2 - NT First Readings (Pascal Season)
    - 3 - Responsorial
    - 4 - Second Reading
    - 5 - Alleluia
    - 6 - Gospel
- Here the type contains fractional part it means: (note the extra zero)
    - _.01, _.02 etc are alternatives of the given reading. 
    - _.011, _.012 are _short_ alternatives of reading.
    - For example consider the following reading types: 1.01, 1.02, 1.031 and 1.032
        - First digit (1) show that they belong to First reading
        - 1.01, 1.02, 1.03* are alternative options available for first readings wherein 1.032 is a shorter alternative of 1.031
- `The fourth digit in the fraction part` denotes the subtype of the commons readings.
    - 0.0001 - அறச்செயலில் ஈடுபட்டோர்
    - 0.0002 - கல்விப் பணியாற்றியோர்
    - 0.0003 - கைம்பெண்கள்
    - 0.0005 - துறவியர்
    - 0.0004 - திருத்தந்தை
    - 0.0006 - மறைபரப்புப் பணியாளர்
## Todos
- Add readings in lectionary - IV - votive mass readings, Sacraments etc.
- Alternative Alleluiya for seasons should be added
- Table `readings__text` has redundunt texts. It will be optimised once all texts are entered.

## Suggestions or Comments
If you find any bug or suggest any improvement, please feel free to raise a pull request or contact me.
