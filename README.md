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
  MAILER_DSN=gmail+smtp://USERNAME:PASSWORD@default
  ```  
  : make sure to Enable `Less Secure app access` in your Google account

## ReCAPTCHA
We use ReCaptcha V3 for this app. To use it:
 - Register your site on reCAPTCHA [here](https://www.google.com/recaptcha/admin/create) to get the `SITE_KEY` and `SECRET_KEY`
    1) Create a google account if you don't have one yet
    2) Select `v3` reCAPTCHA type
    3) Add the domain name of the application (Do not add https:// or http:// before the name, as well as any protocol, path, port, query or fragment after it)
    4) Submit the registration and copy the generated keys.
 - Replace `RECAPTCHA_SITE_KEY` and `RECAPTCHA_SECRET_KEY` in the `.env` file with the appropriate generated keys
 - For more information, visit the [documentation](https://developers.google.com/recaptcha/docs/v3)

## TODO
- Add a script to initialize the whole initial setup for convenience.
- Setup Docker to automate the development and deployment process.

## Best Practices
- Add Automation Testing e.g. Unit Tests, API/Functional Tests ([Codeception supports](https://codeception.com/))



