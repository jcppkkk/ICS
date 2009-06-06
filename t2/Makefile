# Common make definitions, customized for each platform

# Definitions required in all program directories to compile and link
# C programs using gcc.

#WKDIR=$$PWD
#CC=gcc
#LDLIBS=./lib/libapue.a $(EXTRALIBS)
#CFLAGS=-ansi -I$(WKDIR)/include -L$(WKDIR)/lib -Wall -DBSD -lpthread $(EXTRA)
#COMPILE.c=$(CC) $(CFLAGS)-c

PROGS = oo


TEMPFILES=core core.* *.o temp.* *.out typescript*

all: $(PROGS)

clean:
	@rm -f $(PROGS) *.o
