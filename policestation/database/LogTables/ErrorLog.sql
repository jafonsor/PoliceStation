create table ErrorLog (
	id		int unsigned, /* primary key */
	logDate		timestamp,
	type		varchar(255)	not null,
	fileName	varchar(255)	not null,
	line		int		not null,
	message		varchar(255)	not null,
	trace		varchar(255),
	primary key(id)
);
