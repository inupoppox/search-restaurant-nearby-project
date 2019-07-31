
--
-- Table structure for table `placesDB`
--

create table placesDB
(
	id int auto_increment,
	placeID char(50) not null,
	placename char(100) not null,
	lati char(15) not null,
	longi char(15) not null,
	vicinity char(150) not null,
	photos varchar(250) null,
	rating int null,
	constraint placesDB_pk
		primary key (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 comment 'Restaurant database acquired from Google Maps API';
