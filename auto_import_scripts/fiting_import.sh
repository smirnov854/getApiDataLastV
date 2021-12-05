#!/bin/bash
  
SITE="xn-----8kchiwcarcvfu1bf4h7b.xn--p1ai"
JOB_ID=7
KEY="JfqIh-j"
LOGFILE=/home/c/cf08116/public_html/logs/wp-all-import.log
CURLOG=/home/c/cf08116/public_html/wp-all-import-$JOB_ID.tmp
ROOT_DIR=/home/c/cf08116/public_html
DONE=0
  
function log {
  echo "$(date): $*" >>$LOGFILE
}
  
echo "WP All Import:" $SITE " job id:" $JOB_ID
cd $ROOT_DIR
log "Start import for job id $JOB_ID"
  
php -e -r 'parse_str("import_key='$KEY'&import_id='$JOB_ID'&action=trigger", $_GET); include "wp-cron.php";' >>$LOGFILE 2>&1
sleep 1
  
while [ $DONE -eq 0 ]
do
  php -e -r 'parse_str("import_key='$KEY'&import_id='$JOB_ID'&action=processing", $_GET); include "wp-cron.php";' >$CURLOG 2>&1
  cat $CURLOG >>$LOGFILE
  DONE=$(grep 'is not triggered' $CURLOG | wc -l)
  sleep 1
done
rm $CURLOG
  
log "End of import for jobId" $JOB_ID
log ""
log ""