<p align="center"><img src="public/assets/Sign DLOR.webp" width="350"></p>
<p align="center" style="font-size:20px;font-weight:600">WELCOME TO DASKOM LABORATORY RECRUITMENT 2025
</p>
<br>

## About DLOR 2025  
_Open Recruitment Platform for Dasar Komputer Laboratory, Telkom University_

Welcome to the **DLOR 2025** repository! This project is dedicated to creating a modern, user-friendly platform for recruiting teaching assistants for the **Dasar Komputer Laboratory** at **Telkom University**.

## Project Summary  
DLOR 2025 is a recruitment platform designed to streamline the application process for teaching assistants. It features an intuitive UI, a secure backend, and an efficient application workflow.

## Features  
- User-friendly application form  
- Secure authentication system  
- Real-time updates on application status  
- Admin dashboard for managing recruitment  

## Tech Stack  
- **Frontend**: Blade (Laravel templating engine)  
- **Backend**: PHP (Laravel framework)  
- **Database**: SQLite

## Team Members  
**UI/UX Design:**  
- [Aulia Rahma](https://github.com/pieceofaul) (AUL)  

**Frontend Development:**  
- [Stevannie Pratama](https://github.com/stevanniep) (SNI)  
- [Umar Zaki Gunawan](https://github.com/marzkigun27) (UZY)  

**Backend Development:**  
- [Muhammad Zaenal Abidin Abdurrahman](https://github.com/Zendin110206) (ZEN)  
- [Muhammad Hafiz](https://github.com/mhafiz03) (MHZ)  

## Getting Started  
Follow these steps to set up the project on your local machine.

### Prerequisites

- **PHP 8.2**
- **Node.js** (or pnpm or yarn or bun)
- **Laravel 11**
- (Optional) **Laragon** (Recommended for Windows users)

### Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/Daskom-Lab/daskomrec25
   cd DLOR2025
   ```

2. Setup:
   Install dependecies:
   ```bash
   composer install
   npm install # or pnpm i, yarn, bun
   ```
   Copy `.env.example` and paste it as `.env` or just `cp .env.example .env`

   Edit `APP_URL` into `APP_URL=http://localhost:8000` in `.env`

   Setup key option and database:
   ```bash
   php artisan key:generate
   php artisan migrate
   ```

3. Run the project:
   Run in two terminals:
   ```bash
   npm run dev
   ```
   and other is:
   ```bash
   php artisan serve
   ```

4. Edit the project:
Access the platform at: `http://localhost:8000`