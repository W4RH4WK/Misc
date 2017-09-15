#!/bin/bash

LOG="$HOME/backup/logs/$(date +%F).log"
FROM="/mnt/files"
TO="/mnt/backup"
RSYNC="/usr/bin/rsync -rti --omit-dir-times --modify-window=2"

function err {
    echo "Error: $@" >&2
}

function quit {
    echo "<< $(date +%T)" >> $LOG
    exit $1
}

exec 2>>$LOG

echo ">> $(date +%T)" >> $LOG

if ! mount | grep $TO >> /dev/null;then
    if ! mount $TO;then
        err "$TO not mounted"
        quit 1
    fi
fi

if ! mount | grep $FROM >> /dev/null;then
    if ! mount $FROM;then
        err "$FROM not mounted"
        quit 1
    fi
fi

$RSYNC $FROM/ $TO 2>> $LOG

quit 0