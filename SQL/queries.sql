--Draft of SQL queries

--(3.1)
SELECT title, r.name, surname
FROM project, works_at_project as w, executive as e,researcher as r
WHERE e.project_ID = project.ID and researcher_ID = r.ID and w.project_ID = project.ID
	start_date = "input" AND			
	duration = "input" AND
	e.name = "input"
GROUP BY title;

--(3.2)
--1st view: Projects per researcher
CREATE VIEW projects_per_researcher AS
	SELECT title, surname, researcher.ID as res_ID
	FROM project,works_at_project,researcher 
	WHERE project.ID = project_ID and researcher_ID = researcher.ID ;
	
--2nd view: Researcher per project
CREATE VIEW researchers_per_project AS
	SELECT title, surname, project.ID as proj_ID
	FROM project,works_at_project,researcher
	WHERE project.ID = project_ID and researcher_ID = researcher.ID ;

--(3.3)
SELECT DISTINCT title,name,surname
FROM project,works_at_project as w,researcher,scientific_field_of_project as s
WHERE s.name_of_field = 'Medicine' AND
	w.researcher_ID = researcher.ID AND 
	w.project_ID = project.ID AND
   	s.project_ID = project.ID AND
	end_date > CURDATE();
					  
--(3.4) 
SELECT org_ID,organization.name
FROM organization,(SELECT table1.org_ID,table1.num_of_proj
					FROM (SELECT EXTRACT(YEAR from project.start_date) as years,
                        		organization.ID as org_ID,count(project.ID) as num_of_proj
						FROM manages,organization,project
						WHERE organization.ID = organization_ID AND project.ID = project_ID
						GROUP BY years,org_ID) as table1, 
    					(SELECT EXTRACT(YEAR from project.start_date) as years,
                        		organization.ID as org_ID,count(project.ID) as num_of_proj
						FROM manages,organization,project
						WHERE organization.ID = organization_ID AND project.ID = project_ID
						GROUP BY years,org_ID) as table2
					WHERE table1.org_ID = table2.org_ID AND
						table1.num_of_proj = table2.num_of_proj AND
						table1.years - table2.years = 1) as newtable
WHERE org_ID = organization.ID AND num_of_proj>=10;

--(3.5) 
SELECT first_name,second_name,count(project_ID) as number_of_projects
FROM(
	SELECT field1.name_of_field as first_name, field2.name_of_field as second_name, field1.project_ID
    FROM scientific_field_of_project as field1, scientific_field_of_project as field2
    WHERE field1.project_ID = field2.project_ID AND
        field1.name_of_field < field2.name_of_field 
    ) newtable
GROUP BY first_name
ORDER BY number_of_projects DESC
LIMIT 3;

--(3.6)					  
SELECT name,surname,num_of_projects
FROM(SELECT researcher.ID,name,surname,count(project.ID) as num_of_projects
	FROM project,researcher,works_at_project
	WHERE project_ID=project.ID AND researcher_ID=researcher.ID AND researcher.age<40 AND end_date < CURDATE()
	GROUP BY researcher.ID) as newtable
ORDER BY num_of_projects DESC 
LIMIT 10;

--(3.7)
SELECT e.name, organization.name as name, sum(p.funds) as total_funds
FROM executive as e, project as p, organization,(SELECT firm.ID as firm_ID, project_ID
						FROM firm,manages
						WHERE firm.ID = manages.organization_ID 
						ORDER BY firm.ID) as proj_per_firm
WHERE proj_per_firm.project_ID = e.project_ID AND p.ID = e.project_ID AND organization.ID = firm_ID
GROUP BY firm_ID, e.name
ORDER BY total_funds DESC
LIMIT 5;


--(3.8) 
SELECT ID,name,surname,num_of_proj
FROM(
    SELECT ID,name,surname, count(project_ID) as num_of_proj
    FROM(
        SELECT DISTINCT researcher.ID,name,surname,w.project_ID
        FROM project,works_at_project as w ,researcher,deliverable
        WHERE w.project_ID = project.ID AND
            researcher_ID = researcher.ID AND
            w.project_ID NOT IN (SELECT project_ID
                                 FROM deliverable) 
        ) newtable
    GROUP BY ID) newtable2
WHERE num_of_proj>=5
ORDER BY num_of_proj DESC;
