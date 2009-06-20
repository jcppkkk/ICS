#include <stdio.h>
#include <errno.h>


int main(){
    errno = EBUSY;
    perror(NULL);
    return 0;
}
