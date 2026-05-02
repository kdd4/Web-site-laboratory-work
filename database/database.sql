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
    roles       VARCHAR(80)
);