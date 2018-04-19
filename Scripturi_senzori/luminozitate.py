import spidev
import time
spi = spidev.SpiDev()
spi.open(0,0)
spi.max_speed_hz = 122000

def readadc(adcnum):
    if ((adcnum > 7) or (adcnum < 0)):
        return -1
    r = spi.xfer2([1,(8+adcnum)<<4,0])
    adcout = ((r[1]&3) << 8) + r[2]
    return adcout

while True:
    for adcInput in range(1,2):
        value = readadc(adcInput)
        value /= 10.24
        print "---------------------------"
        print "Luminozitatea este", value
        
    time.sleep(5)   