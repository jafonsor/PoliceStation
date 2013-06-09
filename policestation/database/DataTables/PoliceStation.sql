create table PoliceStations(
	id		int unsigned, /* primary key */
	name		varchar(255)	not null,
	player_id	int unsigned		not null,
	zone_id		int unsigned 		not null,
	primary key(id),
	foreign key(player_id) references Players(id),
	foreign key(zone_id) references Zones(id)	
);
