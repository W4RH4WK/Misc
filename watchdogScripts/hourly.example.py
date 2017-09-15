#!/usr/bin/env python

# cd
import os
os.chdir(os.path.dirname(os.path.abspath(__file__)))

from report import Report
from datetime import datetime

r = Report("files/" + datetime.now().strftime("%Y-%m-%d") + ".json")

r.addTest(
    "Internet Connection",
    os.system("ping 8.8.8.8 -c 1") == 0
)

r.save()
