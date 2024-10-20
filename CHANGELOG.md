# Changelog
## [0.5.0] - 2024-10-19

### Added
- All pages secured with modern authentication

### Changed
- Migrate to blade templating engine
- Created public directory and moved all public files there

## [0.3.4] - 2018-06-13

- Reduced visual clutter of Jobs page by making fields more lightweight
- ProjectSummary() stored procedure incorporated into Production Board timed update
- Jobs marked “Completed” now cache their insights data in the database

## [0.3.3] - 2018-06-12

- Job information in list now has a new look, visually displays material type and job status, also whether estimate data is entered or not
- Fixed issue where user could not enter new jobs
- Old bandwidth-heavy production board deprecated in favor of faster, more lightweight JSON/REST powered one.

## [0.3.2] - Sunday, June 10, 2018

- Job Page now has "insights" feature
- Production Board now shows 30% profit margin as a gap on the side
- New design
- Job page is now separated into major sections
- Added estimate costing and costing functionality
- Added itemized estimate list
- Added profit margin insight
- Added estimated bill for customer

## About this file

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).