# History

Lineage below:

## Interversal Systems Management Engine (ISME)

2021 Fork of CRM and ERP system for metal fabrication company that was iterated on after original development ceased in 2018. It does have some Neo4j integration, but I didn't go too far with it.

## "system" (Informal)

Production resource tracking application. Developed in collaboration with Hess Ornamental Iron, an artisan metal fabrication company in York, PA. 

Include a REST API from scratch, not knowing about the existence of Laravel. 

This commit was restored from a 2018 backup of the project. The project was originally developed from 2015-2018. First priority is modernizing the codebase and updating dependencies. Following modernization, develop integration with ClockShark, Zapier, and Microsoft 365.

Old 2018 version required manual entry of granular timesheet data. New version will automatically track time and resources from webhooks on ClockShark events, and provide a user-friendly interface for manual adjustments. 