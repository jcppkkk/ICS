#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <libxml/xmlmemory.h>
#include <libxml/parser.h>
#include <fcntl.h>

void parseDoc(char *docname, char* taskid);
void parseItem(xmlDocPtr doc, xmlNodePtr cur, FILE *file);

int main(int argc, char* argv[]){
char *docname,*taskid;

if ( argc != 3 ){ fprintf(stderr,"error using! \n"); exit(1); }

docname = argv[1];
taskid= argv[2];
parseDoc(docname,taskid);
return 0;
}



void parseItem(xmlDocPtr doc, xmlNodePtr cur, FILE *file){

xmlChar *title=NULL, *link=NULL, *pubDate=NULL, *description=NULL;
cur=cur->xmlChildrenNode;

fprintf(file,"\n");

while ( cur != NULL ){

if ( !xmlStrcmp(cur->name,(const xmlChar*)"title") ){
    title= xmlNodeListGetString(doc, cur->xmlChildrenNode, 1);
    }
else if ( !xmlStrcmp(cur->name, (const xmlChar*)"link")){
    link = xmlNodeListGetString(doc, cur->xmlChildrenNode, 1);
}
else if ( !xmlStrcmp(cur->name, (const xmlChar*)"pubDate") ){
    pubDate = xmlNodeListGetString(doc, cur->xmlChildrenNode,1);
}
else if ( !xmlStrcmp(cur->name, (const xmlChar*)"description")){
    description= xmlNodeListGetString(doc, cur->xmlChildrenNode,1);
}

cur=cur->next;
}
if ( title != NULL && link != NULL ){
    fprintf(file,"<p><a href=\"%s\">%s</a>\n",(char*)link,(char*)title);
    free(title);
    free(link);
    title=NULL;
    link=NULL;
}

if ( pubDate != NULL ){
   fprintf(file,"<br><font color=\"red\">Update time: %s</font>\n",(char*)pubDate);
   free(pubDate);
   pubDate=NULL;
}

if ( description != NULL ){
    fprintf(file,"<p>%s<Hr Align=\"Left\"|\"Center\"|\"Right\">",(char*)description);
    free(description);
    description=NULL;
}

return ;
}

void parseDoc(char *docname, char *taskid){
FILE *file;
xmlDocPtr doc;
xmlNodePtr cur;
char *buffer;
struct flock lockp;

doc= xmlParseFile(docname);
if ( doc == NULL ){
 fprintf(stderr,"Document not parsed successfully. \n");
 return ;
}

cur = xmlDocGetRootElement(doc);

if ( cur == NULL ){
 fprintf(stderr, "empty document\n");
 xmlFreeDoc(doc);
 return ;
}

if ( xmlStrcmp(cur->name, (const xmlChar*)"rss")  ){

fprintf(stderr,"document of the wrong type, root node != channel");
xmlFreeDoc(doc);
return;
}
if ( (cur=cur->xmlChildrenNode) != NULL ){
    cur=cur->next;
    if ( xmlStrcmp(cur->name,(const xmlChar*)"channel") ){
        fprintf(stderr,"error tag!\n ");
        exit(1);
    }
}
else{
   fprintf(stderr,"error rss tag! \n");
   exit(1);
}
buffer=(char*)malloc(strlen("mkdir -p")+(strlen("data//index.html")+strlen(taskid)+1)*sizeof(char));
sprintf(buffer,"mkdir -p data/%s",taskid);
system(buffer);
sprintf(buffer,"data/%s/index.html",taskid);

if ( (file=fopen(buffer,"w")) == NULL ) fprintf(stderr,"file can't be opened!\n");
fcntl(fileno(file), F_GETLK, &lockp);
free(buffer);

fprintf(file,"<html>\n<title>Feed content</title>\n<head><meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\"></head>\n<body>\n");
cur=cur->xmlChildrenNode;
int count=0;
while ( cur != NULL && count < 21 ){
 if ( !xmlStrcmp(cur->name, (const xmlChar *)"item")){
     parseItem(doc, cur, file);
     ++count;
 }
 cur=cur->next;
}
fprintf(file,"</body>\n</html>");
xmlFreeDoc(doc);
fcntl(fileno(file) ,F_UNLCK, &lockp);
fclose(file);
return ;
}
