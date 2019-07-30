# Search restaurant nearby project

This is a project to apply for a job at SCG. Create a simple web application to show the list of Restaurants by using Google Map
API which user can enter the keyword to search.

I have used Zend Expressive 3 as an API endpoint to communicate with Google Map API and store all locations in our own database (MySQL) in order to not often pull request to the API if that location has been searched before. And I also use VueJS as a frontend framework to communicate with API.

## Getting Started

### Prerequisities
In order to run this container you'll need docker installed.

* [Windows](https://docs.docker.com/windows/started)
* [OS X](https://docs.docker.com/mac/started/)
* [Linux](https://docs.docker.com/linux/started/)


## Configuration

Before running the website, please make sure that you don't forget to update your Google API Key in both of the following files.

On the client side, you need to create .env file. I already provide a .env.example file in the root directory of client which is easy to adjust.
```env
VUE_APP_ROOT_API=http://localhost:8080/
VUE_APP_GMAP_KEY=YOUR_GOOGLE_KEY
```

On the server side, you need to update your key in /server/config/autoload/local.php
```php
return [
    'page_size' => 6,
    'key_api' => 'YOUR_GOOGLE_KEY',
];
```

## Quick start

You can easily run this project by 

```bash
# Clone the repository
git clone https://github.com/inupoppox/search-restaurant-nearby-project

# Go inside the directory
cd search-restaurant-nearby-project

# Run docker
docker-compose up --build
```

## Services

Service                | Port | Usage
-----------------------|------|------
Client (Frontend)      | 3000 | When using `docker-compose`, visit `http://localhost:3000` in your browser
API (Backend)          | 8080 | API service will run on  `http://localhost:8080`
DB                     | 6603 | -

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

