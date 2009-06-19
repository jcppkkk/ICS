#include <stdio.h>
#include <string.h>
#include <unistd.h>
#include <fcntl.h>
#include <sys/stat.h>
#include <dirent.h>
#include <errno.h>

#define MAXLINE 80
#define MAX_SCHEDULER 200
#define IDSIZE 20
#define bool  int
#define true  1
#define false 0

static const char* dirname = "../coretask";
static const char* tmp_filename = "crontab.sh";

void err_sys(){
    perror(NULL);
    _Exit(1);
}

void err_quit(const char* str){
    puts(str);
    _Exit(1);
}

void format(char* cmd,const int* date,const char* buffer,const char* id){
    int i;
    char tmp[10];
    cmd[0]='\0';
    for(i=0;i<5;i++){
        if(date[i]==-1)
            strcat(cmd,"* ");
        else if(date[i]>0){
            snprintf(tmp,10,"%d ",date[i]);
            strcat(cmd,tmp);
        }else{
            err_quit("unkown time");
        }
    }
    strcat(cmd,"cd $ICSHOME; ");
    strcat(cmd,buffer);
}

void deal_content(char (*content)[MAXLINE],int* line,DIR* dp,struct dirent* dirp){
    if(dirp==NULL) return;
    else{
        FILE* fptr;
        char buffer[MAXLINE],cmd[MAXLINE],type[MAXLINE];
        char filename[MAXLINE];
        char id[IDSIZE];
        int i,n;
        char date[5][IDSIZE];
        int ntask; // min hour day mon week
        char option; // + - !
        if(strcmp(dirp->d_name,".")!=0 && strcmp(dirp->d_name,"..")!=0){
            strcpy(filename,dirname);
            strcat(filename,"/");
            strcat(filename,dirp->d_name);
            fptr=fopen(filename,"r");
            /*fetch*/
            cmd[0]='\0';
            fscanf(fptr,"Array ( ");
            while(fscanf(fptr,"[Task%d] => Array ",&ntask)){
                fscanf(fptr,"( [type] => %s ",type);
                fscanf(fptr,"[id] => %s ",id);
                fscanf(fptr,"[op] => %c ",&option);
                if(fscanf(fptr,"[month] => %s ",date[3])){
                    fscanf(fptr,"[day] => %s ",date[2]);
                    fscanf(fptr,"[week] => %s ",date[4]);
                    fscanf(fptr,"[hour] => %s ",date[1]);
                    fscanf(fptr,"[minute] => %s ",date[0]);
                    for(i=0;i<5;i++){
                        strcat(cmd,date[i]);
                        strcat(cmd," ");
                    }
                }else{
                    fscanf(fptr,"circle] => ");
                    fgets(cmd,MAXLINE,fptr);
                    cmd[strlen(cmd)-1] = '\0';
                    strcat(cmd," ");
                }
                strcat(cmd,"cd $ICSHOME; ");
                if(strcmp(type,"RSS")==0){
                    fscanf(fptr," [url] => ");
                    fgets(buffer,MAXLINE,fptr);
                    strcat(cmd,"./youtube ");
                }else if(strcmp(type,"CMD")==0){
                    fscanf(fptr,"[cmd] => ");
                    fgets(buffer,MAXLINE,fptr);
                }
                strcat(cmd,buffer);
                //printf("%s\n",cmd);
                //format(cmd,date,buffer,id);
                //fscanf(fptr,") [do] => ");
                //fgets(buffer,MAXLINE,fptr);
                fscanf(fptr," ) ");
                switch(option){
                case '+': // add
                    for(i=0;i<(*line);i++)
                        if(strcmp(content[i],cmd)==0)
                            break;
                    if(i==*line){
                        snprintf(content[(*line)++],MAXLINE,"#ICS task id = %s, comment\n",id);
                        strcpy(content[(*line)++],cmd);
                    }
                    break;
                case '-': // del
                    for(i=1;i<(*line);i++)
                        if(strcmp(content[i],cmd)==0 && content[i-1][0]=='#'){
                            content[i][0] = content[i-1][0] = '\0';
                            break;
                        }
                    break;
                case '!': // modify
                    break;
                default:
                    err_quit("unkown option");
                }
                cmd[0] = '\0';
            }
            errno = 0;
            /*fetch*/
            fclose(fptr);
            if(unlink(filename)==-1)
                err_sys();
            //char tmp9[255]="echo rm ";
            //strcat(tmp9, filename);
            //system(tmp9);
            puts(filename);
        }
        dirp = readdir(dp);
        deal_content(content,line,dp,dirp);
    }
}

int main(){
    int i,line;
    char content[MAX_SCHEDULER][MAXLINE];
    int pipe_fd[2];
    FILE* fptr,*tmp_fptr;
    struct dirent *dirp;
    DIR* dp;
    pid_t pid;
    if((dp=opendir(dirname))==NULL)
        err_sys();
    while((dirp=readdir(dp))!=NULL)
        if(strcmp(dirp->d_name,".")==0 || strcmp(dirp->d_name,"..")==0)
            continue;
        else
            break;
    if(dirp==NULL)
        _Exit(0);
    if((tmp_fptr=fopen(tmp_filename,"w"))==NULL)
        err_sys();
    if(pipe(pipe_fd)<0)
        err_sys();
    if((pid=fork())<0){
        err_sys();
    }else if(pid>0){ //parent , read from pipe
        close(pipe_fd[1]);
        if((fptr=fdopen(pipe_fd[0],"r"))==NULL)
            err_sys();
        for(line=0;fgets(content[line],MAXLINE,fptr)>0;line++);
        if(fclose(fptr)==-1)
            err_sys();
        if(waitpid(pid,NULL,0)<0)
            err_sys();
    }else{ //child , write to pipe
        close(pipe_fd[0]);
        if(pipe_fd[1] != STDOUT_FILENO){
            if(dup2(pipe_fd[1],STDOUT_FILENO) != STDOUT_FILENO)
                err_sys();
            close(pipe_fd[1]);
        }
        if(execl("/usr/bin/crontab","crontab","-l",NULL)<0)
            err_sys();
    }
    deal_content(content,&line,dp,dirp);
    if(closedir(dp))
        err_sys();
    for(i=0;i<line;i++)
        fprintf(tmp_fptr,"%s",content[i]);
    if(fclose(tmp_fptr)==-1)
        err_sys();
    if((pid=fork())<0){
        err_sys();
    }else if(pid>0){ //parent
        if(waitpid(pid,NULL,0)<0)
            err_sys();
    }else{ //child
        if(execl("/usr/bin/crontab","crontab",tmp_filename,NULL)<0)
            err_sys();
    }
    if(unlink(tmp_filename)==-1)
        err_sys();
    return 0;
}

