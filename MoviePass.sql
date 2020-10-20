create database MoviePass;
use MoviePass;

create table genres (id_genre int NOT NULL,
					 name_genre varchar (50) NOT NULL,
                     constraint pk_idGenre primary key (id_genre),
                     constraint unq_nameGenre unique (name_genre));
                     
create table movies (id_movie int NOT NULL,
					 title_movie varchar (50) NOT NULL,
                     overview_movie text,
                     img_movie varchar (100),
                     language_movie varchar (2) NOT NULL,
                     genreIds_movie text NOT NULL,
                     releaseDate_movie date NOT NULL,
                     duration_movie int,
                     constraint pk_idMovie primary key (id_movie));
                     
create table users (id_user int auto_increment,
					email_user varchar (50) NOT NULL,
                    password_user varchar (50) NOT NULL,

                    idRol_user int NOT NULL,
                    constraint pk_idUser primary key (id_user),
                    constraint fk_idRol foreign key (idRol_user) references rols (id_rol),
                    constraint unq_emailUser unique (email_user));

create table userProfiles (id_user int NOT NULL,
                    firstName_userProfiles varchar (50) NOT NULL,
                    lastName_userProfiles varchar (50) NOT NULL,                    
                    dni_userProfiles varchar (10) NOT NULL,
                    constraint unq_idUser unique (id_user),
                    constraint fk_idIser foreign key (id_user) references users(id_user),
                    );
                    
create table rols (id_rol int auto_increment,
				    description_rol text NOT NULL,
                    constraint pk_idRol primary key (id_rol));
                   
create table cinemas (id_cinema int auto_increment,
					 name_cinema varchar (50) NOT NULL,
					 capacity_cinema int,
                     address_cinema varchar (50),
                     city_cinema varchar (50),
                     province_cinema varchar (50),
                     zip_cinema varchar (10),
                     ticketPrice_cinema float,
                     constraint pk_idCinema primary key (id_cinema),
                     constraint unq_cinema unique (name_cinema, address_cinema));
                     
create table room (id_room int auto_increment,
                    name_room varchar(50) not null,
                    price_room float not null,
                    capacity_room int not null,
                    idCinema_room int not null,
                    constraint pk_idRoom primary key(id_room),
                    constraint fk_idCinema foreign key(idCinema_room) references cinemas(id_cinema));






INSERT INTO rols (id_rol, description_rol) VALUES (1, 'admin');
INSERT INTO rols (id_rol, description_rol) VALUES (2, 'user');