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
	eventLat DECIMAL (9,6) NOT NULL,
	eventLng DECIMAL (9,6) NOT NULL,
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

-- @author Dylan McDonald <dmcdonald21@cnm.edu>
-- drop the procedure if already defined
DROP FUNCTION IF EXISTS haversine;
-- procedure to calculate the distance between two points
	-- @param FLOAT $originX point of origin, x coordinate
	-- @param FLOAT $originY point of origin, y coordinate
	-- @param FLOAT $destinationX point heading out, x coordinate
	-- @param FLOAT $destinationY point heading out, y coordinate
	-- @return FLOAT distance between the points, in miles
CREATE FUNCTION haversine(originX FLOAT, originY FLOAT, destinationX FLOAT, destinationY FLOAT) RETURNS FLOAT
BEGIN
	-- first, declare all variables; I don't think you can declare later
	DECLARE radius FLOAT;
	DECLARE latitudeAngle1 FLOAT;
	DECLARE latitudeAngle2 FLOAT;
	DECLARE latitudePhase FLOAT;
	DECLARE longitudePhase FLOAT;
	DECLARE alpha FLOAT;
	DECLARE corner FLOAT;
	DECLARE distance FLOAT;
	-- assign the variables that were declared & use them
	SET radius = 3958.7613; -- radius of the earth in miles
	SET latitudeAngle1 = RADIANS(originY);
	SET latitudeAngle2 = RADIANS(destinationY);
	SET latitudePhase = RADIANS(destinationY - originY);
	SET longitudePhase = RADIANS(destinationX - originX);
	SET alpha = POW(SIN(latitudePhase / 2), 2)
		+ POW(SIN(longitudePhase / 2), 2)
						* COS(latitudeAngle1) * COS(latitudeAngle2);
	SET corner = 2 * ASIN(SQRT(alpha));
	SET distance = radius * corner;
	RETURN distance;
END;
