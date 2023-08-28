CREATE TABLE usuarios(
	id serial primary key,
	name varchar(60) not null,
	email varchar(60) not null,
	password_hash varchar(255) not null,
	token varchar(32) not null
);

CREATE TABLE entradas(
	id SERIAL PRIMARY KEY,
	prohibited_acesso TIMESTAMP NOT NULL,
	user_id INTEGER NOT NULL,
	FOREIGN KEY (user_id) REFERENCES usuarios (id)
);

ALTER TABLE entradas ADD COLUMN ativa BOOLEAN DEFAULT false;

CREATE TABLE saidas(
	id SERIAL PRIMARY KEY,
	exit_acesso TIMESTAMP NOT NULL,
	user_id INTEGER NOT NULL,
	FOREIGN KEY (user_id) REFERENCES usuarios (id)
);


