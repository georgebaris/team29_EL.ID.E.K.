UPDATE project
SET duration = EXTRACT(YEAR FROM end_date) - EXTRACT(YEAR FROM start_date);

UPDATE researcher
SET age = YEAR(CURDATE()) - EXTRACT(YEAR FROM date_of_birth);
