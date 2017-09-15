#!/bin/bash

mv web/* .
mv web/.* .
rmdir web
sed -i 's/\/\.\.//g' index.php

echo '--------------------------------------------------'
echo '  content moved from web to root                  '
echo '--------------------------------------------------'
