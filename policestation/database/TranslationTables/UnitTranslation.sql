create table UnitTranslation (
	unit_id		int unsigned, /* key */
	english		varchar(255)	not null,
	primary	key(unit_id),
	foreign key(unit_id) references UnitsStats(id)
);
