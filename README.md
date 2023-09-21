# Ecommerce WEBAPP
An e-commerce web application based on symfony (a php framework) that covers all the fundamental functionalities requested by my internship supervisor. this was my first step into web development and it got me excited about the field and software development in general.

## Features
- Products and categories management (for Admin) : the application provides an admin dashboard that allows the administrators to manage all the data related to products, categories , subcategories and much more

- Authentication and user management : the users of the app are provided with a session based authentication to allow users to conserve their personal data securely

- Buying items : in order to purchase items a user should submit his shopping cart containing the the selected items and carry on with the payment

## Tools used in the project

- Symfony : we used symfony php framework to communicate with our database and render webpages for the user along with most the functionalities of the application. it also provided many useful libraries like easyadmin for the admin dashboard and doctrine as an ORM

- html/css/twig : we used html and css to create webpages that interact with the user and twig helped in providing data sent from symfony to the html pages. Twig also provided ready to use javascript functionalities that were needed for the code.

- MySql : the app relies on a MySql server for the database

##what can be improved

- An implementation of a real payment method instead of a fake testing one

- adding a delivery system to the application

- recreating the user interfaces using a modern frontend framework instead of rendering twig html pages via symfony

##how to use

you need to have symfony and composer installed in your machine to run this project

symfony: https://symfony.com/download

composer: https://getcomposer.org/download/

once you have these two you should clone the project:

```bash
git clone https://github.com/sorrow112/ecommerce_summer_project.git
```

then you move into the folder where you have the project on your console and install the dependecies then run the project

```bash
composer install
symfony server:start
```

if something didn't work properly you can consult the symfony documentation for a step by step guide : https://symfony.com/doc/current/index.html

##contact me

via email: jguirimahmed112@gmail.com
