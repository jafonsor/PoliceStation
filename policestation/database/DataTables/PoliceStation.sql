create table PoliceStations(
	id		int, /* primary key */
	name		varchar(255)	not null,
	player_id	int		not null,
	zone_id		int 		not null,
	primary key(id),
	foreign key(player_id) references Players(id),
	foreign key(zone_id) references Zones(id)	
);
