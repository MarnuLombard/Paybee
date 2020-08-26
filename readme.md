# PayBee Bot
 _This guide assumes a Debian 9 host_
## Host setup
**SET UP THE REPOSITORY**

* Update the apt package index:
```bash
$ sudo apt-get update
```
* Install packages to allow apt to use a repository over HTTPS:
```bash
$ sudo apt-get install \
    apt-transport-https \
    ca-certificates \
    curl \
    gnupg2 \
    software-properties-common
```

* Add Docker’s official GPG key:
```bash
$ curl -fsSL https://download.docker.com/linux/debian/gpg | sudo apt-key add -
```
* Add the repo to your sources
```bash
$ sudo add-apt-repository \
   "deb [arch=amd64] https://download.docker.com/linux/debian \
   $(lsb_release -cs) \
   stable"
```
<hr>

**INSTALL DOCKER**

* Update apt repos
```bash
$ sudo apt-get update
```

* Install Docker and containerd
```bash
$ sudo apt-get install docker-ce docker-ce-cli containerd.io
```

* Verify that everything installed okay
```bash
$ sudo docker run hello-world
```

<hr> 

**INSTALL DOCKER-COMPOSE**  
*Latest version at time of writing is 1.24.0, substitute that if needed*  

```bash
sudo curl -L "https://github.com/docker/compose/releases/download/1.24.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose \
  && sudo chmod +x /usr/local/bin/docker-compose
```

<hr>

**CONFIGURING THE PROJECT**  

* Edit your env file to reflect your current environment
```bash
$ cp .env.example .env \
    && vim .env
```

* Ensure that the following values match
```dotenv
DB_HOST=mariadb
REDIS_HOST=redis
```

<hr>

**GET THE PROJECT RUNNING**

* Clone the infrastructure git repository
```bash
$ git clone git@bitbucket.org:marnulombard/paybee-infrastructure.git \
  && cd paybee-infrastructure
```

* Clone the Application git repository
```bash
$ git clone git@bitbucket.org:marnulombard/paybee.git nginx/www/
```
* Get the ssl certificates  
<small>_We have a chicken and egg situation, we can't start nginx without ssl certs, but we can't get the ssl certs without starting nginx. This script will create a dummy cert, start up the container and then request a letsencrypt cert for us_</small>
```bash
$ ./init-letsencrypt.sh
```

* Start up the containers
```bash
$ docker-compose start
# Or if you are confident that it will start without errors, 
# send the process to the background:
$ docker-compose start -d
```
**Please note the current infrastructure does a ssl certificate install for [paybee.co.za](https://paybee.co.za) - so without modifications this step may fail**
