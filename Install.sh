#!/bin/sh
(cd api;make clean;make)
(mkdir  coretask ; chmod o+w coretask;) 2> /dev/null
(mkdir php/UIcache; chmod o+w php/UIcache; rm php/UIcache/*;) 2> /dev/null

