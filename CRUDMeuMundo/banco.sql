CREATE DATABASE bd_mundo;

USE bd_mundo;

CREATE TABLE continentes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    populacao BIGINT,
    area_km2 DECIMAL(12,2),
    total_paises INT
);

CREATE TABLE governantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    partido_politico VARCHAR(100),
    data_nascimento DATE,
    idade INT,
    inicio_mandato DATE,
    fim_mandato DATE
);

CREATE TABLE paises (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    continente_id INT,
    populacao BIGINT,
    area_km2 DECIMAL(12,2),
    idioma VARCHAR(100),
    governante_id INT,
    clima VARCHAR(100),
    regime_politico VARCHAR(100),
    moeda VARCHAR(100),

    FOREIGN KEY (continente_id) REFERENCES continentes(id),
    FOREIGN KEY (governante_id) REFERENCES governantes(id)
);

CREATE TABLE cidades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    pais_id INT,
    populacao BIGINT,
    area_km2 DECIMAL(10,2),
    clima VARCHAR(100),
    governante_id INT,
    data_fundacao DATE,

    FOREIGN KEY (pais_id) REFERENCES paises(id),
    FOREIGN KEY (governante_id) REFERENCES governantes(id)
);

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tentativas_erro INT DEFAULT 0,
    bloqueado TINYINT DEFAULT 0,
    primeiro_acesso TINYINT DEFAULT 1
);

CREATE TABLE logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    login_digitado VARCHAR(100),
    evento VARCHAR(50) NOT NULL,
    data_hora DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- usuário inicial: login admin, senha password (o sistema obriga a trocar no primeiro acesso)
INSERT INTO usuarios (login, senha)
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');