import phonenumbers
from phonenumbers import geocoder
ph1 = phonenumbers.parse("+91**********")

print("\nPhone Number's location :")
print(geocoder.description_for_number(ph1,"en"))

from phonenumbers import carrier
print(carrier.name_for_number(ph1,"en"))
