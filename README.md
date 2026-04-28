# Dynamic Approval Workflow System

A simple Laravel web application for managing dynamic approval workflows.

The system allows admin users to create dynamic forms with different fields, define approval workflow steps, allow normal users to submit approval requests, and allow approvers to approve or reject pending requests.

## Task Scope

### Admin Features

- Create dynamic forms.
- Add different input fields for each form.
- Define approval workflow steps for each form.
- Assign approvers with approval order.

### User Features

- View available active forms.
- Fill and submit approval requests.
- View submitted requests history.
- Track request status.

### Approver Features

- View pending approval requests.
- View past approvals.
- Approve or reject pending requests.
- Add optional comments.

## Tech Stack

- Laravel
- Laravel Breeze
- Livewire
- Blade
- MySQL
- Service Classes
- Form Requests
- PHP Enums

## Implementation Notes

- Simple role-based access using a `role` column in the `users` table.
- No database enum columns were used.
- Statuses, roles, field types, and actions are stored as tiny integers.
- PHP Enums are used in the code for readability.
- The workflow is sequential.
- Each approval step has one approver.

## Roles

| Role | Value |
|---|---:|
| Admin | 1 |
| User | 2 |
| Approver | 3 |

## Supported Field Types

| Field Type | Value |
|---|---:|
| Text | 1 |
| Number | 2 |
| Date | 3 |
| Textarea | 4 |
| Select | 5 |

## Approval Request Statuses

| Status | Value |
|---|------:|
| Pending |     1 |
| Approved |     2 |
| Rejected |     3 |
| Withdrawn |     4 |

## Approval Actions

| Action     | Value |
|------------|------:|
| Approved   |     1 |
| Rejected   |     2 |

## Database Tables

Main tables added:

- `forms`
- `form_fields`
- `approval_workflow_steps`
- `approval_requests`
- `approval_request_values`
- `approval_actions`
- `approval_request_steps`

## Workflow Logic

1. Admin creates a form.
2. Admin adds dynamic fields.
3. Admin defines approval workflow steps.
4. User submits a request using the form.
5. Request starts as pending.
6. The current approver can approve or reject.
7. If approved, the request moves to the next step.
8. If the last step is approved, the request becomes approved.
9. If rejected at any step, the request becomes rejected.
10. Users can withdraw their approval requests before the request is fully approved.

## Setup Instructions

### 1. Clone the project

```bash
git clone https://github.com/Mohammed-Rashed/cyberagoraTest.git
cd cyberagoraTest

### 1. Install PHP dependencies
composer install

### 2. Install frontend dependencies
npm install

### 3. Create environment file
cp .env.example .env

On Windows:
copy .env.example .env

### 4. Generate application key
php artisan key:generate

### 5. Configure database

Update .env file:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cyberagora_test
DB_USERNAME=root
DB_PASSWORD=

### 6. Run migrations
php artisan migrate

Or reset the database:
php artisan migrate:fresh

### 7. Run seeders
php artisan db:seed

---

## Database Dump

A database dump is attached with the project for quick testing or download from this link 
[https://drive.google.com/file/d/10WJmsgQvZapTjzK79hKJthxeORQEeFHB/view?usp=sharing]

