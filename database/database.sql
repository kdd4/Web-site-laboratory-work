CREATE TABLE mathtest (
    id        SERIAL PRIMARY KEY,
    date      DATE,
    fio       VARCHAR(50),
    question1 VARCHAR(20),
    question2 VARCHAR(20),
    question3 VARCHAR(20),
    result    BOOLEAN
);