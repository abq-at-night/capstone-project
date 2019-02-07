-- The statement below sets the collation of the database to utf8
ALTER DATABASE wsalmons CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS event;

-- creates the event entity
CREATE TABLE event (
	-- this is for the primary key
	eventId BINARY(16) NOT NULL,
	-- this is for a foreign key
	eventAdminId BINARY(16) NOT NULL,
	-- these are attributes
	eventAgeRequirements VARCHAR(128),
	eventDate DATETIME(6) NOT NULL,
	eventDescription VARCHAR(500),
	eventEndTime DATETIME(6) NOT NULL,
	eventImage BINARY(16) NOT NULL,
	eventPrice VARCHAR(32),
	eventPromoterWebsite VARCHAR (256),
	eventStartTime DATETIME(6) NOT NULL,
	eventTitle VARCHAR(128) NOT NULL,
	eventVenue VARCHAR(128),
	eventVenueWebsite VARCHAR(256),
	-- this is a unique index
	UNIQUE(eventId),
	-- this creates an index before making a foreign key
	INDEX(eventAdminId),
	-- this creates the actual foreign key relation
	FOREIGN KEY(eventAdminId) REFERENCES admin(adminId),
	-- and finally create the primary key
	PRIMARY KEY(eventId)
);