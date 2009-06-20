#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#define MAX 8000

void getTitle(char task_id[], int count, char* ptr_temp, FILE* file);

FILE* gettoken(int *count, char previous[], char current[] ,char *ptr, char task_id[]){
int i,k=0;
char *cmd,*ptr_temp=ptr;
char num[65542];
FILE *file;
static FILE *file2;

for ( ; (*ptr) != '\"' ; ++ptr ){
  current[k++]=(*ptr);
}
current[k]='\0';

if ( strcmp(previous,"") == 0 ){
    cmd=(char*)malloc(sizeof(char)*5000);
    sprintf(cmd,"mkdir -p data/%s",task_id);
    system(cmd);

    sprintf(cmd,"data/%s/index.html",task_id);
    file2=fopen(cmd,"w");
    fprintf(file2,"<html>\n<title>%s</title>\n<head><meta http-equiv=\"Content-Type\" content=\"text/html;charset=UTF-8\"></head>\n<body>\n",task_id);
    free(cmd);
}

if ( strcmp(previous,current) != 0 ){
strcpy(previous,current);
++(*count);

getTitle(task_id,(*count),ptr_temp, file2);

sprintf(num,"data/%s/page/%d",task_id,(*count));
cmd=(char*)malloc(sizeof(char)*(strlen("wget http://www.youtube.com")+strlen(current)+strlen(num)+1+4)); //add 4 for " -O "
sprintf(cmd,"wget http://www.youtube.com%s -O %s",current,num);
system(cmd);

sprintf(cmd,"sh youtube.sh %d data/%s/%d %s",(*count),task_id,(*count),task_id);
system(cmd);

sprintf(cmd,"data/%s/%s-%d.html",task_id,task_id,(*count));
file=fopen(cmd,"w");
fprintf(file,"<html>\n<title>%s</title>\n<head></head>\n<body>\n<embed src=\"flvplayer.swf\" width=\"450\" height=\"350\" allowfullscreen=\"true\" flashvars=\"&",task_id);
fprintf(file,"displayheight=300&file=%d.flv&height= 350&width=450&",(*count));
fprintf(file,"location=flvplayer.swf&autostart=false\" />\n</body>\n</html>");

fclose(file);
free(cmd);
}
return file2;
}

void getTitle(char task_id[], int count, char *ptr_temp, FILE* file){
char *ptr;
char title[MAX];
int k=0;
if ( (ptr=strstr(ptr_temp,"title=\"")) != NULL ){

    for ( ptr+=7 ; (*ptr) != '\"' ; ++ptr ){
     title[k++]=(*ptr);
    }
}
title[k]='\0';

fprintf(file,"<a href=%s-%d.html>%s</a><br>\n",task_id,count,title);

}

int main(int argc, char *argv[]){ //search word + task_id
char cmd[8000],path[8000];
FILE *file,*file2,*temp;
char buffer[MAX],previous[MAX]="",current[MAX]="";
char *ptr;
int count=0,i,task_id;
sprintf(path,"mkdir -p data/%s/page",argv[2]);
system(path);

sprintf(cmd,"wget \"http://www.youtube.com/results?search_type=&search_query=%s&aq=f\" -O %s",argv[1],argv[2]);
system(cmd);

sprintf(path,"rm data/%s/page/*",argv[2]);
system(path);


file=fopen(argv[2],"r");
while ( fgets(buffer,MAX,file) != NULL ){
    if ( (ptr=strstr(buffer,"/watch?v=")) != NULL ){
              temp=gettoken(&count,previous,current,ptr,argv[2]);
              if ( temp != NULL ) file2=temp;
    }
}
fclose(file);

fprintf(file2,"</body>\n</html>\n");
sprintf(cmd,"cp flvplayer.swf data/%s",argv[2]);
system(cmd);

fclose(file2);
return 0;
}


