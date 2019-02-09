. ./humidity.config
curl --location-trusted -X GET https://developer-api.nest.com/devices/thermostats/$NestDevice/humidity -H "Authorization: Bearer $NestBearer" -H "Content-Type: application/json"