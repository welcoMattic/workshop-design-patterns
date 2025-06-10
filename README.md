Practical Design Patterns With Symfony
======================================

[Slides link](https://docs.google.com/presentation/d/1luwHGo3te25Z025XMYrkg4Ta70U8UlU0RQAk5aCBDSI/edit?usp=sharing)

Installation
------------

Clone the repository:

```shell
git clone git@github.com:alexandresalome/workshop-design-patterns
cd workshop-design-patterns
```

Install the dependencies:

```shell
composer install
```

And run Symfony from it:

```
symfony serve
```

With docker
-----------

You can use this project with Docker by:

```
# Building the Docker image for the project
docker build --tag workshop:latest .

# Install dependencies
docker run --rm -v "`pwd`:/var/www/html" workshop:latest composer install

# Start the web server
docker run --rm -p 8123:80 --name workshop -v "`pwd`:/app" workshop:latest
```
