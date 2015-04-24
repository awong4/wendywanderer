/* Carissa Sun and Alice Wong
Modeling our travel based web app
*/

-- drop tables if exists to start afresh

drop table if exists photoalbum;
drop table if exists buddy;
drop table if exists review;
drop table if exists trip;

drop table if exists user;
drop table if exists city;

create table user (
        -- auto increment the key so we don't over write
        id int auto_increment primary key,
        name varchar(25) NOT NULL,
        password varchar(125) NOT NULL, -- Not sure how long crypt() outputs
        phonenum int,
        email varchar(50) NOT NULL,
	homeCity varchar(15),
        homeCountry varchar(15),
        rating decimal(2,1),
        index(id)
)
ENGINE=InnoDB;


create table city (
        -- auto increment the key so we don't over write
        id int auto_increment primary key,
        name varchar(15) NOT NULL,
        country varchar(15) NOT NULL,
        description varchar(50) default NULL, /* will be implemented if we have time*/
        index(id)
)
ENGINE=InnoDB;

create table photoalbum (
        userID int NOT NULL,
        primary key (userID),
        index (userID),
        foreign key(userID) references user(id) on delete cascade        
        /* we don't yet know how to upload files */
)
ENGINE=InnoDB;


create table review (
        cityID int NOT NULL,
        contactID int NOT NULL,
        review text,
        primary key (cityID,contactID),
        index(cityID),
        index(contactID),
        foreign key(cityID) references city(id) on delete cascade,       
        foreign key(contactID) references user(id) on delete cascade
)
ENGINE=InnoDB;

create table trip (
        -- auto increment the key so we don't over write
        id int auto_increment primary key,
        ownerID int NOT NULL,
        startDate date,
        endDate date,
        cityID int NOT NULL,
        index(ownerID),
        index(cityID),
        foreign key(ownerID) references user(id) on delete cascade,
        foreign key(cityID) references city(id) on delete cascade,
        index(id)
        -- balance int default '0',
)
ENGINE=InnoDB;

create table buddy (
        tripID int NOT NULL,
        userID int NOT NULL,
        primary key (tripID,userID),
        index(tripID),
        index(userID),
        foreign key(tripID) references trip(id) on delete cascade,
        foreign key(userID) references user(id) on delete cascade
)
ENGINE=InnoDB;

insert into user(name,password,email) values
        ('Carissa','123','test');

-- initialize the database with cities
insert into city(name, country) values
        ('London','England'),
        ('Paris','France'),
        ('Madrid','Spain'),
        ('Istanbul','Turkey'),
        ('Budapest','Hungary'),
        ('Beijing','China'),
        ('Tokyo','Japan');

insert into trip(ownerID,startDate,endDate,cityID) values
        (1,'2015-01-01','2015-02-01',1),
        (1,'2015-01-02','2015-02-01',2),
        (1,'2015-01-03','2015-02-01',3),
        (1,'2015-01-04','2015-02-01',4),
        (1,'2015-01-05','2015-02-01',5);

insert into review(cityID,contactID,review) values
        (1,1,'wow so pretty');
