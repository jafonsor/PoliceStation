--Holds global variables of the game
create table Game (
	varName		varchar(255),	/* primary key */
	varValue	int,
	primary key(varName)
);

--- Add vars to Game ---
insert into Game (varName,varValue) values("nextPlayerId",1);
insert into Game (varName,varValue) values("nextUnitId",1);
