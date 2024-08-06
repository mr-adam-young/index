# index

Rapid information retrieval system. Lineage below:

## ISME

2021 Fork of CRM and ERP system for metal fabrication company that was iterated on after original development ceased in 2018.

I expanded the capability of this project in 2021 to include a REST API from scratch, not knowing about the existence of Laravel. It does have some Neo4j integration, but I didn't go too far with it.

## system

Production resource tracking application. Developed in collaboration with Hess Ornamental Iron, an artisan metal fabrication company in York, PA. 

This commit was restored from a 2018 backup of the project. The project was originally developed from 2015-2018. First priority is modernizing the codebase and updating dependencies. Following modernization, develop integration with ClockShark, Zapier, and Microsoft 365.

Old 2018 version required manual entry of granular timesheet data. New version will automatically track time and resources from webhooks on ClockShark events, and provide a user-friendly interface for manual adjustments. 

## To Do

- Add console route to create and register a new ULID

- [ ] Modernize codebase
- [x] Get test suite running
- [x] Spin up testing environment
- [x] Merge with Laravel

- [ ] Clockshark integration

## Not Yet Implemented

- ULIDs
- 1Password style key:value pair adding (GUI)
- Visual design: Notion + Deus Ex: Mankind Divided + Cyberpunk 2077
- Parallel deployment in CTI Networks

## Setup

```bash
docker exec -it index_app /bin/bash
composer install
chmod -R 775 storage

docker compose down
docker compose up --build
```