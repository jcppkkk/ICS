/*
 * Name:
 * Version: 1.0
 * Last modified: 2009-06-06 10:09
 * Author: §E©|­õ ccu495410102 ¸ê¤u¤Tb
 * E-mail: comet.jc@gmail.com
 */

#include <stdio.h>
#include <stdlib.h>
#include <math.h>
int main(int argc, char *argv[]){
    char* s="test HAHA";
    FILE *fp=fopen(argv[1], "w");
    fputs(s, fp);
    fclose(fp);
}
