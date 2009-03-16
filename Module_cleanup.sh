#!/bin/bash

PHP_FILES=`find . -name *.php`

for FILE in $PHP_FILES
do
    sed -i -e '/^.*\$Horde: .*\$.*$/D' $FILE
    sed -i -e 's/PHP version 4/PHP version 5/' $FILE
    sed -i -e 's/^\(class .*\)\s*{\s*$/\1\n{/' $FILE
    sed -i -e 's/\s$//' $FILE
done
