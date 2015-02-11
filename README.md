# test
fuelphp test

##Installation step by step

###clone from repository
```
git clone https://github.com/liversohn/test
cd test
```

###setup submodules
```
git submodule init
git submodule update
```

###download composer for fuel core and update
```
cd fuel/core
curl -sS https://getcomposer.org/installer | php
php composer.phar update
```

###setup apache docroot into test/public
###setup host for the vhost in /etc/hosts

run the host in browser