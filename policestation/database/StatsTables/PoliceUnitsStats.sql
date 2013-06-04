create table PoliceUnitsStats (
	unit_id		int, /* key */
	price		int	not null	check(price >= 0),
	primary key(unit_id),
	foreign key(unit_id) references UnitsStats(id)
);
