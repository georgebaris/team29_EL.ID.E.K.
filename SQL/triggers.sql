
/*1 duration BETWEEN 1-4 */
DELIMITER $$
CREATE DEFINER=`root`@`localhost` TRIGGER `project_duration`
 BEFORE INSERT ON `project` FOR EACH ROW 
 BEGIN
 DECLARE msg VARCHAR(255); 
IF (((EXTRACT(YEAR FROM new.end_date) - EXTRACT(YEAR FROM new.start_date)))<1) OR ((EXTRACT(YEAR FROM new.end_date) - EXTRACT(YEAR FROM new.start_date)) > 4 ) 
THEN SET msg := 'Error:The duration of a project must be between 1-4 years.'; SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = msg; 
END IF; 
END $$
DELIMITER ;


/*2 the reviewer dont work in the organization the project belongs */
DELIMITER $$
CREATE  TRIGGER unique_reviewer 
BEFORE INSERT ON review 
FOR EACH ROW 
BEGIN
DECLARE msg VARCHAR(255); 
if( NEW.reviewer_ID IN 
	(SELECT researcher_ID 
	FROM manages as m,works_at as w 
	WHERE m.project_ID = NEW.project_ID AND 
		w.organization_ID = m.organization_ID) ) 
THEN SET msg :='The reviewer can not work in the organization that manages the project'; 
SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = msg; 
END IF; 
END $$
DELIMITER ;







/*4 the scientific director works at the project */
DELIMITER $$
CREATE  TRIGGER scientific_director_works_at_project 
BEFORE INSERT ON scientific_director 
FOR EACH ROW 
BEGIN
DECLARE msg VARCHAR(255); 
if( NEW.project_ID NOT IN 
	(SELECT project_ID 
	FROM works_at_project where researcher_ID = NEW.researcher_ID ) ) 
THEN SET msg :='The scientific director must work at the project that he supervises'; 
SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = msg; 
END IF; 
END $$
DELIMITER ;





/*5 The researcher must work at the ORGANIZATION that has the project */
DELIMITER $$
CREATE  TRIGGER researcher_works_in_the_organization 
BEFORE INSERT ON works_at_project 
FOR EACH ROW 
BEGIN
DECLARE msg VARCHAR(255); 
if( NEW.researcher_ID NOT IN 
	(SELECT researcher_ID 
	FROM manages as m,works_at as w 
	WHERE m.project_ID = NEW.project_ID AND 
		w.organization_ID = m.organization_ID) )
THEN SET msg :='The researcher must work in the organization that runs the project in order to work on it '; 
SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = msg; 
END IF; 
END $$
DELIMITER ;




/*6 every project gets money from one funding program  */
DELIMITER $$
CREATE  TRIGGER one_funding_program_per_project
BEFORE INSERT ON funding_program 
FOR EACH ROW 
BEGIN
DECLARE msg VARCHAR(255); 
if( NEW.project_ID  IN 
	(SELECT project_ID
	FROM  funding_program)
  )
THEN SET msg :='Every project gets money from one funding program'; 
SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = msg; 
END IF; 
END $$

DELIMITER ;



/*7 every funnding program belogns to one elidek's management office  */

DELIMITER $$
CREATE  TRIGGER one_funding_program_to_one_office
BEFORE INSERT ON funding_program 
FOR EACH ROW 
BEGIN
DECLARE msg VARCHAR(255); 
if( NEW.name  IN 
	(SELECT name
	 FROM  funding_program 
     where management != NEW.management)
  )
THEN SET msg :='This program belongs to an other E.LI.DE.K managment office'; 
SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = msg; 
END IF; 
END $$
DELIMITER ;
