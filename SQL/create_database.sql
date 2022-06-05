/* Main creation of the tables (it takes care for duplicates as well) */
create table if not exists project(
	ID int not null,
    title varchar(1000) not null,
    funds real,
    start_date varchar(50) not null,
    end_date varchar(50) not null,
    summary varchar(500) not null,
    duration real,
    primary key (ID));

create table if not exists review(   
	project_ID int not NULL,
	reviewer_ID int not null,
	review_grade real, 
	review_date date,
	primary key(project_ID));
	

create table if not exists deliverable(
	project_ID int not null,
	deliverable_title varchar(500) not null,
	summary varchar(10000),
	date_of_delivery date,
	primary key(project_ID, deliverable_title));
	
create table if not exists scientific_field(
	name_of_field varchar(50) not null,
	primary key(name_of_field));

create table if not exists scientific_field_of_project(
	project_ID int not null,
	name_of_field varchar(50) not null,
	primary key(project_ID, name_of_field));

create table if not exists executive(
	ID int not null,
	project_ID int not null,
	name varchar(20) not null,
	primary key(project_ID));

create table if not exists researcher(
	ID int not NULL,
	name varchar(50) not NULL,
	surname varchar(50) not null,
	date_of_birth date not null,
	sex varchar(10) not null ,
	age int,
	primary key(ID),
	check (sex in ('Male','Female')));

create table if not exists scientific_director(
	project_ID int not NULL,
	researcher_ID int not NULL,
	primary key(project_ID));
	
create table if not exists works_at(
	organization_ID int not null,
	researcher_ID int not null,
	starting_date date not null,
	primary key(researcher_ID));

create table if not exists organization(
	ID int not null,
	name varchar(50) not null,
	abbreviation varchar(20)not null,
	address_PC int not null,
	address_street varchar(50) not null,
	address_city varchar(50) not null,
	address_number int not null, 
	primary key(ID));

create table if not exists manages(
	project_ID int not null,
	organization_ID int not null,
	primary key(project_ID));

create table if not exists firm(
	ID int not null,
	equity real not null,
	primary key(ID));

create table if not exists university(
	ID int not null,
	ministry_budget real ,
	primary key(ID));

create table if not exists research_center(
	ID int not null,
	ministry_budget real,
	private_action_budget real,
	primary key(ID));

create table if not exists contact_numbers(
	organization_ID int not null,
	phone_number varchar(20) not null,
	primary key(phone_number));
	
create table if not exists funding_program(
	project_ID int not null,
	name varchar(50) not null,
	management varchar(50),
	primary key(project_ID));

create table if not exists works_at_project(
	researcher_ID int not null,
	project_ID int not null,
	primary key(project_ID,researcher_ID));

	
/* Define foreign key constraints */
alter table review
	add(
		foreign key(project_ID) references project(ID) on delete cascade,
		foreign key(reviewer_ID) references researcher(ID) on delete cascade);
		
alter table deliverable
	add foreign key(project_ID) references project(ID) on delete cascade;
	
alter table scientific_field_of_project
	add(
		foreign key(project_ID) references project(ID) on delete cascade,
		foreign key(name_of_field) references scientific_field(name_of_field) on delete cascade);

alter table executive
	add foreign key(project_ID) references project(ID) on delete cascade;
	
alter table manages
	add(
		foreign key(project_ID) references project(ID) on delete cascade,
		foreign key(organization_ID) references organization(ID) on delete cascade);

alter table works_at_project
	add(
		foreign key(researcher_ID) references researcher(ID) on delete cascade,
		foreign key(project_ID) references project(ID) on delete cascade);
		
alter table scientific_director
	add(
		foreign key(project_ID) references project(ID) on delete cascade,
		foreign key(researcher_ID) references researcher(ID) on delete cascade);

alter table works_at
	add(
		foreign key(organization_ID) references organization(ID) on delete cascade,
		foreign key(researcher_ID) references researcher(ID) on delete cascade);

alter table contact_numbers
	add foreign key(organization_ID) references organization(ID) on delete cascade;

alter table firm
	add foreign key(ID) references organization(ID) on delete cascade;

alter table university
	add foreign key(ID) references organization(ID) on delete cascade;

alter table research_center
	add foreign key(ID) references organization(ID) on delete cascade;

alter table funding_program
	add foreign key(project_ID) references project(ID) on delete cascade;
	
/*index creation*/
create index executive_name on executive(name);
create index proj_start_date on project(start_date);
create index proj_end_date on project(end_date);
create index researcher_age on researcher(age);

/* views required for 3.2 question */
/*1st view: Projects per researcher*/
CREATE VIEW projects_per_researcher AS
	SELECT title, surname, researcher.ID as res_ID
	FROM project,works_at_project,researcher 
	WHERE project.ID = project_ID and researcher_ID = researcher.ID;
	
/*2nd view: Researcher per project*/
CREATE VIEW researchers_per_project AS
	SELECT title, surname, project.ID as proj_ID
	FROM project,works_at_project,researcher
	WHERE project.ID = project_ID and researcher_ID = researcher.ID ;
