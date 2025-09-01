# Edu Assessment System

A Core PHP application to manage student records with RESTful API endpoints, MySQL database, and AJAX interactions.

## Setup Instructions

### 1. Prerequisites
- PHP 8.3+ with MySQL extension
- MySQL Server
- Web server (e.g., Apache with mod_rewrite)

### 2. Config
- Input database details in the file app/src/Config
  
### 3. Database Setup
- Create the database:
  ```bash
  mysql -u your_username -p < schema.sql
