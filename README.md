<div id="top"></div>




<!-- PROJECT SHIELDS -->
<!--
*** I'm using markdown "reference style" links for readability.
*** Reference links are enclosed in brackets [ ] instead of parentheses ( ).
*** See the bottom of this document for the declaration of the reference variables
*** for contributors-url, forks-url, etc. This is an optional, concise syntax you may use.
*** https://www.markdownguide.org/basic-syntax/#reference-style-links
-->

<p align="center">
    <a>
        <img src="https://img.shields.io/github/commit-activity/m/mwaura21/Food-Ordering-System">
    </a>
    <a>
        <img src="https://img.shields.io/github/languages/count/mwaura21/Food-Ordering-System">
    </a>
    <a>
        <img src="https://img.shields.io/github/languages/top/mwaura21/Food-Ordering-System">
    </a>
        <a>
        <img src="https://komarev.com/ghpvc/?username=mwaura21">
    </a>
</p>


<!-- PROJECT LOGO -->
<br />
<div align="center">

  <h3 align="center">Food Ordering System</h3>

  <p align="center">
    A project done during my 4th year as as IT student!
    <br />
  </p>
</div>



<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## About The Project

A simple Web Application that allows users to log and make an order from a list of avaialable local vendors in the area.

This project is intended to promote local vendors who do not have a platform or enough recognition in order to sell to a whole variety of people. It also promotes cheap healthy food options since it presents a number of options one can choose from instead of the traditional fast food options that are always available.

All one requires is an account and they are able to place an order, choose the delivery location and the order is sent to the vendor to start preparing your order.


<p align="right">(<a href="#top">back to top</a>)</p>



### Built With

Below is what I used to create this project of mine. Feel free to give suggestions on what more I could use. Thanks. :)

* [HTML](https://html.com/)
* [Javascript](https://www.javascript.com/)
* [Laravel](https://laravel.com)
* [Bootstrap](https://getbootstrap.com)
* [JQuery](https://jquery.com)

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- GETTING STARTED -->
## Getting Started

To get a local copy up and running follow these simple example steps.

### Prerequisites

This is a list of software you need and where to download them:

* npm
  ```sh
  npm install npm@latest -g
  ```
* php 7.3+
  ```sh
  Click this link and follow the instructions. [https://www.php.net/downloads.php] 
  ```
* composer
  ```sh
  Click this link and follow the instructions. [https://getcomposer.org/doc/00-intro.md#:~:text=Installation%20%2D%20Windows%23&text=This%20is%20the%20easiest%20way,Note%3A%20Close%20your%20current%20terminal]
  ```
* image intervention
  ```sh
  Click this link and follow the instructions. [https://image.intervention.io/v2/introduction/installation#integration-in-laravel]
  ```
* xampp
  ```sh
  Click this link and follow the instructions. [https://www.ionos.com/digitalguide/server/tools/xampp-tutorial-create-your-own-local-test-server/]
  ```

### Installation

_How to install and setting up my app._
 
1. Clone the repo
   ```sh
   git clone https://github.com/mwaura21/Food-Ordering-System.git
   ```
2. Go to the folder application using cd command on your cmd or terminal
   ```sh
   cd C:/project-folder/project-name
   ```
4. Run composer install on your cmd or terminal
   ```sh
   composer install
   ```
5. Copy .env.example file to .env on the root folder
   ```sh
   _copy .env.example .env_ - For Windows Command Prompt
   _cp .env.example .env_ - For terminal Ubuntu
   ```
6. Open your .env file and change the database name (DB_DATABASE) to whatever you have, username (DB_USERNAME) and password (DB_PASSWORD) field correspond to your configuration.

7. Run
   ```sh
   php artisan key:generate
   php artisan migrate
   php artisan serve
   ```
8. Go to http://localhost:8000/


<!-- CONTACT -->
## Contact

Daniel Mwaura - mwauradaniel80@gmail.com

Project Link: [https://github.com/mwaura21/Food-Ordering-System](https://github.com/mwaura21/Food-Ordering-System)

<p align="right">(<a href="#top">back to top</a>)</p>


