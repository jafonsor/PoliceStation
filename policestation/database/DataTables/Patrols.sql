create table Patrols (
	id		int unsigned, /* primary key */
	station_id 	int unsigned		not null, /* id of the police station from where this patrol was sent */
	zone_id		int unsigned		not null, /* id of the zone of the patrol */
	begin_time	timestamp	not null,
	end_time	timestamp	not null,
	primary key(id),
	foreign key(station_id) references PoliceStations(id);
	foreign key(zone_id) references Zones(id);
);

--units of the patrol are stored at the PatrolingUnits table
