#!/usr/bin/env python
import spidev
import MySQLdb
import time
spi = spidev.SpiDev()
spi.open(0,0)
spi.max_speed_hz = 122000
db = MySQLdb.connect("localhost","vladimir","vladimir","test")
cur = db.cursor()

def readadc(adcnum):
    if ((adcnum > 7) or (adcnum < 0)):
        return -1
    r = spi.xfer2([1,(8+adcnum)<<4,0])
    adcout = ((r[1]&3) << 8) + r[2]
    return adcout


    #for adcInput in range(0,1):

value = readadc(0)
voltage = value * 3.3
voltage /= 1024.0
tempCelsius = (voltage-0.5)*100
print ("Temperatura: ", tempCelsius)

#sql = ("""INSERT INTO test_temperatura(Valoare) VALUES (%s)"""),(round(tempCelsius,2),)
args = (1,round(tempCelsius,2), ' ', ' ', ' ' )
cur.callproc('sp_addtemperature', args)
cur.fetchall()

cur.close()
db.close()
            


