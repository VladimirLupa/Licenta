import spidev
import time
import math
spi = spidev.SpiDev()
spi.open(0,0)
spi.max_speed_hz = 488000

def readadc(adcnum):
    if ((adcnum > 7) or (adcnum < 0)):
        return -1
    r = spi.xfer2([1,(8+adcnum)<<4,0])
    adcout = ((r[1]&3) << 8) + r[2]
    return adcout

while True:
    for adcInput in range(2,3):
        value = readadc(adcInput)
        voltage = value * 3.3
        voltage /= 1024.0
        humidity = -9.931 * math.log(voltage)+29.339
        print "---------------------------"
        print "Umiditatea este ", humidity
    time.sleep(0.5)
