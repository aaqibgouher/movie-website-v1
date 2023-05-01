# MOVIE WEBSITE V1
This is a simple movie website. It includes list of movies, detail of any movie, similar results, favourites. If we want to add in favourite, we have to login first. 

## Frontend
Vue JS, Vuetify
## Backend
Laravel
## Database
MySQL

## Installation
### Frontend
1. Step 1: Open your terminal and navigate to the root directory of the cloned repository.
2. Step 2: npm install
3. Step 3: npm run serve
4. Step 4: npm run serve 

**Note:** Before running the npm install command, make sure you have Node.js and npm (Node Package Manager) installed on your system.

### Backend
1. Step 1: Open the terminal and navigate to the project directory.
2. Step 2: composer install
3. Step 3: cp .env.example .env
4. Step 4: php artisan key:generate
5. Step 5: Set the OMDB API key in the .env file by adding the following line: OMDB_API_KEY=your-omdb-api-key.
6. Step 6: Set up the database in the .env file. Update the following lines with your database information:
          DB_DATABASE=your_database_name
          DB_USERNAME=your_database_username
          DB_PASSWORD=your_database_password
7. Step 7: Run the migrations: php artisan migrate.
8. Step 8: Serve the application: php artisan serve or use a web server like Apache or Nginx.
9. Step 9: Open a web browser and navigate to the URL provided by the Laravel development server.

We are good to go now!
