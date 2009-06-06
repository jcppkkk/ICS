#include<stdio.h>
#include<unistd.h>
#include<sys/stat.h>
#include<stdlib.h>

void add(){
}

char* config_string(){

}


void sys_err(const char* str){
    printf("%s",str);
    exit(1);
}

/*core_config*/
/*error_log*/
int main(int argc,char* argv[]){
	FILE* core_file = fopen("core_config","r+");
	if(core_file==NULL) return;
	FILE* log_file = fopen("error_log","a");
	FILE* tmp_file = fopen(argv[1],"w");
    //fprintf(argv[1]);
    fclose(tmp_file);
	fclose(core_file);
	fclose(log_file);
	return 0;
}

