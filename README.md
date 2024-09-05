project pos


git clone https://github.com/darkjin34/project_pos.git project_pos

cd project_pos

docker-compose build && docker-compose up -d

//Configure the PHP
docker-compose exec php composer install
docker-compose exec php php artisan migrate

//Copy the .env.example and add .env