#include <stdlib.h>
#include <stdio.h>

int main(int argc, char *argv[]){
	FILE *a= fopen(argv[1], "w");
	char *s="*/1 * * * * $HOME/test/a.out";

	fprintf(a, "%s", s);
	fclose(a);
	return 0;
}
