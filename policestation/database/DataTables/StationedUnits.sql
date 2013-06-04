create table StationedUnits (
	station_id	int, /* key */
	policeUnit_id	int, /* key */
	amount		int	not null	check(amount >= 0), /* amount of units with unit_id */
	primary key(station_id, policeUnit_id),
	foreign key(station_id) references PoliceStations(id),
	foreign key(policeUnit_id) references PoliceUnitsStats(unit_id)
);
