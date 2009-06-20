#!/bin/sh
(cd api;make clean;make)
mkdir  coretask
chmod o+w php/UIcache
chmod o+w coretask
