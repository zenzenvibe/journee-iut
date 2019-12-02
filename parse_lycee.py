#!/bin/python2.7

import csv

with open('liste_lycees.csv') as csv_file:
    csv_reader = csv.reader(csv_file, delimiter=';')
    dep=""
    for row in csv_reader:
        print "[",
        for entry in row:
            print '"'+entry+'",',
        print "],"
