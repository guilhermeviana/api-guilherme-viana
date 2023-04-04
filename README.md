Clone os Arquivos do Laravel
```sh
git clone https://github.com/guilhermeviana/api-guilherme-viana.git
```

```
```sh
cd app-laravel/
```

Crie o Arquivo .env
```sh
cp .env.example .env
```

Suba os containers do projeto
```sh
docker-compose up -d
```

Acessar o container
```sh
docker-compose exec app bash
```

Instalar as dependências do projeto
```sh
composer install
```

Gerar a key do projeto Laravel
```sh
php artisan key:generate
```

Migrar o banco de dados
```sh
php artisan migrate --seed
```

Subir queue de importação do .csv
```sh
php artisan queue:work --queue=import
```

Arquivo .json contendo as requisições está na raiz do projeto:
```sh
endpoints.json
```

Arquivo .csv para importar no request de importação está na raiz do projeto:
```sh
import.csv
```
