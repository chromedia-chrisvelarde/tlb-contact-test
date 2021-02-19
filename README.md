# TLB Contact Form App
for testing purposes only

<img src="contact-page.png" width="400" />

## Requirements
- PHP 7.2
- Symfony 5.2
- MySQL

## Setup

- copy and edit .env file

    `cp .env.dist .env`

- install

    `composer install`

## DataBase Setup
- create the DB, ensure to enter your db credentials on .env file

    `bin/console doctrine:database:create`

- migrations

    `bin/console doctrine:migrations:migrate`

- update db for other bundle's requirements, e.g. `Oauth2`

    `bin/console doctrine:schema:update --force`
    
## Server
- start the web server

    `symfony server:start`

- open the app
    
    `http://127.0.0.1:8000`

- contact page

    `http://127.0.0.1:8000/contact`

## API
- Add a client

    `bin/console trikoder:oauth2:create-client  <client_id> <client_secret>`
    
- Authenticate - get token

    ```sh
      curl -X POST \
        http://127.0.0.1:8000/token \
        -H 'content-type: application/x-www-form-urlencoded' \
        -d 'grant_type=client_credentials&client_id=<client_id>&client_secret=<client_secret>'
    ```

- Endpoints
    
    > Fetch collection of contacts
    
        GET /api/v1/contact HTTP/1.1
        Host: 127.0.0.1:8000
        Authorization: Bearer <token>
    
    > Create Contact
        
        POST /api/v1/contact HTTP/1.1
        Host: 127.0.0.1:8000
        Authorization: Bearer <token>
        Content-Type: application/json
        {
            "fname": "string",
            "lname": "string",
            "email": "string",
            "message": "string"
        }
    
- Api Documentations
    
    `http://127.0.0.1:8000/api/doc`
    
    <img src="api-doc.png"/>
## Mailer
- We use (gmail ) 3rd party mailer transport for development only.
  > .env
  
  ```nashorn js
  MAILER_DSN=gmail://USERNAME:PASSWORD@default
  ```  
  : make sure to Enable `Less Secure app access` in your Google account


## TODO
- Add a script to initialize the whole initial setup for convenience.
- Setup Docker to automate the development and deployment process.

## Best Practices
- Add Automation Testing e.g. Unit Tests, API/Functional Tests ([Codeception supports](https://codeception.com/))



