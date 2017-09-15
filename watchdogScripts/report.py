#!/usr/bin/env python

import json
import os

from datetime import datetime


class Report:
    """
    this class enables you to create and append reports stored in json format
    """
    def __init__(self, filename):
        self.fn = filename
        try:
            self.load(filename)
        except IOError:
            self.r = {}

    def load(self, filename):
        f = open(filename, 'r')
        self.r = json.loads(f.read())
        f.close()

    def save(self):
        f = open(self.fn, 'w')
        f.write(json.dumps(self.r, sort_keys=True, indent=4))
        f.close

    def addTest(self, name, result):
        """adds a test to the report"""

        if "tests" not in self.r:
            self.r.update({"tests": []})

        self.r["tests"].append({
            "name": name,
            "time": datetime.now().strftime("%H:%M"),
            "result": result
        })

    def addLog(self, name, text, result):
        """adds a log to the report"""

        if "logs" not in self.r:
            self.r.update({"logs": []})

        self.r["logs"].append({
            "name": name,
            "time": datetime.now().strftime("%H:%M"),
            "text": text,
            "result": result
        })

    def addLogFile(self, name, filename, cb=None):
        """ adds the content of a file to the report as log.

        the callback function is called with the log as argument and should
        return a state for the result.
        """
        try:
            fh = open(filename)
            log = fh.read()
            fh.close()
        except IOError:
            log = "=== logfile not available ==="

        if cb is not None:
            result = cb(log)
        else:
            result = ""

        self.addLog(name, log, result)

    def addDiskUsage(self, path, name):
        if "disks" not in self.r:
            self.r.update({"disks": []})

        try:
            stat = os.statvfs(path)
            size = stat.f_bsize * stat.f_blocks / 1024 / 1024
            free = stat.f_bsize * stat.f_bfree / 1024 / 1024
            used = (size - free) * 100 / size
        except OSError:
            self.r["disks"].append({
                "mount": path,
                "name": name,
                "mounted": False
            })
        else:
            self.r["disks"].append({
                "mount": path,
                "name": name,
                "mounted": True,
                "size": str(size) + " MB",
                "free": str(free) + " MB",
                "used": str(used) + "%"
            })

    def __str__(self):
        return json.dumps(self.r, sort_keys=True, indent=4)
