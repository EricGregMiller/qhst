#!/bin/sh
# replace the variable below with the location of your Apache2 installation
APACHE2=$HOME/apache2
$APACHE2/bin/apxs  -i -a -c  mod_pgheader.c
