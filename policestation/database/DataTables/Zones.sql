create table Zones(
	id		int, /* primary key */
	x_coord		int	not null,
	y_coord		int	not null,
	primary key(id)
);

--need to prevent tow zones with the same coords
--verification implemented on database access
