create database MoviePass;
use MoviePass;

create table genres (id_genre int NOT NULL,
					 name_genre varchar (50) NOT NULL,
                     constraint pk_idGenre primary key (id_genre),
                     constraint unq_nameGenre unique (name_genre));
                     
create table movies (id_movie int NOT NULL,
					 title_movie varchar (100) NOT NULL,
                     overview_movie text,
                     img_movie varchar (100),
                     language_movie varchar (2) NOT NULL,
                     releaseDate_movie date NOT NULL,
                     duration_movie int,
                     constraint pk_idMovie primary key (id_movie));

create table movies_genres(id_movie int not null,
                    id_genre int not null,
                    constraint unq_moviesGenres unique (id_movie, id_genre));
                    
create table rols (id_rol int auto_increment,
				    description_rol text NOT NULL,
                    constraint pk_idRol primary key (id_rol));
                     
create table users (id_user int auto_increment,
					email_user varchar (50) NOT NULL,
                    password_user varchar (50) NOT NULL,

                    idRol_user int NOT NULL,
                    constraint pk_idUser primary key (id_user),
                    constraint fk_idRol foreign key (idRol_user) references rols (id_rol),
                    constraint unq_emailUser unique (email_user));

create table userProfiles (idUser_userprofile int NOT NULL,
                    firstName_userprofile varchar (50),
                    lastName_userprofile varchar (50),                    
                    dni_userprofile varchar (10),
                    constraint unq_idUser unique (idUser_userprofile),
                    constraint fk_idIser foreign key (idUser_userprofile) references users(id_user)
                    );
                    

create table cinemas (id_cinema int auto_increment,
					 name_cinema varchar (50) NOT NULL,
                     address_cinema varchar (50),
                     city_cinema varchar (50),
                     province_cinema varchar (50),
                     zip_cinema varchar (10),
                     constraint pk_idCinema primary key (id_cinema),
                     constraint unq_cinema unique (name_cinema, address_cinema));
                     
create table rooms (id_room int auto_increment,
                    name_room varchar(50) not null,
                    price_room float not null,
                    capacity_room int not null,
                    idCinema_room int not null,
                    constraint pk_idRoom primary key(id_room),
                    constraint fk_idCinema foreign key(idCinema_room) references cinemas(id_cinema));


create table shows (id_show int auto_increment,
                    idMovie_show int not null,
                    datetime_show datetime not null,
                    idRoom_show int not null,
                    constraint pk_idShow primary key(id_show),
                    constraint fk_idMovie foreign key(idMovie_show) references movies(id_movie),
                    constraint fk_idRoom foreign key(idRoom_show) references rooms(id_room)
                    );


INSERT INTO rols (id_rol, description_rol) VALUES (1, 'admin');
INSERT INTO rols (id_rol, description_rol) VALUES (2, 'user');

INSERT INTO users (email_user, password_user, idRol_user) values ('admin@moviepass.com', '1234', 1);

INSERT INTO cinemas (name_cinema, address_cinema, city_cinema, province_cinema, zip_cinema) VALUES ('Cine Ambassador','Diagonal Centro 1673','Mar del Plata','Buenos Aires','7600');
INSERT INTO cinemas (name_cinema, address_cinema, city_cinema, province_cinema, zip_cinema) VALUES ('Cines Paseo Aldrey','Sarmiento 2685','Mar del Plata','Buenos Aires','7600');
INSERT INTO cinemas (name_cinema, address_cinema, city_cinema, province_cinema, zip_cinema) VALUES ('Cinemark Hoyts','Av. Alicia Moreau de Justo 1920','CABA','Buenos Aires','C1107');

INSERT INTO rooms (name_room, price_room ,capacity_room, idCInema_room) VALUES ('Sala A', 500, 100, 1);
INSERT INTO rooms (name_room, price_room ,capacity_room, idCInema_room) VALUES ('Sala B', 750, 120, 1);
INSERT INTO rooms (name_room, price_room ,capacity_room, idCInema_room) VALUES ('Sala C', 600, 115, 1);

INSERT INTO rooms (name_room, price_room ,capacity_room, idCInema_room) VALUES ('Sala A', 400, 90, 2);
INSERT INTO rooms (name_room, price_room ,capacity_room, idCInema_room) VALUES ('Sala B', 650, 110, 2);
INSERT INTO rooms (name_room, price_room ,capacity_room, idCInema_room) VALUES ('Sala C', 450, 105, 2);

INSERT INTO rooms (name_room, price_room ,capacity_room, idCInema_room) VALUES ('Sala A', 440, 110, 3);
INSERT INTO rooms (name_room, price_room ,capacity_room, idCInema_room) VALUES ('Sala B', 670, 105, 3);
INSERT INTO rooms (name_room, price_room ,capacity_room, idCInema_room) VALUES ('Sala C', 430, 128, 3);

SELECT * from rooms;

SELECT * from cinemas;

#drop database MoviePass;
drop table cinemas;
drop table rooms;
drop table shows;

drop table movies_genres;
drop table movies;
drop table genres;

SELECT count(*) from movies;
SELECT count(*) from movies_genres;
SELECT * from genres;

SELECT s.idMovie_show, s.datetime_show from shows s
INNER JOIN movies m ON m.id_movie = s.idMovie_show
INNER JOIN rooms r ON s.idRoom_show = r.id_room
INNER JOIN cinemas c ON c.id_cinema = r.idCinema_room
WHERE DAY(s.datetime_show) = DAY(now()) AND s.idMovie_show = 337401;

SELECT * from shows s
INNER JOIN rooms r ON s.idRoom_show = r.id_room
INNER JOIN movies m ON m.id_movie = s.idMovie_show
WHERE s.idRoom_show = 4 AND DAY(s.datetime_show) = DAY(now()) AND DATE_ADD(s.datetime_show, INTERVAL m.duration_movie minute) > 60 ;

#TIMESTAMPDIFF(minute, minute(s.datetime_show + m.duration_movie) , minute('2020-10-27 01:59:09.153')) > 15;

#restar a una fecha
SELECT DATE_SUB(CURDATE(), INTERVAL 30 minute);

#sumar a una fecha
SELECT m.duration_movie, DATE_ADD('2020-10-27 00:20:09.153', INTERVAL m.duration_movie minute) from shows s
INNER JOIN movies m ON s.idMovie_show = m.id_movie
WHERE minute(DATE_ADD('2020-10-27 00:20:09.153', INTERVAL m.duration_movie minute));
