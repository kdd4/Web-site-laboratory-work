CREATE TABLE mathtest (
    id          SERIAL PRIMARY KEY,
    date        DATE,
    fio         VARCHAR(50),
    question1   VARCHAR(20),
    question2   VARCHAR(20),
    question3   VARCHAR(20),
    result      BOOLEAN
);

CREATE TABLE blog (
    id          SERIAL PRIMARY KEY,
    fio         VARCHAR(50),
    theme       TEXT,
    time        TIMESTAMP,
    image       BYTEA,
    imgtype     VARCHAR(50),
    text        TEXT
);

CREATE TABLE "user" (
    id          SERIAL PRIMARY KEY,
    login       VARCHAR(50) UNIQUE,
    password    VARCHAR(80),
    fio         VARCHAR(70),
    email       VARCHAR(70),
    roles       VARCHAR(80)
);

CREATE TABLE "visits" (
    id          SERIAL PRIMARY KEY,
    time        TIMESTAMP,
    page        VARCHAR(20),
    ip          VARCHAR(15),
    host        VARCHAR(40),
    browser     VARCHAR(50)
);