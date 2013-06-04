create table StatsNameTranslation (
	statName	varchar(255), /* primary key -- must be a column of UnitStats table */
	english		varchar(255)	not null,
	primary key(statName)
);
