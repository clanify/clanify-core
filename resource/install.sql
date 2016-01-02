# remove tables
DROP TABLE IF EXISTS `clan_role`;
DROP TABLE IF EXISTS `clan_team`;
DROP TABLE IF EXISTS `clan_user`;
DROP TABLE IF EXISTS `role_permission`;
DROP TABLE IF EXISTS `team_role`;
DROP TABLE IF EXISTS `team_user`;
DROP TABLE IF EXISTS `user_role`;
DROP TABLE IF EXISTS `clan`;
DROP TABLE IF EXISTS `permission`;
DROP TABLE IF EXISTS `role`;
DROP TABLE IF EXISTS `team`;
DROP TABLE IF EXISTS `user`;

# entities
CREATE TABLE clan (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL DEFAULT '',
  tag VARCHAR(5) NOT NULL DEFAULT '',
  website VARCHAR(255) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
);
CREATE TABLE permission (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
);
CREATE TABLE role (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
);
CREATE TABLE team (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL DEFAULT '',
  tag VARCHAR(5) NOT NULL DEFAULT '',
  website VARCHAR(255) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
);
CREATE TABLE user (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  birthday DATE NOT NULL,
  email VARCHAR(255) NOT NULL DEFAULT '',
  firstname VARCHAR(255) NOT NULL DEFAULT '',
  gender CHAR(1) NOT NULL DEFAULT '',
  lastname VARCHAR(255) NOT NULL DEFAULT '',
  password CHAR(128) NOT NULL DEFAULT '',
  salt CHAR(128) NOT NULL DEFAULT '',
  username VARCHAR(100) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
);

# joinings
CREATE TABLE clan_role (
  clan_id INT UNSIGNED NOT NULL,
  role_id INT UNSIGNED NOT NULL,
  FOREIGN KEY (clan_id) REFERENCES clan(id),
  FOREIGN KEY (role_id) REFERENCES role(id),
  PRIMARY KEY (clan_id, role_id)
);
CREATE TABLE clan_team (
  clan_id INT UNSIGNED NOT NULL,
  team_id INT UNSIGNED NOT NULL,
  FOREIGN KEY (clan_id) REFERENCES clan(id),
  FOREIGN KEY (team_id) REFERENCES team(id),
  PRIMARY KEY (clan_id, team_id)
);
CREATE TABLE clan_user (
  clan_id INT UNSIGNED NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  FOREIGN KEY (clan_id) REFERENCES clan(id),
  FOREIGN KEY (user_id) REFERENCES user(id),
  PRIMARY KEY (clan_id, user_id)
);
CREATE TABLE role_permission (
  role_id INT UNSIGNED NOT NULL,
  permission_id INT UNSIGNED NOT NULL,
  FOREIGN KEY (role_id) REFERENCES role(id),
  FOREIGN KEY (permission_id) REFERENCES permission(id),
  PRIMARY KEY (role_id, permission_id)
);
CREATE TABLE team_role (
  role_id INT UNSIGNED NOT NULL,
  team_id INT UNSIGNED NOT NULL,
  FOREIGN KEY (role_id) REFERENCES role(id),
  FOREIGN KEY (team_id) REFERENCES team(id),
  PRIMARY KEY (role_id, team_id)
);
CREATE TABLE team_user (
  team_id INT UNSIGNED NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  FOREIGN KEY (team_id) REFERENCES team(id),
  FOREIGN KEY (user_id) REFERENCES user(id),
  PRIMARY KEY (team_id, user_id)
);
CREATE TABLE user_role (
  role_id INT UNSIGNED NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  FOREIGN KEY (role_id) REFERENCES role(id),
  FOREIGN KEY (user_id) REFERENCES user(id),
  PRIMARY KEY (role_id, user_id)
);