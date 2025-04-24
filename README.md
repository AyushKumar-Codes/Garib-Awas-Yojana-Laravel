# MIS for Rural Development Housing Scheme (Garib Awas Yojana) with GIS Integration

This project aims to develop a **Management Information System (MIS)** for tracking rural housing schemes such as **Garib Awas Yojana**. The system integrates **Geographic Information System (GIS)** capabilities to improve the tracking, monitoring, and allocation of housing projects, ensuring better implementation and transparency in the process.

## Features

- **Tracking and Monitoring:** Track and monitor housing scheme projects such as Garib Awas Yojana.  
- **GIS Integration:** Visualize housing project data on a map using GIS functionalities.  
- **Dashboard View:** Display housing project details like project name, tracking ID, allocation status, etc.  
- **Pagination:** Efficient pagination for viewing a large number of submissions.  
- **Project Details:** View detailed information about each project, including geographic location, allocation details, and status.  
- **Responsive Design:** The application is designed to be responsive, working well on both desktop and mobile devices.  

## Prerequisites

Before setting up this project, make sure you have the following installed:

- **PHP >= 7.3**  
- **Composer**  
- **Laravel 8.x or above**  
- **MySQL** or any other database of your choice  
- **Node.js** and **NPM** for managing front-end dependencies  
- **GIS-related libraries** for map and location integration  

## Installation

Follow these steps to set up the project on your local machine:

### 1. Clone the Repository

```bash
git clone https://github.com/AyushKumar-Codes/Garib-Awas-Yojana-Laravel.git
2. Install Dependencies

cd mis-rural-housing
composer install
npm install
3. Configure the Environment

cp .env.example .env
Update the .env file with your database configuration:

env
Copy
Edit
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
4. Generate Application Key

php artisan key:generate
5. Run Migrations

php artisan migrate
6. Start the Development Server

php artisan serve
The application will be available at http://127.0.0.1:8000.

7. (Optional) Compile Front-End Assets

npm run dev
Usage
Viewing Housing Scheme Projects
Navigate to the home page (/) to view the list of housing schemes.

The list will display key information such as Tracking ID, Project Name, Status, and Location.

Use the pagination controls to navigate through the list of projects.

GIS Integration
The application integrates GIS to visualize the geographical location of each project.

A map displays markers corresponding to the housing project locations.

Clicking on a marker provides additional details about the project.

Contributing
We welcome contributions to improve this project! To contribute:

Fork the repository.

Create a new branch:


git checkout -b feature/your-feature
Make your changes and commit them:


git commit -am 'Add your feature'
Push to your branch:


git push origin feature/your-feature
Open a pull request to the main repository.

License
This project is licensed under the MIT License. See the LICENSE file for details.

Acknowledgements
Special thanks to the Laravel community for the framework.

Thanks to GIS libraries for map visualizations.

PHP, Composer, and Node.js for managing dependencies.

Open-source mapping libraries for integrating GIS functionalities.