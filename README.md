


## About Project
### a project with laravel :-
  
  1- admin panel :
  
      - add,edit,soft delete courses, categories and tags.
      
      - the categories will have name and active to hide or show the categories on the website.
      
      - the courses have select category,name,description,rating integer,views as integer,levels as enum(beginner,immediate,high),hours as integer,active to hide or show the course on the website.
      
      - datatable for the view of two sections courses and categories.
  2- home page :
  
      - use ajax request for filtration and top search with pagination when page scroll down.
      
      - search for a specific course.
      
      - view top categories in slider.
  3- courses page :
  
      - view courses of specific category or tag.
      
  4- courses details page :
  
      - view course details [viwes count , rates , give rate , join or leave the course , tage list].
        
  5- login page :
  
      - login to user and admin account.
      
  6- register page :
  
      - register new user account.
  
      
  7- api :
  
      - register new user account.
      
      - login to user account.

      - view course details [viwes count , rates , give rate , join or leave the course , tage list].

      - get top categories.
      
      - search for a specific course.

      - view courses of specific category or tag.

  
   


## languages and technologies
### backend 
- php laravel
- mysql database

### frontend 
- HTML
- CSS,SCSS
- Javascript
- Jquery
- ajax 
- Bootstrap

## installation
1- download laravel packages :
  
      composer install

2- create your database and edit the .env file with new credentials :
  
      DB_DATABASE=your_database_name
      DB_USERNAME=your_database_username
      DB_PASSWORD=your_database_password

3- create database tables and factories :
  
      php artisan migrate --seed

4- run the project :
  
      php artisan serve

5- admin login :
  
      email     : admin@admin.com
      password  : 12345678


