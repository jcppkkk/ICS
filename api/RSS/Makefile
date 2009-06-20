main:
	gcc -o  rss `pkg-config --cflags --libs libxml-2.0` xmlreader.c
# Common temp files to delete from each directory.
TEMPFILES=*.o temp.* *.out typescript*

PROGS = rss

all: $(PROGS)

clean:
	rm -f $(PROGS) *.o
