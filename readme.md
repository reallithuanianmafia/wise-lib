# Library Book Registration Web Application

## Overview

A web application for managing book registrations in a library. It is built with Symfony for the backend and Vue.js for the frontend. The application includes features for user authentication, book registration, management, and a responsive user interface.

![App Screenshot](https://i.ibb.co/mykqW9g/a1.png)
![App Screenshot](https://i.ibb.co/Bz7DxND/a2.png)


## Table of Contents

- [Backend Requirements](#backend-requirements)
- [Frontend Requirements](#frontend-requirements)
- [Setup Instructions](#setup-instructions)
- [Usage](#usage)
- [Testing](#testing)
- [Contributing](#contributing)
- [License](#license)

## Backend Requirements

### User Authentication

- Implement basic authentication for library employees.
- Authenticated users have access to book registration and management functionalities.

### Book Registration

- Form fields: Title, Author, ISBN, Publication Date, Genre, Number of Copies.
- Form validation to ensure all fields are correctly filled.

### Book Management

- Display a list of all registered books.
- Allow employees to edit and delete book entries.

### Database

- Managed with Doctrine ORM.
- Includes schema for storing book information.


## Frontend Requirements

### User Interface

- Built with Twig templating engine.
- Responsive design for various devices.

### Vue.js Functionality

- Client-side form validation.
- AJAX requests using Axios.
- Dynamic book list with search and pagination.

## Setup Instructions

### Installation Steps

   ```bash
   git clone https://github.com/yourusername/library-book-registration.git

   cd library-book-registration 

   composer install

   php bin/console doctrine:database:create

   php bin/console doctrine:migrations:migrate

   npm install npm run build symfony server:start

   git clone https://github.com/yourusername/library-book-registration.git

   cd library-book-registration
