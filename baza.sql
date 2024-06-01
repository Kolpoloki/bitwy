
CREATE TABLE IF NOT EXISTS battles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    location VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    context TEXT NOT NULL,
    causes TEXT NOT NULL,
    effects TEXT NOT NULL,
    key_moments TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS battle_sides (
    id INT AUTO_INCREMENT PRIMARY KEY,
    battle_id INT NOT NULL,
    side_name VARCHAR(255) NOT NULL,
    commanders TEXT NOT NULL,
    casualties INT NOT NULL,
    wounded INT NOT NULL,
    prisoners INT NOT NULL,
    motives TEXT,
    material_losses TEXT NOT NULL,
    strategy TEXT NOT NULL,
    troops TEXT NOT NULL,
    total_troops INT NOT NULL,
    CONSTRAINT `fk_battle_id`
    FOREIGN KEY (battle_id) REFERENCES battles (id)
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS quizzes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title TEXT NOT NULL,
    description TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT NOT NULL REFERENCES,
    question TEXT,
    question_type TEXT NOT NULL,
    option1 VARCHAR(255) NOT NULL,
    option2 VARCHAR(255) NOT NULL,
    option3 VARCHAR(255) NOT NULL,
    option4 VARCHAR(255) NOT NULL,
    correct_option VARCHAR(255) NOT NULL,
    CONSTRAINT `fk_quiz_id`
    FOREIGN KEY (quiz_id) REFERENCES quizzes (id)
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS quiz_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT NOT NULL,
    username VARCHAR(100),
    score INT,
    correct_answers INT,
    total_questions INT,
    date_taken TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_quiz_id`
    FOREIGN KEY (quiz_id) REFERENCES quizzes (id)
    ON DELETE CASCADE   
);