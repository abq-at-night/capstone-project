-- the statement below sets the collection of th database to utf8
ALTER DATABASE abq-at-night/capstone-project  CHARACTER SET utf8 COLLATE utf_unicode_ci;

--
DROP TABLE IF EXISTS eventTag;
DROP TABLE IF EXISTS tag;

-- creates the tag class entity
CREATE TABLE eventTag (
  eventTagEventId BINNARY(16) NOT NULL,
  eventTagTagId BINARY(16) NOT NUll,
  INDEX(eventTagEventId),
  INDEX(eventTagTagId),
  FOREIGN KEY(eventTagEventId) REFERENCES  event(enentID),
  FOREIGN KEY(eventTagTagId) REFERENCES  event(tagID),
  PRIMARY KEY(eventTagEventId,eventTagTagId)
);

-- creates the tag entity
CREATE TABLE tag (
  tagId CHAR(32),
  tagAdminId BINARY(16),
  tagType CHAR(32),
  tagValue CHAR(32),
  INDEX(tagAdminId),
  FOREIGN KEY(tagAdminId) REFERENCES event(adminId),
  PRIMARY KEY(tagId),
);

