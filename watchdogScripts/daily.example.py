#!/usr/bin/env python

import os
import re

from datetime import datetime


# cd
os.chdir(os.path.dirname(os.path.abspath(__file__)))
from report import Report


# log checker
def logcheck(log):
    r = re.compile(r"(^>> .*$\n)|(^<< .*$\n)", re.M)
    return len(r.sub("", log)) == 0


r = Report("files/" + datetime.now().strftime("%Y-%m-%d") + ".json")

r.addDiskUsage("/", "system")

#r.addLogFile(
#    "Backup",
#    "/root/backup/logs/" + datetime.now().strftime("%Y-%m-%d") + ".log",
#    logcheck
#)

r.save()
