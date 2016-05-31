## GetPanel
### "GetPanel" - Admin Panel for ANY existing mysql database!

[![Build Status](https://travis-ci.org/prkeshri/getpanel.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/prkeshri/getpanel/downloads)](https://packagist.org/packages/prkeshri/getpanel) 
[![Latest Stable Version](https://poser.pugx.org/prkeshri/getpanel/v/stable)](https://packagist.org/packages/prkeshri/getpanel) 
[![Latest Unstable Version](https://poser.pugx.org/prkeshri/getpanel/v/unstable)](https://packagist.org/packages/prkeshri/getpanel) [![License](https://poser.pugx.org/prkeshri/getpanel/license)](https://packagist.org/packages/prkeshri/getpanel)

GetPanel is a web application built on [laravel Framework](http://laravel.com/). It is a ready to use admin panel for any already built database! Yes, just setup and you are ready to go.

This is currently in `Beta` and development. My goal make it fit for organisations, enabling multiple users with customised privilages. This is in progress. Currently, users can be added( by the master user after the initial user registration, they can be added to groups (called user_groups), now these groups can have permissions specific to pages (i.e. update/edit/delete etc.)

## Features
- Simple settings for an existing database and ready to insert/edit/delete existing/new data!
- Appropriate controls to feed data based on formats (Ex. for text/number: text ,date : [Calendar control](https://www.google.co.in/url?sa=t&rct=j&q=&esrc=s&source=web&cd=1&cad=rja&uact=8&ved=0ahUKEwin_tK49v_MAhXHsY8KHcNqCUcQFggbMAA&url=https%3A%2F%2Feonasdan.github.io%2Fbootstrap-datetimepicker%2F&usg=AFQjCNE7i60Qnfge78DBgfH7yO3VTGW2bQ&bvm=bv.123325700,d.c2I), enum values:combobox etc. is used.
- For foreign key columns(Combobox is used in order to feed data based on text. Ex: user_id pointing to '*id*' of *users* table, having '*name*' etc. column. Now, the combobox would display names of users.
- Foreign keys refering tables with large data are paged using a new window.
- Provision to input data with 'set' data type.
-  Multiple users(Presently in progress) and controlling who can edit/insert/view page data!

## Official Documentation

Creating. Will publish soon.
## How to install/use?
##### Installation 
- Clone this repository.
- This uses composer. Make sure you have it. If not, goto [https://getcomposer.org/doc/00-intro.md](), and install it. I assume that you have set its path and we only require the 'composer' command. If you have it locally, use 'php composer.phar' instead of 'composer'.
- run `composer install`. This would install all the dependencies(including the Laravel framework!).
##### Configuration
- There would be 2 different configurations! 1st will be source_connection which is the database where our tables lie actually! 2nd one may be a database connection or a file system configuration where we would store all our table/page settings.
- 1st config:
  - Go to 'config/database.php' and set values into the default mysql connection. (In or near line 55) 'mysql' => [... Set the values host,database,username,password. Don't change driver and other options.
- 2nd config: You may skip it if you  wish to save in the 'file system'.
  - Go to 'congig/basic.php' and set 'save_in' to 'database' if you wish to save into the db!. In this case, set the database,username,password,table. Note, this 'table' must have 2 columns 'key' which would be varchar(300), and 'val' which would be 'LONGTEXT'
##### Last Steps
- Now we are good to go. Point into appropriate settings (i.e. with nginx/apache/etc. to folder 'public/'
- Hit the ip/domain into the browser. It would prompt for a new user(which would become the master admin). After submitting, it would open the home page.
- For the simplest configuration, click on the "Click here to proceed."
- Again, click on "I understand. Click here to proceed!"
- This would bring the list of every existing table in the source db. Click on "Click here to generate a page for every table.".
- Now, Click on the title "GetPanel". This would bring the home page showing each and every page with options!

### License

The software is open-sourced software licensed under the [GNU GPLv3 license](http://www.gnu.org/licenses/gpl-3.0.en.html)
