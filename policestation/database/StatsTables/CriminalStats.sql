create table CriminalStats (
	unit_id	int unsigned, /* key */
	prize	int	not null,
	primary key(unit_id),
	foreign key(unit_id) references UnitsStats(id)
);
