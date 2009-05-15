#include<stdio.h>

int main(int argc,char* argv[]){
    //FILE* file=fopen("/.amd_mnt/cs1/host/csdata/home/under/u96/ljh96u/test/note.txt","a");
    FILE* file=fopen("XD","r+");
    fprintf(file,"%s\n",argv[1]);
    fclose(file);
    //printf("execed a.out");
    return 0;
}

