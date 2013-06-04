create table CriminalStats (
	unit_id		int, /* key */
	primary key(unit_id),
	foreign key(unit_id) references UnitsStats(id)
);
