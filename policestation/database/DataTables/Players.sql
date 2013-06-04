create table Players (
	id		int, /* primary key */
	username	varchar(255)	not null	unique,
	password	varchar(255)	not null,
	lastTimeLogged	timestamp,
	primary key(id)
);
