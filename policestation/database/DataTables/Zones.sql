create table Zones(
	id		int unsigned, /* primary key */
	x_coord		int unsigned	not null,
	y_coord		int unsigned	not null,
	primary key(id)
);

--need to prevent tow zones with the same coords
--verification implemented on database access
