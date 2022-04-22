LOAD DATA INFILE 'cost_centers.csv'
INTO TABLE emeraude.cost_centers
FIELDS TERMINATED BY ','
IGNORE 1 ROWS;