
# Mali - Project & Financial Management System

A comprehensive Project Control and Financial Control system for a contracting inspection company.

## 📋 Project Overview

This software is a professional **Project Control + Financial Project Control** system that enables company management to monitor and control contracts, projects, progress, man-days, costs, revenue, invoices/payment certificates, collections, and project profitability.

## ✨ Key Features

- **Project Management**: Full CRUD for projects with unique project codes
- **Contracts**: Contract, amendment, and adjustment management
- **WBS**: Hierarchical Work Breakdown Structure
- **Progress Control**: Recording and tracking project progress with variance analysis
- **Man-Day Control**: Tracking man-day consumption against progress (productivity)
- **Cost Control**: Recording direct costs and comparing them against the budget
- **Payment Certificates**: Managing invoices/payment certificates, approvals, and collections
- **Financial Forecasting**: EAC using three models (Progress-based, Budget-based, Manual)
- **Profitability**: Calculating net profit and profit margin at both project and company levels
- **Automatic Alerts**: Generating alerts for critical variances
- **Reports**: 7+ filterable reports with Excel/PDF/CSV export
- **Excel Import/Export**: Data import and export
- **Dashboard**: At-a-glance display of key KPIs
- **Full API**: RESTful API for integrations
- **RBAC**: Role-Based Access Control (9 roles)
- **Audit Log**: Logging all sensitive changes
- **RTL + Persian**: Fully Persian and right-to-left user interface

## 🛠 Technology Stack

### Backend

- PHP 8.3+
- Laravel 12+
- Laravel Eloquent ORM
- Laravel Queues & Scheduler
- Laravel Policies/Gates
- RESTful API

### Database

- MySQL 8+

### Frontend

- Laravel Blade + Livewire
- Alpine.js
- Tailwind CSS
- Chart.js
- Vazirmatn Font

### Libraries

- Laravel Excel (maatwebsite/excel)
- DomPDF (barryvdh/laravel-dompdf)
- Laravel Permission (spatie/laravel-permission)

## 📊 Project Statistics

| Section | Count |
| --- | --- |
| Migrations | 23 |
| Models | 23 |
| Services | 14 |
| Controllers | 24 |
| Policies | 4 |
| Validation Requests | 20 |
| Livewire Components | 13 |
| Blade Views | 29 |
| Seeders | 7 |
| Factories | 6 |
| Unit Tests | 10 |
| Feature Tests | 2 |
| Persian Language Files | 11 |
| Config Files | 2 |
| Imports | 6 |
| Exports | 5 |
| **Total Files** | **213** |

## 🏗️ Directory Structure

```
mali/
├── app/
│   ├── Models/ (23 Eloquent models)
│   ├── Services/ (14 business services)
│   ├── Http/
│   │   ├── Controllers/ (Web + API)
│   │   ├── Requests/ (Validation)
│   │   ├── Livewire/ (Interactive components)
│   │   └── Resources/
│   ├── Policies/ (Access control policies)
│   ├── Exports/ (Excel exports)
│   ├── Imports/ (Excel imports)
│   ├── Console/Commands/ (Artisan commands)
│   └── helpers.php (Helper functions)
├── database/
│   ├── migrations/ (23 migrations)
│   ├── seeders/ (7 data seeders)
│   └── factories/ (6 factories)
├── resources/
│   ├── views/ (29 Blade views)
│   ├── css/ (Stylesheets)
│   └── js/ (JavaScript)
├── routes/
│   ├── web.php (Web routes)
│   └── api.php (API routes)
├── config/
│   ├── mali.php (System configuration)
│   └── permissions.php (Permissions)
├── lang/fa/ (11 translation files)
├── tests/ (Unit + Feature)
├── storage/app/public/documents/ (Documents)
└── public/ (Public assets)
```

## 📦 Requirements

- PHP 8.3+
- MySQL 8+
- Composer
- Node.js & NPM
- Git

## 🚀 Installation & Setup

### 1\. Clone the Project

```
git clone <repository-url> mali
cd mali
```

### 2\. Copy the Environment File

```
cp .env.example .env
```

### 3\. Install Dependencies

```
composer install
npm install && npm run build
```

### 4\. Generate the Application Key

```
php artisan key:generate
```

### 5\. Run Migrations

```
php artisan migrate
```

### 6\. Seed Initial Data

```
php artisan db:seed
```

### 7\. Create the Storage Link

```
php artisan storage:link
```

### 8\. Start the Server

```
php artisan serve
```

Then visit `http://localhost:8000`.

## 🔐 Default Login Credentials

- **Email**: admin@mali.ir
- **Password**: password

## 👥 User Roles

| Role | Description |
| --- | --- |
| Super Admin | System administrator |
| CEO | Chief Executive Officer |
| Finance Manager | Finance manager |
| Project Manager | Project manager |
| Controller | Project controller |
| Accountant | Accountant |
| Financial Expert | Financial expert |
| Inspector | Inspector |
| Viewer | Read-only user |

## 📈 Key Performance Indicators (KPIs)

The system calculates the following KPIs for each project:

1. **Time Progress**: Percentage of contract duration elapsed
2. **Actual Progress**: Percentage of work completed
3. **Man-Day Consumption**: Man-days consumed relative to the contract
4. **Man-Day Productivity**: Man-day consumption relative to project progress
5. **Cost Consumption**: Actual cost relative to the budget
6. **Progress Variance**: Difference between actual and planned progress
7. **Cost Variance**: Difference between actual cost and budget
8. **Payment Certificate Approval**: Percentage approved
9. **Collection Rate**: Percentage collected
10. **Outstanding Receivables**: Approved amount minus collected amount
11. **EAC**: Estimated final project cost
12. **Forecasted Profit**: Projected profit
13. **Profit Margin**: Profitability percentage
14. **Project Status**: Normal / Warning / Critical

## 🔔 Alert System

The system automatically generates the following alerts:

- ⚠️ **Progress Alert**: When actual progress falls behind the planned schedule
- ⚠️ **Man-Day Alert**: When man-day consumption exceeds the allowed threshold
- ⚠️ **Cost Alert**: When costs exceed the budget
- ⚠️ **Profit Alert**: When the profit margin reaches a critical range
- ⚠️ **Collection Alert**: When an approved payment certificate has not been collected

## 📊 Available Reports

- Project Status Report
- Cost Report (Budget vs. Actual)
- Man-Day Report
- Payment Certificate Report
- Collection Report
- Forecast Report (EAC)
- Profitability Report
- Project P&L Report

All reports can be filtered and exported to Excel/PDF/CSV.

## 🔧 Configurable Settings

All alert thresholds can be configured through the database:

- Progress Warning Threshold: Default -5%
- Progress Critical Threshold: Default -10%
- Cost Warning Threshold: Default 5%
- Cost Critical Threshold: Default 10%
- Man-Day Warning Ratio: Default 1.00
- Man-Day Critical Ratio: Default 1.15
- Minimum Warning Profit Margin: Default 25%
- Minimum Critical Profit Margin: Default 15%

## 🔒 Security

- CSRF Protection
- XSS Protection
- SQL Injection Protection
- Authorization using Policies
- Password Hashing (bcrypt)
- Rate Limiting
- Secure File Upload with MIME validation
- Audit Log for all sensitive changes
- Soft Deletes for sensitive financial data

## 🌐 Internationalization Features

- ✅ Fully Persian RTL user interface
- ✅ Vazirmatn font
- ✅ Jalali calendar
- ✅ Configurable currency (Rial/Toman/USD/EUR)
- ✅ Thousands separators for financial figures

## 🔄 Import/Export

### Excel Import

Users can import the following data from Excel:

- Projects
- Contracts
- Progress
- Man-Days
- Costs
- Payment Certificates

### Excel Export

All system data can be exported to Excel/CSV/PDF.

## 🧪 Testing

```
# Run all tests
php artisan test

# Run Unit tests
php artisan test --testsuite=Unit

# Run Feature tests
php artisan test --testsuite=Feature
```

Unit tests cover core financial logic, including:

- EAC calculation
- Profitability calculation
- Project status evaluation
- Variance calculations
- Alert thresholds

## 📅 Maintenance & Backup

### Backup Strategy

- **Daily Backup**: Database
- **Weekly Backup**: Entire system
- **Document Backup**: External storage

### Dashboard Optimization

- Query optimization with Eager Loading
- Indexing on Foreign Keys
- Caching for dashboard data
- Pagination for large lists
- Aggregation queries for calculations

## 🚀 Future Development

The system architecture is designed to support the addition of the following modules:

- Payroll & Compensation
- HR & Human Resources Management
- CRM & Customer Relationship Management
- Procurement & Purchasing
- Multi-Currency
- Multi-Company
- Mobile Application
- SMS/Email/WhatsApp Notifications
- Advanced BI

## 📝 License

Proprietary - All rights reserved.

## 👨‍💻 Developer

The system was developed by the technical team of the contracting inspection company.

## 📞 Support

For reporting issues or requesting new features, please contact the technical team.

---

**Version**: 1.0.0 