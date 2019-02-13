-- The following statement sets the collation of the database to UTF8.

ALTER DATABASE atnight CHARACTER SET utf8 COLLATE utf8_unicode_ci;

-- Drop statements
DROP TABLE IF EXISTS eventTag;
DROP TABLE IF EXISTS tag;
DROP TABLE IF EXISTS event;
DROP TABLE IF EXISTS admin;


-- Creates the admin entity
CREATE TABLE admin (
	adminId BINARY(16) NOT NULL,
	adminEmail VARCHAR(128) NOT NULL,
	adminHash CHAR(97) NOT NULL,
	adminUsername VARCHAR(32) NOT NULL,
	-- Creates a unique index to prevent duplicated data
	UNIQUE(adminEmail),
	UNIQUE(adminUsername),
	-- Sets the primary key
	PRIMARY KEY(adminId)
);

-- Creates the event entity
CREATE TABLE event (
	-- this is for the primary key
	eventId BINARY(16) NOT NULL,
	-- this is for a foreign key
	eventAdminId BINARY(16) NOT NULL,
	-- these are attributes
	eventAgeRequirement VARCHAR(128),
	eventDescription VARCHAR(500),
	eventEndTime DATETIME(6) NOT NULL,
	eventImage VARCHAR(256) NOT NULL,
	eventLocation VARCHAR (256),
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

-- Creates the tag entity
CREATE TABLE tag (
	tagId BINARY(16) NOT NULL,
	tagAdminId BINARY(16) NOT NULL,
	tagType CHAR(32) NOT NULL,
	tagValue CHAR(32) NOT NULL,
	INDEX(tagAdminId),
	FOREIGN KEY(tagAdminId) REFERENCES admin(adminId),
	PRIMARY KEY(tagId)
);

-- Creates the weak eventTag entity
CREATE TABLE eventTag (
	eventTagEventId BINARY(16) NOT NULL,
	eventTagTagId BINARY(16) NOT NULL,
	INDEX(eventTagEventId),
	INDEX(eventTagTagId),
	FOREIGN KEY(eventTagEventId) REFERENCES  event(eventId),
	FOREIGN KEY(eventTagTagId) REFERENCES  tag(tagId),
	PRIMARY KEY(eventTagEventId, eventTagTagId)
);
