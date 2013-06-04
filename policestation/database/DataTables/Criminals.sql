create table Criminals (
	zone_id		int, /* key */
	criminal_id	int, /* key */
	amount		int	not null	check(amount > 0),
	primary key(zone_id,criminal_id),
	foreign key(zone_id) references Zones(id),
	foreign key(criminal_id) references CriminalStats(unit_id)
);
