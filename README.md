# auth-service
Repository for register &amp; auth users.
Also track events to external analytic service.
# how to start
- install 
[docker](https://docs.docker.com/install/)( 
[mac](https://docs.docker.com/docker-for-mac/),
[windows](https://docs.docker.com/docker-for-windows/)
) with 
[docker-compose](https://docs.docker.com/compose/install/)
- make sure that **80** port in **127.0.0.1** interface is free
- in the project dir run the next commands:
```bash
docker-compose up -d
open http://localhost
```

### Install vendors
```bash
composer install
```


### Rebuild images & recreate containers
```bash
docker-compose build --no-cache
docker-compose up -d --force-recreate
```

### To enable hot code refreshing in container follow instructions in ./docker-compose.yml


### Run test
```bash
./test
```

### RabbitMQ management
[http://localhost:15672/](http://localhost:15672/) **[guest:guest]**

### Documentation

- User can registrations via method `auth/registration`[post].
- User can login via method `auth/login`['post'].
- User can logout via method `auth/logout`['post'].

After every request will write analytics in `BaseController` `afterAction()`. Check user, if login to get `user id` and push task to `Queue`(FILE) else check `guest user id` or generate `guest user id` and push to Queue.

```
./yii queue/clear                Clears the queue.
./yii queue/exec                 Executes a job.
./yii queue/info (default)       Info about queue status.
./yii queue/listen               Listens file-queue and runs new jobs.
./yii queue/remove               Removes a job by id.
./yii queue/run                  Runs all jobs from file-queue.
```

```
./yii queue/listen  #this can write into crontab.
```