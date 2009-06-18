#include <stdio.h>

int main(){
    FILE* fptr = fopen("buf2","a");
    fputs("b.c\n",fptr);
    fclose(fptr);
    return 0;
}
