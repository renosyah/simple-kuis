CREATE TABLE user(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name TEXT,
    username TEXT,
    password TEXT
);

INSERT INTO user (id,name,username,password) VALUES (1,'reno','renosyah','12345');

CREATE TABLE course(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name TEXT,
    description TEXT,
    image_url TEXT,
    created_by INT(11) NOT NULL,
    FOREIGN KEY (created_by) REFERENCES user(id)
);

CREATE TABLE exam(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    course_id INT(11) NOT NULL,
    number TEXT,
    text TEXT,
    FOREIGN KEY (course_id) REFERENCES course(id)
);

CREATE TABLE exam_answer(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    exam_id INT(11) NOT NULL,
    label TEXT,
    text TEXT,
    FOREIGN KEY (exam_id) REFERENCES exam(id)
);

CREATE TABLE exam_progress(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    exam_id INT(11) NOT NULL,
    exam_answer_id INT(11) NOT NULL,
    answer_by INT(11) NOT NULL,
    FOREIGN KEY (answer_by) REFERENCES user(id),
    FOREIGN KEY (exam_id) REFERENCES exam(id),
    FOREIGN KEY (exam_answer_id) REFERENCES exam_answer(id)
);

CREATE TABLE exam_solution(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    exam_id INT(11) NOT NULL,
    exam_answer_id INT(11) NOT NULL,
    FOREIGN KEY (exam_id) REFERENCES exam(id),
    FOREIGN KEY (exam_answer_id) REFERENCES exam_answer(id)
);

