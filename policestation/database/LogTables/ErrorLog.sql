create table ErrorLog (
	id	int unsigned, /* primary key */
	date	timestamp,
	type	varchar(255)	not null,
	file	varchar(255)	not null,
	line	varchar(255)	not null,
	message	varchar(255)	not null,
	primary key(id)
);
