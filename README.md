# Airslate

## Overview

It's mini-project, wrote on a pure php, that allows you to do the CRUD operations with the addresses

## Installation

To install and set up the project, follow these steps:

1. Clone the repository:
    ```bash
    git clone https://github.com/laptevARTEM/Airslate.git
    ```

2. Navigate to the project directory:
    ```bash
    cd Airslate
    ```

3. Run the project via docker-compose:
    ```bash
    docker-compose up -d --build
    ```
   Then, the website will be accessible on URL http://localhost:8080

4. Also, you can run this project on a build-in php server:
    ```bash
    php -S localhost:8000 -t public/
    ```
   In this case you need to change mysql credentials in /config/db.php to yours.

   Then, the website will be accessible on URL http://localhost:8000