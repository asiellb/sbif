# SBIF API
Libreria que permite consultar el valor de indicadores al API de la superintendencia de bancos e instituciones financieras (SBIF) de Chile.
Pueden acceder a los siguientes indicadores:

- Dólar
- Euro
- UF
- UTM
- IPC

Además se puede acceder a [información de bancos](#información-de-bancos) de Chile.

## Obtener API key
Para usar el API de la SBIF debes obtener tu APIKEY en la siguiente página:
http://api.sbif.cl/api/contactanos.jsp

## Instalación
Para instalar la librería ejecuta el siguiente comando en la consola:
```bash
composer require asiellb/sbif
```

**[Instalación y Uso en Laravel](#instalación-y-uso-en-laravel)**

## Uso de forma Standalone
Si tu sistema no trabaja con Laravel puedes usarlo de forma directa:

```php
use Kattatzu/Sbif/Sbif;

$sbif = new Sbif('SBIF API KEY');
// o
$sbif = new Sbif;
$sbif->apiKey('SBIF API KEY');

echo $sbif->getDollar('2017-04-30');
//664.0
```

### Indicadores disponibles
```php
$date = Carbon::today();

$sbif->getDollar($date);
$sbif->getEuro($date);
$sbif->getUTM($date);
$sbif->getUF($date);
$sbif->getIPC($date);
// NOTA: El IPC solo tiene valor hasta el mes anterior

// Si no envias una fecha se toma la fecha actual
$sbif->getDollar();
```

También puedes consultar de forma dinámica
```php
$sbif->getIndicator(Sbif::IND_EURO, $date);
```

Constantes disponibles
```php
Sbif::IND_UF
Sbif::IND_UTM
Sbif::IND_DOLLAR
Sbif::IND_EURO
Sbif::IND_IPC
```
Puedes acceder al resto de los datos que disponibiliza la SBIF (http://api.sbif.cl/que-es-api.html) enviando directamente el endpoint que corresponda:
```php
var_dump($sbif->get("/resultados/2009/12/instituciones"));

object(stdClass){
    "DescripcionesCodigosDeInstituciones": [
        "0" => {
            "CodigoInstitucion": "001",
            "NombreInstitucion": "BANCO DE CHILE"
        },
        "1" => {
            "CodigoInstitucion": "014",
            "NombreInstitucion": "SCOTIABANK CHILE"
        },
        ...
    ]
}
```

### Información de Bancos
Puedes consultar la información que disponibiliza la SBIF sobre los bancos de Chile.
```php
$info = $sbif->getInstitutionData('001');
echo $info->name;
// BANCO DE CHILE
```

Puedes obtener la información como un array:
```php
$info = $sbif->getInstitutionData('001')->toArray();
var_dump($info);
```
```php
[
  "code" => "001",
  "name" => "BANCO DE CHILE",
  "swift_code" => "BCHI CL RM",
  "rut" => "97.004.000-5",
  "address" => "AHUMADA 251",
  "phone" => "(56-2) 653 11 11",
  "website" => "www.bancochile.cl",
  "public_contact" => "Pamela Valdivia",
  "public_address" => "Huérfanos 980, 8º Piso, Santiago",
  "public_phone" => "(56-2) 653 06 73",
  "branches" => 403,
  "employees" => 11426,
  "publication_date" => "2017-05-01",
  "cashiers" => 1412
]
```

Para obtener el listado de códigos puedes usar la clase Institution:
```php
use Kattatzu\Sbif\Institution;

var_dump((new Institution)->getInstitutions());
```
```php
[
  "001" => "Banco de Chile",
  "009" => "Banco Internacional",
  "014" => "Scotiabank Chile",
  "016" => "Banco de Credito E Inversiones",
  "028" => "Banco Bice",
  "031" => "HSBC Bank (chile)",
  "037" => "Banco Santander-chile",
  "039" => "Itaú Corpbanca",
  "049" => "Banco Security",
  "051" => "Banco Falabella",
  "053" => "Banco Ripley",
  "054" => "Rabobank Chile",
  "055" => "Banco Consorcio",
  "056" => "Banco Penta",
  "504" => "Banco BBVA",
  "059" => "Banco BTG Pactual Chile",
  "012" => "Banco del Estado de Chile",
  "017" => "Banco Do Brasil S.A.",
  "041" => "JP Morgan Chase Bank, N. A.",
  "043" => "Banco de la Nacion Argentina",
  "045" => "The Bank of Tokyo-mitsubishi UFJ",
  "060" => "China Construction Bank"
]
```
## Instalación y Uso en Laravel

Después de hacer la instalación con Composer debes registrar el ServiceProvider y el alias en tu archivo config/app.php:
```php
'providers' => [
    ...
    Kattatzu\Sbif\Providers\SbifServiceProvider::class,
],
'aliases' => [
    ...
    'Sbif' => Kattatzu\Sbif\Facades\SbifFacade::class,
]
```

Publica el archivo de configuración ejecutando en Artisan:
```shell
php artisan vendor:publish --provider="Kattatzu\Sbif\Providers\SbifServiceProvider"
```

Ya puedes ingresar tu API Key en el archivo de configuración config/sbif.php o en en archivo .env con la key SBIF_API_KEY.
```shell
SBIF_API_KEY=xxxxxxxxxxxxxxxxxxxx
```

### Facades
Ya puedes usar el Facade para acceder de forma rápida a las funciones:
```php
Sbif::getDollar();
Sbif::getUTM('2017-06-30');
Sbif::getUF(Carbon::today());
```
### Helpers
También puedes utilizar los helpers:
```php
sbif_dollar();
sbif_euro('2017-06-30');
sbif_utm(Carbon::yesterday());
sbif_uf(Carbon::now()->subMonth(1));
sbif_ipc();
sbif_institution('001')->name;
sbif_institutions();
```

No dudes en enviarme tus feedbacks o pull-request para mejorar esta librería.

## Créditos
Fork de versión desarrollada por https://github.com/kattatzu
