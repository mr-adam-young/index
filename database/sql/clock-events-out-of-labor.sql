-- clean up my mess

-- INSERT INTO clock_events (email, clock_time, job_name, task_name, notes, is_clock_in, is_processed, created_at, updated_at)
SELECT 
    SUBSTRING_INDEX(description, ';', 1) AS email,                               -- Extract email
    Timestamp AS clock_time,                                                     -- Use Timestamp for clock_time
    SUBSTRING_INDEX(SUBSTRING_INDEX(description, ';', 2), ';', -1) AS job_name,  							 -- Extract job name
    SUBSTRING_INDEX(SUBSTRING_INDEX(description, ';', 3), ';', -1) AS task_name,                           -- e
    description AS notes,                                                        -- Full description as notes
    CASE WHEN StampIn IS NOT NULL THEN 1 ELSE 0 END AS is_clock_in,              -- Determine clock in or out
    0 AS is_processed,                                                           -- Initially not processed
    NOW() AS created_at,                                                         -- Current timestamp
    NOW() AS updated_at                                                          -- Current timestamp
FROM LaborNew
WHERE YEAR(Date) = 2024;
