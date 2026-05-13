CREATE TABLE "mathtest" (
    "id"          SERIAL PRIMARY KEY,
    "date"        DATE,
    "fio"         VARCHAR(50),
    "question1"   VARCHAR(20),
    "question2"   VARCHAR(20),
    "question3"   VARCHAR(20),
    "result"      BOOLEAN
);

CREATE TABLE "blog" (
    "id"          SERIAL PRIMARY KEY,
    "fio"         VARCHAR(50),
    "theme"       TEXT,
    "time"        TIMESTAMP,
    "image"       BYTEA,
    "imgtype"     VARCHAR(50),
    "text"        TEXT
);

CREATE TABLE "user" (
    "id"          SERIAL PRIMARY KEY,
    "login"       VARCHAR(50) UNIQUE,
    "password"    VARCHAR(80),
    "fio"         VARCHAR(70),
    "email"       VARCHAR(70),
    "roles"       VARCHAR(80)
);

CREATE TABLE "visits" (
    "id"          SERIAL PRIMARY KEY,
    "time"        TIMESTAMP,
    "page"        VARCHAR(20),
    "ip"          VARCHAR(15),
    "host"        VARCHAR(40),
    "browser"     VARCHAR(50)
);

CREATE TABLE "blogComment" (
    "id"          SERIAL PRIMARY KEY,
    "userID"     INTEGER,
    "blogID"     INTEGER NOT NULL,
    "text"        TEXT,
    "time"        TIMESTAMP,

    CONSTRAINT FK_user FOREIGN KEY ("userID")
    REFERENCES "user"("id")
    ON DELETE SET NULL
	ON UPDATE CASCADE,

    CONSTRAINT FK_blog FOREIGN KEY ("blogID")
    REFERENCES "blog"("id")
    ON DELETE CASCADE
	ON UPDATE CASCADE
);

CREATE TABLE "prime" (
    "id"          SERIAL PRIMARY KEY,
    "time"        TIMESTAMP,
    "length"      INTEGER,
    "result"      TEXT
);