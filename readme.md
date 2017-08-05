## Wilste Verhuur

Hieronder een globaal overzicht wat er nog moet gebeuren.


### Tactiek
- Een RESTFUL API zodat het verhuur volledig los staat van welke site/cms/systeem dan ook. 
- Op basis van inwisselbare modules aan de hand van Dependency Injection.
- Goede documentatie van de routes
- Als in de toekomst dit systeem vervangen wordt en duidelijke heldere uitleg wat er moet gebeuren.
- Teksten moeten multi-talig zijn

### Todo

#### Eerste fase
- API - Datumbeheer (CRUD) - Done
- API - Optiebeheer (CRUD)
- Api - Bookingbeheer (CRUD)
- App - Massa datum input (ik wil alle weekenden erin zetten van nu tot 2018)
- App - Formulier voor gebruiker om een optie neer te zetten
- Mail naar beheerder met info over optie
- Mail met samenvatting naar gebruiker
- Overzicht van alle opties
- Het kunnen boeken van een optie, waardoor:
    - Status veranderd
    - Geen opties meer kunnen gezet worden op die datum
    - Mail wordt verstuurd met gebruiker met kosten
- Het kunnen annuleren van een boeking, waardoor    
    - Status veranderd
    - Weer opties kunnen gezet worden op die datum
    - Mail wordt verstuurd naar gebruiker
    
#### Tweede fase
- Het kunnen beheren (CRUD) van extra opties, zoals internet, banken en tafels
- Aanpassen van de mails zodat dit allemaal meegenomen wordt

### Done
+ Data aanmaken (api)
+ Opties aanmaken voor een datum (api)
+ Van een optie een boeking kunnen maken (api)
+ Routes naar een API
+ oAuth voor admin
+ Adminlogin

    
# Documentatie

## API

#### Openbaar

```POST     | api/login      ```           
         
Het inloggen van een user op API met OAuth2

#### Achter de OAuth2

```POST     | api/logout```

Het uitloggen van een user op API met OAuth2

```POST     | api/refresh```

Refresh de access token van de gebruiker

```GET|HEAD api/dates```

Het ophalen van alle toekomstige verhuurdata. 

```GET|HEAD | api/dates/{id}```

Het ophalen van een toekomstige datum met het id van {id}

```POST     | api/dates/{id}/options```

Het posten van een optie voor datum met id van {id}

``` POST     | options/{id}/bookings```

Het posten van een booking voor optie met id van {id}

## Routes
```GET|HEAD | dates/{id}/options```

Toon een formulier om een optie neer te zetten




