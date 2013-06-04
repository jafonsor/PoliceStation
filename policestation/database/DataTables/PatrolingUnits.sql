create table PatrolingUnits (
	patrol_id	int, /* key */
	policeUnit_id	int, /* key */
	amount		int 	not null	check(amount >= 0), /* amount of units with unit_id */
	primary key(patrol_id, policeUnit_id),
	foreign key(patrol_id) references Patrols(id),
	foreign key(policeUnit_id) references PoliceUnitsStats(unit_id)
);
