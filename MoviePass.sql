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
                     idsGenres_movie text NOT NULL,
                     releaseDate_movie date NOT NULL,
                     duration_movie int NOT NULL,
                     constraint pk_idMovie primary key (id_movie));
                     
create table users (id_user int auto_increment,
					email_user varchar (50) NOT NULL,
                    password_user varchar (50) NOT NULL,
                    lastName_user varchar (50) NOT NULL,
                    firstName_user varchar (50) NOT NULL,
                    dni_user varchar (10) NOT NULL,
                    id_rol int NOT NULL,
                    constraint pk_idUser primary key (id_user),
                    constraint fk_idRol foreign key (id_rol) references rols (id_rol),
                    constraint unq_emailUser unique (email_user));
                    
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
                     

                     
                    