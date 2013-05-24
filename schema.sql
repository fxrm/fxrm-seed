CREATE TABLE Session ("key", userId, createdTime);
CREATE TABLE User (name, email, lastSessionId);

INSERT INTO User (name, email) values ('Joe', 'joe');
