#include <stdio.h>
#include <unistd.h>

int main(){
    FILE* fptr = fopen("buf1","a");
    fputs("a.c\n",fptr);
    fclose(fptr);
    write(STDOUT_FILENO,"Hello world!\n",13);
    return 0;
}
