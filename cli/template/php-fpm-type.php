root <?= $this["source"];?>;

location / {
    try_files $uri $uri/ /index.php?$args;
}

location ~ \.php$ {
    fastcgi_pass unix:/tmp/<?= $this["uname"];?>-fpm.sock;
    fastcgi_index index.php;
    include fastcgi_params;
}