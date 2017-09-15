#!/usr/bin/env python

# This script is based on hg-ssh, hgssh2, hgssh3 and hgadmin
#
# This software may be used and distributed according to the terms of the GNU
# General Public License version 3 or any later version.
#
# hg-ssh.py - Thomas Arendsen Hein <thomas@intevation.de>
#             copyright 2005 - 2007 Intevation GmbH
#             <intevation@intevation.de>
#
# hgssh2.py - modified by <kofreestyler@gmail.com>
#
# hgssh3.py - modified by <chaubner@chrishaubner.com>
#
# hgadmin   - <https://bitbucket.org/JakobKrainz/hgadmin>
#
# hgguard   - Alex Warhawk <w4rh4wk@catbull.com>

"""
hgguard.py manages access control for your mercurial repositories through a
single ssh user.

~/.ssh/authorized_keys:
    command="/opt/hgguard/hgguard.py USER
    /path/to/hgguard.cfg",no-port-forwarding,no-X11-forwarding,no-agent-forwarding
    ssh-rsa KEY

hgguard.cfg:
    [groups]
    alpha = alice, bob
    bravo = jim, jack

    [myrepo1]
    location = repos/my_repo_number_1
    @alpha = read
    jim = write

    [myrepo2]
    location = repos/my_other_repo
    @brave = read
    will = write

access:
    $ hg clone ssh://hg@example.com/myrepo1

"""

from mercurial import demandimport; demandimport.enable()
from mercurial import dispatch

import ConfigParser
import logging
import os
import shlex
import sys


def reject_push(ui, **kwargs):
    ui.warn("Permission denied\n")
    return True


def get_permissions(repository, config):
    cfg = ConfigParser.SafeConfigParser()
    cfg.optionxform = str
    cfg.read(config)

    if not cfg.has_section(repository):
        return {}

    perm = dict(cfg.items(repository))

    # resolve groups
    groups = [x for x in perm if x[0] == '@']

    for g in groups:
        try:
            # recover members listed in group section
            members = [
                x[1].split(',')
                for x in cfg.items("groups")
                if x[0] == g[1:]
                ][0]

            # remove whitespaces
            members = [x.strip() for x in members]

            # add members to perm
            for m in members:
                perm[m] = perm[g]
        except IndexError:
            sys.stderr.write("Group \"%s\" used but not defined\n" % g[1:])
            continue
        except KeyError:
            sys.stderr.write("No groups defined but used\n")
            sys.exit(1)
        finally:
            # remove group entry
            perm.pop(g)

    return perm


def main():
    user = sys.argv[1]
    conf = sys.argv[2]

    # get original ssh command
    orig_cmd = os.getenv('SSH_ORIGINAL_COMMAND', '?')

    try:
        cmdargv = shlex.split(orig_cmd)
    except ValueError as e:
        sys.stderr.write("Illegal command \"%s\": %s\n" % (orig_cmd, e))
        sys.exit(1)

    if cmdargv[:2] != ['hg', '-R'] or cmdargv[3:] != ['serve', '--stdio']:
        sys.stderr.write("Illegal command \"%s\"\n" % orig_cmd)
        sys.exit(1)

    repo = cmdargv[2].replace(os.sep, '', 1)
    perm = get_permissions(repo, conf)

    if not len(perm):
        sys.stderr.write("Repository \"%s\" not found\n" % repo)
        sys.exit(1)

    if 'location' not in perm:
        sys.stderr.write("Repository \"%s\" has no location\n" % repo)
        sys.exit(1)

    path = os.path.normpath(os.path.join(
        os.getcwd(),
        os.path.expanduser(perm['location'])
        ))

    if (user not in perm) or (perm[user] not in ['read', 'write']):
        sys.stderr.write("Access denied to \"%s\"\n" % repo)
        sys.exit(1)

    cmd = ['-R', path, 'serve', '--stdio']

    if perm[user] == 'read':
        cmd += [
            '--config',
            'hooks.prechangegroup.hg-ssh=python:__main__.reject_push',
            '--config',
            'hooks.prepushkey.hg-ssh=python:__main__.reject_push'
            ]

    dispatch.dispatch(dispatch.request(cmd))

if __name__ == '__main__':
    main()
