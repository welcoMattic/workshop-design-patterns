Practical Design Patterns With Symfony
======================================

[🔗 Slides link](https://docs.google.com/presentation/d/1mUq9xvSERlznu3O-67Qw3hHJ5cwTRgkpodF9niZfpCM/edit?usp=sharing)

# Installation

1. Clone the repository:

```shell
git clone git@github.com:welcoMattic/workshop-design-patterns
cd workshop-design-patterns
```

## With Symfony CLI

0. Check Symfony requirements

```shell
symfony check:requirements
```

1. Install the dependencies

```shell
symfony composer install
```

2. Start the dev server

```shell
symfony serve -d
```

## With docker

You can use this project with Docker by

1. Build the Docker image for the project
```shell
docker build --tag workshop:latest .
```

2. Install dependencies
```shell
docker run --rm -ti -v "`pwd`:/var/www/html" workshop:latest composer install
```

3. Start the web server
```
docker run --rm -ti -p 8123:80 --name workshop -v "`pwd`:/app" workshop:latest
```

4. Open the website on `http://localhost:8123`
